<?php

namespace App\Livewire\Backend\User\Payments;

use App\Models\User;
use App\Models\Product;
use App\Services\FeedbackService;
use App\Services\FeeSettingsService;
use App\Services\CurrencyService;
use Livewire\Component;
use App\Enums\FeedbackType;
use App\Services\OrderService;
use App\Services\ProductService;
use Illuminate\Support\Facades\Session;
use App\Traits\Livewire\WithNotification;
use Illuminate\Support\Facades\Log;

class InitializeOrder extends Component
{
    use WithNotification;

    public ?Product $product = null;
    public int $quantity = 1;
    public $feedbacks;
    public $product_id;
    public $positiveFeedbacksCount;
    public $negativeFeedbacksCount;

    // Display currency properties
    public string $displayCurrency;
    public string $displaySymbol;
    public float $exchangeRate;

    protected OrderService $orderService;
    protected ProductService $productService;
    protected FeeSettingsService $feeSettingsService;
    protected FeedbackService $feedbackService;
    protected CurrencyService $currencyService;

    public function boot(
        OrderService $orderService,
        ProductService $productService,
        FeeSettingsService $feeSettingsService,
        FeedbackService $feedbackService,
        CurrencyService $currencyService
    ) {
        $this->orderService = $orderService;
        $this->productService = $productService;
        $this->feeSettingsService = $feeSettingsService;
        $this->feedbackService = $feedbackService;
        $this->currencyService = $currencyService;
        $this->feedbacks = collect([]);
    }

    public function mount($productId)
    {
        $this->product = $this->productService->findData(decrypt($productId));
        $this->product->load(['user.seller', 'user.feedbacksReceived', 'platform', 'product_configs.game_configs', 'orders.feedbacks']);
        $this->feedbacks = $this->product->feedbacks()->latest()->take(6)->get();

        // Get user's selected currency or default
        $currentCurrency = $this->currencyService->getCurrentCurrency();
        $this->displayCurrency = $currentCurrency->code;
        $this->displaySymbol = $currentCurrency->symbol;
        $this->exchangeRate = $currentCurrency->exchange_rate;

        $this->positiveFeedbacksCount = $this->product?->user?->feedbacksReceived()->where('type', FeedbackType::POSITIVE->value)->count();
        $this->negativeFeedbacksCount = $this->product?->user?->feedbacksReceived()->where('type', FeedbackType::NEGATIVE->value)->count();
    }

    public function updatedQuantity()
    {
        if ($this->quantity < 1) {
            $this->quantity = 1;
        }

        if ($this->product && $this->quantity > $this->product->quantity) {
            $this->quantity = $this->product->quantity;
        }
    }

    public function submit()
    {
        try {
            $fee = $this->feeSettingsService->getActiveFee();
            $defaultCurrency = $this->currencyService->getDefaultCurrency();

            // =================================================================
            // STEP 1: Calculate in DEFAULT CURRENCY (USD)
            // Product prices are stored in default currency
            // =================================================================
            $unitPriceDefault = (float) $this->product->price;
            $quantity = (int) $this->quantity;
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

            // =================================================================
            // STEP 3: Create Order with BOTH amounts
            // Default amounts: For internal calculations, wallet operations
            // Display amounts: For showing to user, Stripe checkout
            // =================================================================
            $token = bin2hex(random_bytes(126));
            $orderId = generate_order_id_hybrid();

            $order = $this->orderService->createData([
                'order_id' => $orderId,
                'user_id' => user()->id,
                'source_id' => $this->product->id,
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

    /**
     * Get display price for UI
     * This is used in the view to show converted prices
     */
    public function getDisplayPrice(): float
    {
        return $this->currencyService->convertFromDefault(
            $this->product->price * $this->quantity,
            $this->displayCurrency
        );
    }

    /**
     * Get formatted total with symbol
     */
    public function getFormattedTotal(): string
    {
        $total = $this->getDisplayPrice();
        return $this->displaySymbol . number_format($total, 2);
    }

    public function render()
    {

        return view('livewire.backend.user.payments.initialize-order');
    }
}
