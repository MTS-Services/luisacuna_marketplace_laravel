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
    public  $gameSlug;
    public $categorySlug;
    public $game;
    protected $datas;
    public $product;
    #[Url()]
    public $serach = '';
    public $sortBy = 'price';
    public $tags = [];
    public $sortDirection = 'asc';


    public $positiveFeedbacksCount;
    public $negativeFeedbacksCount;

    protected ProductService $productService;
    protected OrderService $orderService;
    protected GameService $gameService;
    protected PlatformService $platformService;
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

        $this->game = $this->gameService->findData($gameSlug, 'slug')->load(['tags', 'gameConfig', 'platforms']);


        // Formatting Tags
        $tags = $this->game->tags->pluck('name')->toArray();

        $platforms = $this->platformService->getAllDatas()->pluck('name')->toArray();


        $gameConfigs = $this->game->gameConfig->pluck('dropdown_values')->toArray();
        $array = collect($gameConfigs)->filter(fn($value) => !is_null($value))->values()->toArray();

        $shuffledTags = collect(array_merge($tags, $platforms, array_merge(...$array)))->shuffle()->values()->toArray();

        $this->tags = $shuffledTags;

        $allFeedbacks = $this->product?->user?->feedbacksReceived()->get();
        $this->positiveFeedbacksCount = $this->product?->user?->feedbacksReceived()->where('type', FeedbackType::POSITIVE->value)->count();
        $this->negativeFeedbacksCount = $this->product?->user?->feedbacksReceived()->where('type', FeedbackType::NEGATIVE->value)->count();
    }

    public function selectItem($ecnryptedId)
    {

        $this->product = $this->productService->findData(decrypt($ecnryptedId));
        $this->product->load(['user.feedbacksReceived', 'platform', 'product_configs.game_configs', 'orders.feedbacks']);
        // $this->skipRender();
    }

    public function submit()
    {


        $token = bin2hex(random_bytes(126));
        $order = $this->orderService->createData([
            'order_id' => generate_order_id_hybrid(),
            'user_id' => user()->id,
            'source_id' => $this->product->id,
            'source_type' => Product::class,
            'total_amount' => ($this->product->price * $this->product->quantity),
            'tax_amount' => 0,
            'grand_total' => ($this->product->price * $this->product->quantity),
        ]);
        Session::driver('redis')->put("checkout_{$token}", [
            'order_id' => $order->id,
            'price_locked' => ($this->product->price * $this->product->quantity),
            'expires_at' => now()->addMinutes((int) env('ORDER_CHECKOUT_TIMEOUT_MINUTES', 5))->timestamp,
        ]);
        return $this->redirect(
            route('game.checkout', ['slug' => encrypt($this->product->id), 'token' => $token]),
            navigate: true
        );
    }
    public function render()
    {


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

        return view('livewire.frontend.product.list-layout', [
            'gameSlug' => $this->gameSlug,
            'categorySlug' => $this->categorySlug,
            'game' => $this->game,
            'datas' => $this->datas,

        ]);
    }
}
