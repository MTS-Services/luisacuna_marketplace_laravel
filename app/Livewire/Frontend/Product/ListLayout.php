<?php

namespace App\Livewire\Frontend\Product;

use App\Models\Product;
use Livewire\Component;
use App\Enums\FeedbackType;
use App\Models\Currency;
use App\Models\User;
use App\Services\CurrencyService;
use App\Services\FeeSettingsService;
use Livewire\Attributes\Url;
use App\Services\GameService;
use App\Services\OrderService;
use App\Services\ProductService;
use App\Services\PlatformService;
use App\Traits\WithPaginationData;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class ListLayout extends Component
{
    use WithPaginationData;

    public $gameSlug, $categorySlug, $game;
    public $product; // Holds the selected product
    public $data;
    public $platforms;
    public $gameTags;

    public $displayCurrency;


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

    // Services
    protected $productService, $feeSettingsService, $orderService, $gameService, $platformService, $currencyService;

    public function boot(
    ProductService $productService, 
    OrderService $orderService,
    GameService $gameService,
    PlatformService $platformService,
    CurrencyService $currencyService,
    FeeSettingsService $feeSettingsService)
    {
        $this->productService = $productService;
        $this->orderService = $orderService;
        $this->gameService = $gameService;
        $this->platformService = $platformService;
        $this->currencyService = $currencyService;
        $this->feeSettingsService = $feeSettingsService;
    }

    public function mount($gameSlug, $categorySlug)
    {

         // Get user's selected currency or default
        $currentCurrency = $this->currencyService->getCurrentCurrency();
        $this->displayCurrency = $currentCurrency->code;
        $this->displaySymbol = $currentCurrency->symbol;
        $this->exchangeRate = $currentCurrency->exchange_rate;

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
        $this->platforms = $platforms;

        // 3. Game config dropdown values
        $configTags = collect($this->game->gameConfig)
            ->pluck('dropdown_values')
            ->flatten();

        // 4. Merge everything
        $this->tags = $configTags
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

        try {


            $fee = $this->feeSettingsService->getActiveFee();
            $defaultCurrency = $this->currencyService->getDefaultCurrency();

            // =================================================================
            // STEP 1: Calculate in DEFAULT CURRENCY (USD)
            // Product prices are stored in default currency
            // =================================================================
            $unitPriceDefault = (float) $this->product->price;
            $quantity = (int) 1;
            $totalAmountDefault = $unitPriceDefault * $quantity;

            $buyerTaxPercent = (float) $fee->buyer_fee ?? 0;
            $taxAmountDefault = ($totalAmountDefault * $buyerTaxPercent) / 100;
            $grandTotalDefault = $totalAmountDefault + $taxAmountDefault;

            // =================================================================
            // STEP 2: Convert to DISPLAY CURRENCY (for user-facing amounts)
            // These will be shown to user during checkout
            // =================================================================
            $unitPriceDisplay = $this->currencyService->convertFromDefault(
                $unitPriceDefault,
                $this->displayCurrency
            );
            $totalAmountDisplay = $this->currencyService->convertFromDefault(
                $totalAmountDefault,
                $this->displayCurrency
            );
            $taxAmountDisplay = $this->currencyService->convertFromDefault(
                $taxAmountDefault,
                $this->displayCurrency
            );
            $grandTotalDisplay = $this->currencyService->convertFromDefault(
                $grandTotalDefault,
                $this->displayCurrency
            );


            $token = bin2hex(random_bytes(32)); // Standardized token length
            $orderId = generate_order_id_hybrid();
            $order = $this->orderService->createData([
                'order_id'    => $orderId,
                'user_id'     => user()->id,
                'source_id'   => $this->product->id,
                'source_type' => Product::class,


                // Display amounts (in user's selected currency)
                'unit_price' => $unitPriceDisplay,
                'total_amount' => $totalAmountDisplay,
                'tax_amount' => $taxAmountDisplay,
                'grand_total' => $grandTotalDisplay,
                'currency' => $this->displayCurrency,
                'display_currency' => $this->displayCurrency,

                // Default amounts (in system default currency - USD)
                'default_unit_price' => $unitPriceDefault,
                'default_total_amount' => $totalAmountDefault,
                'default_tax_amount' => $taxAmountDefault,
                'default_grand_total' => $grandTotalDefault,
                'default_currency' => $defaultCurrency->code,

                // Currency metadata
                'exchange_rate' => $this->exchangeRate,
                'quantity' => $quantity,

                'notes' => "Order initiated by " . user()->username . ", Order ID: " . $orderId,
                'display_symbol' => $this->displaySymbol, // Legacy field

                'points' => $totalAmountDefault * env('ORDER_POINTS_MULTIPLAYER', 100),

                'creater_id' => user()->id,
                'creater_type' => User::class,
            ]);

            // =================================================================
            // STEP 4: Store in Redis for Checkout
            // Lock price in DEFAULT currency for accurate calculations
            // =================================================================
            Session::driver('redis')->put("checkout_{$token}", [
                'order_id' => $order->id,
                'price_locked' => $grandTotalDefault, // Store in default currency
                'display_price' => $grandTotalDisplay, // For reference
                'display_currency' => $this->displayCurrency,
                'exchange_rate' => $this->exchangeRate,
                'expires_at' => now()->addMinutes((int) env('ORDER_CHECKOUT_TIMEOUT_MINUTES', 10))->timestamp,
            ]);
            // Log order creation with currency details
            Log::info('Order initialized with currency conversion', [
                'order_id' => $orderId,
                'user_id' => user()->id,
                'product_id' => $this->product->id,
                'quantity' => $quantity,
                'default_currency' => $defaultCurrency->code,
                'default_grand_total' => $grandTotalDefault,
                'display_currency' => $this->displayCurrency,
                'display_grand_total' => $grandTotalDisplay,
                'exchange_rate' => $this->exchangeRate,
            ]);


            return $this->redirect(
                route('user.checkout', ['slug' => encrypt($this->product->id), 'token' => $token]),
                navigate: true
            );
        } catch (\Exception $e) {
            Log::error('Order initialization failed', [
                'product_id' => $this->product->id,
                'user_id' => user()->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            $this->addError('order', 'Failed to initialize order. Please try again.');
            return null;
        }
    }


    public function render()
    {
        // filter datas lowest price and highest price
        $this->datas = $this->productService->getPaginatedData($this->perPage, [

            'gameSlug' => $this->gameSlug,
            'categorySlug' => $this->categorySlug,
            'skipSelf' => true,
            'filter_by_config' => $this->filter_by_config,
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
