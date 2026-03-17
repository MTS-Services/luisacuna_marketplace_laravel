<?php

namespace App\Livewire\Frontend\Product;

use App\Enums\ActiveInactiveEnum;
use App\Enums\FeedbackType;
use App\Models\Product;
use App\Models\User;
use App\Services\CurrencyService;
use App\Services\FeeSettingsService;
use App\Services\GameService;
use App\Services\OrderService;
use App\Services\PlatformService;
use App\Services\ProductService;
use App\Traits\WithPaginationData;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;

class ListLayout extends Component
{
    use WithPaginationData;

    public $gameSlug;
    public $categorySlug;
    public $game;
    public $product;
    public $data;
    public $platforms;
    public $gameTags;
    public $displayCurrency;
    public $onlineOnly = false;

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

    #[Url('config')]
    public $filter_by_config;

    public $exchangeRate;
    public $displaySymbol;

    protected $datas;
    protected $productService;
    protected $feeSettingsService;
    protected $orderService;
    protected $gameService;
    protected $platformService;
    protected $currencyService;

    public function boot(
        ProductService $productService,
        OrderService $orderService,
        GameService $gameService,
        PlatformService $platformService,
        CurrencyService $currencyService,
        FeeSettingsService $feeSettingsService
    ) {
        $this->productService    = $productService;
        $this->orderService      = $orderService;
        $this->gameService       = $gameService;
        $this->platformService   = $platformService;
        $this->currencyService   = $currencyService;
        $this->feeSettingsService = $feeSettingsService;
    }

    public function toggleOnlineFilter()
    {
        $this->onlineOnly = ! $this->onlineOnly;
    }

    public function mount($gameSlug, $categorySlug)
    {
        $currentCurrency         = $this->currencyService->getCurrentCurrency();
        $this->displayCurrency   = $currentCurrency->code;
        $this->displaySymbol     = $currentCurrency->symbol;
        $this->exchangeRate      = $currentCurrency->exchange_rate;

        $this->gameSlug          = $gameSlug;
        $this->categorySlug      = $categorySlug;

        $this->game = $this->gameService->findData($gameSlug, 'slug')
            ->load(['tags', 'gameConfig', 'platforms']);

        $this->gameTags = $this->game->tags;
        $this->platforms = $this->platformService->getAllDatas()->pluck('id', 'name');

        $this->tags = collect($this->game->gameConfig)
            ->pluck('dropdown_values')
            ->flatten()
            ->filter()
            ->shuffle()
            ->toArray();
    }

    public function selectItem($id)
    {
        $this->product = Product::with([
            'user' => fn($q) => $q->withCount([
                'feedbacksReceived as pos_count' => fn($f) => $f->where('type', FeedbackType::POSITIVE->value),
                'feedbacksReceived as neg_count'  => fn($f) => $f->where('type', FeedbackType::NEGATIVE->value),
            ]),
        ])->findOrFail($id);
    }

    // ------------------------------------------------------------------
    // STEP 1 — "Buy Now" clicked.
    //   • Guards product availability and self-purchase.
    //   • Pre-computes all currency amounts.
    //   • Stashes payload in session keyed by product id.
    //   • Opens the DeliveryInfo modal via event.
    // ------------------------------------------------------------------
    public function submit()
    {
        if (! $this->product) {
            return;
        }

        $this->product->refresh();

        if ($this->product->status?->value !== ActiveInactiveEnum::ACTIVE->value) {
            $this->addError('order', __('This product is no longer available.'));
            return;
        }

        if ((int) $this->product->user_id === (int) user()->id) {
            $this->addError('order', __('You cannot purchase your own product.'));
            return;
        }

        try {
            $defaultCurrency = $this->currencyService->getDefaultCurrency();

            $unitPriceDefault   = (float) $this->product->price;
            $quantity           = 1;
            $totalAmountDefault = $unitPriceDefault * $quantity;
            $taxAmountDefault   = 0;
            $grandTotalDefault  = $totalAmountDefault;

            $unitPriceDisplay   = $this->currencyService->convertFromDefault($unitPriceDefault, $this->displayCurrency);
            $totalAmountDisplay = $this->currencyService->convertFromDefault($totalAmountDefault, $this->displayCurrency);
            $taxAmountDisplay   = $this->currencyService->convertFromDefault($taxAmountDefault, $this->displayCurrency);
            $grandTotalDisplay  = $this->currencyService->convertFromDefault($grandTotalDefault, $this->displayCurrency);

            $token   = bin2hex(random_bytes(32));
            $orderId = generate_order_id_hybrid();

            Session::put("pending_order_{$this->product->id}", [
                'order_id'             => $orderId,
                'token'                => $token,
                'user_id'              => user()->id,
                'source_id'            => $this->product->id,
                'source_type'          => Product::class,

                'unit_price'           => $unitPriceDisplay,
                'total_amount'         => $totalAmountDisplay,
                'tax_amount'           => $taxAmountDisplay,
                'grand_total'          => $grandTotalDisplay,
                'currency'             => $this->displayCurrency,
                'display_currency'     => $this->displayCurrency,

                'default_unit_price'   => $unitPriceDefault,
                'default_total_amount' => $totalAmountDefault,
                'default_tax_amount'   => $taxAmountDefault,
                'default_grand_total'  => $grandTotalDefault,
                'default_currency'     => $defaultCurrency->code,

                'exchange_rate'        => $this->exchangeRate,
                'quantity'             => $quantity,
                'display_symbol'       => $this->displaySymbol,
                'points'               => $totalAmountDefault * env('ORDER_POINTS_MULTIPLAYER', 100),
                'notes'                => 'Order initiated by ' . user()->username . ', Order ID: ' . $orderId,
                'creater_id'           => user()->id,
                'creater_type'         => User::class,
            ]);

            $this->dispatch('open-delivery-modal', productId: $this->product->id);
        } catch (\Exception $e) {
            Log::error('Order pre-computation failed (ListLayout)', [
                'product_id' => $this->product->id,
                'user_id'    => user()->id,
                'error'      => $e->getMessage(),
                'trace'      => $e->getTraceAsString(),
            ]);

            $this->addError('order', __('Failed to initialize order. Please try again.'));
        }
    }

    // ------------------------------------------------------------------
    // STEP 2 — DeliveryInfo dispatches 'delivery-info-saved'.
    //   • Pulls the stashed payload.
    //   • Creates the Order with delivery_info_id.
    //   • Stores checkout session and redirects.
    // ------------------------------------------------------------------
    #[On('delivery-info-saved')]
    public function finalizeOrder(int $deliveryInfoId, int $productId): mixed
    {
        $payload = Session::pull("pending_order_{$productId}");

        if (! $payload) {
            $this->addError('order', __('Order session expired. Please try again.'));
            return null;
        }

        // Guard: only handle events belonging to this component's product.
        if ((int) $payload['source_id'] !== (int) $productId) {
            return null;
        }

        try {
            $order = $this->orderService->createData(array_merge($payload, [
                'delivery_info_id' => $deliveryInfoId,
            ]));

            Session::driver('database')->put("checkout_{$payload['token']}", [
                'order_id'         => $order->id,
                'subtotal_locked'  => $payload['default_total_amount'],
                'price_locked'     => $payload['default_total_amount'],
                'display_subtotal' => $payload['total_amount'],
                'display_currency' => $payload['display_currency'],
                'exchange_rate'    => $payload['exchange_rate'],
                'expires_at'       => now()->addMinutes((int) env('ORDER_CHECKOUT_TIMEOUT_MINUTES', 10))->timestamp,
            ]);

            Log::info('Order finalized with delivery info (ListLayout)', [
                'order_id'         => $payload['order_id'],
                'delivery_info_id' => $deliveryInfoId,
                'user_id'          => user()->id,
                'product_id'       => $productId,
            ]);

            return $this->redirect(
                route('user.checkout', ['slug' => encrypt($productId), 'token' => $payload['token']]),
                navigate: true
            );
        } catch (\Exception $e) {
            Log::error('Order finalization failed (ListLayout)', [
                'product_id'       => $productId,
                'delivery_info_id' => $deliveryInfoId,
                'user_id'          => user()->id,
                'error'            => $e->getMessage(),
                'trace'            => $e->getTraceAsString(),
            ]);

            $this->addError('order', __('Failed to create order. Please try again.'));
            return null;
        }
    }

    public function render()
    {
        $this->datas = $this->productService->getPaginatedData($this->perPage, [
            'gameSlug'         => $this->gameSlug,
            'categorySlug'     => $this->categorySlug,
            'skipSelf'         => true,
            'filter_by_config' => $this->filter_by_config,
            'sort_field'       => $this->sortBy,
            'sort_direction'   => $this->sortDirection,
            'platform_id'      => $this->platform_id != null ? decrypt($this->platform_id) : '',
            'game_tag'         => $this->game_tag,
            'status'           => ActiveInactiveEnum::ACTIVE->value,
        ]);

        $this->datas->load('user.feedbacksReceived', 'game', 'category', 'platform', 'user.wallet');
        $this->paginationData($this->datas);

        $filters = ['skipSelf' => true, 'status' => ActiveInactiveEnum::ACTIVE->value];

        if ($this->sellerFilter === 'positive_reviews') $filters['positive_reviews'] = true;
        if ($this->sellerFilter === 'lowest_price') {
            $filters['sort_field'] = 'price';
            $filters['sort_direction'] = 'asc';
        }
        if ($this->sellerFilter === 'in_stock') {
            $filters['sort_field'] = 'quantity';
            $filters['sort_direction'] = 'desc';
        }
        if ($this->sellerFilter === 'top_sold')         $filters['top_sold'] = true;
        if ($this->onlineOnly)                          $filters['online_only'] = true;

        $otherSellers = $this->productService->getSellers(11, $filters);
        $otherSellers->load('user.feedbacksReceived');

        return view('livewire.frontend.product.list-layout', [
            'gameSlug'     => $this->gameSlug,
            'categorySlug' => $this->categorySlug,
            'game'         => $this->game,
            'datas'        => $this->datas,
            'otherSellers' => $otherSellers,
        ]);
    }
}
