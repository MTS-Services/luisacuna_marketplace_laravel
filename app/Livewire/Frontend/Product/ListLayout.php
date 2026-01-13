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
    public $data;
    public $platforms;
    public $gameTags;



    #[Url(as: 'asc')]
    public $sortByPrice = 'asc';

    #[Url(keep: true)]
    public $sellerFilter = 'recommended';

    #[Url(as: 'q')]
    public $serach = '';

    #[Url(as: 'sort')]
    public $sortDirection = 'desc';

    #[Url('t')]
    public $game_tag = '';

   #[Url('p')]
    public $platform_id = '';

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

      // 1. Game tags
        $gameTags = $this->game->tags;

        $this->gameTags = $gameTags;
        
        // 2. Platform service tags
        $platforms = $this->platformService->getAllDatas()
            ->pluck('id', 'name');
        $this->platforms = $platforms ;

        // 3. Game config dropdown values
        $configTags = collect($this->game->gameConfig)
            ->pluck('dropdown_values')
            ->flatten();

        // 4. Merge everything
        $this->tags =$configTags
                    ->filter()
                    ->shuffle()
                    ->toArray();
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
            'platform_id' => $this->platform_id != null ? decrypt($this->platform_id) : '',
            'game_tag' => $this->game_tag

        ]);
        $this->datas->load('user.feedbacksReceived', 'game', 'category', 'platform', 'user.wallet');
        $this->paginationData($this->datas);

        $filters = [];

        if ($this->sellerFilter === 'positive_reviews') {
            $filters['positive_reviews'] = true;
        }
        // Handle other filters
        if ($this->sellerFilter === 'lowest_price') {
            $filters['sort_field'] = 'price';
            $filters['sort_direction'] = 'asc';
        }
        if ($this->sellerFilter === 'in_stock') {
            $filters['sort_field'] = 'quantity';
            $filters['sort_direction'] = 'desc';
        }
        if ($this->sellerFilter === 'top_sold') {
            $filters['top_sold'] = true;
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
