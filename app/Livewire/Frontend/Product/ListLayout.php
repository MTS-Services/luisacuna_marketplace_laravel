<?php

namespace App\Livewire\Frontend\Product;

use App\Models\Product;
use Livewire\Component;
use App\Enums\FeedbackType;
use Livewire\Attributes\Url;
use App\Services\GameService;
use App\Services\OrderService;
use App\Services\ProductService;
use App\Services\PlatformService;
use App\Traits\WithPaginationData;
use Illuminate\Support\Facades\Session;

class ListLayout extends Component
{
    use WithPaginationData;

    public $gameSlug, $categorySlug, $game;
    public $product; // Holds the selected product

    #[Url(keep: true)]
    public $sellerFilter = 'recommended';

    #[Url(as: 'q')]
    public $serach = '';

    #[Url(as: 'sort')]
    public $sortDirection = 'desc';

    public $sortBy = 'price';
    public $tags = [];
    protected $datas;

    // Services
    protected $productService, $orderService, $gameService, $platformService;

    public function boot(ProductService $productService, OrderService $orderService, GameService $gameService, PlatformService $platformService)
    {
        $this->productService = $productService;
        $this->orderService = $orderService;
        $this->gameService = $gameService;
        $this->platformService = $platformService;
    }

    public function mount($gameSlug, $categorySlug)
    {
        $this->gameSlug = $gameSlug;
        $this->categorySlug = $categorySlug;

        // Load game with counts to avoid heavy relationships in mount
        $this->game = $this->gameService->findData($gameSlug, 'slug')
            ->load(['tags', 'gameConfig', 'platforms']);

        // Flattening tags once during mount
        $this->tags = collect($this->game->tags->pluck('name'))
            ->merge($this->platformService->getAllDatas()->pluck('name'))
            ->merge(collect($this->game->gameConfig->pluck('dropdown_values'))->flatten())
            ->filter()
            ->shuffle()
            ->toArray();
    }

    public function updatedSortDirection()
    {
        $this->resetPage();
    }

    public function updatedSerach()
    {
        $this->resetPage();
    }


    public function selectItem($id)
    {
        // Use findWithSelectedData to get exactly what's needed for the sidebar
        $this->product = Product::with([
            'user' => fn($q) => $q->withCount([
                'feedbacksReceived as pos_count' => fn($f) => $f->where('type', FeedbackType::POSITIVE->value),
                'feedbacksReceived as neg_count' => fn($f) => $f->where('type', FeedbackType::NEGATIVE->value)
            ])
        ])->findOrFail($id);
    }

    public function submit()
    {
        if (!$this->product) return;

        $total = $this->product->price * $this->product->quantity;
        $token = bin2hex(random_bytes(32)); // Standardized token length

        $order = $this->orderService->createData([
            'order_id'    => generate_order_id_hybrid(),
            'user_id'     => user()->id,
            'source_id'   => $this->product->id,
            'source_type' => Product::class,
            'total_amount' => $total,
            'tax_amount'   => 0,
            'grand_total'  => $total,
        ]);

        Session::driver('redis')->put("checkout_{$token}", [
            'order_id'     => $order->id,
            'price_locked' => $total,
            'expires_at'   => now()->addMinutes((int) env('ORDER_CHECKOUT_TIMEOUT_MINUTES', 5))->timestamp,
        ]);

        return $this->redirect(route('game.buy', [
            'gameSlug' => $this->gameSlug,
            'categorySlug' => $this->categorySlug,
            'productId' => encrypt($this->product->id),
            'token' => $token,
        ]), navigate: true);
    }

    public function render()
    {
        // filter datas lowest price and highest price
        $this->datas = $this->productService->getPaginatedData($this->perPage, [

            'gameSlug' => $this->gameSlug,
            'categorySlug' => $this->categorySlug,
            'skipSelf' => true,
            'serach' => $this->serach,
            'sort_field' => $this->sortBy,
            'sort_direction' => $this->sortDirection,
        ]);
        $this->datas->load('user.feedbacksReceived', 'game', 'category', 'platform', 'user.wallet');
        $this->paginationData($this->datas);

        // $this->sellerProducts = $this->datas->unique('user_id')
        //     ->filter(function ($item) {
        //         return !(
        //             $this->product &&
        //             $this->product->user?->id === $item->user?->id
        //         );
        //     })
        //     ->when($this->sellerFilter, function ($collection) {

        //         return match ($this->sellerFilter) {

        //             'positive_reviews' =>
        //             $collection->sortByDesc('rating'),

        //             'top_sold' =>
        //             $collection->sortByDesc('sold_count'),

        //             'lowest_price' =>
        //             $collection->sortBy('price'),

        //             'in_stock' =>
        //             $collection->filter(fn($item) => $item->quantity > 0),

        //             'recommended' =>
        //             $collection,

        //             default =>
        //             $collection,
        //         };
        //     })
        //     ->values();

        $filters = [];

        if ($this->sellerFilter === 'positive_reviews') {
            $filters['positive_reviews'] = true;
        }

        // Handle other filters
        if ($this->sellerFilter === 'lowest_price') {
            $filters['sort_field'] = 'price';
            $filters['sort_direction'] = 'asc';
        }

        $otherSellers = $this->productService->getSellers(11, $filters);
        $otherSellers->load('user.feedbacksReceived');

        return view('livewire.frontend.product.list-layout', [
            'gameSlug' => $this->gameSlug,
            'categorySlug' => $this->categorySlug,
            'game' => $this->game,
            'datas' => $this->datas,
            'otherSellers' => $otherSellers
        ]);
    }
}
