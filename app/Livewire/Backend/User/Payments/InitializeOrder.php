<?php

namespace App\Livewire\Backend\User\Payments;

use App\Enums\ActiveInactiveEnum;
use App\Enums\FeedbackType;
use App\Models\Product;
use App\Models\User;
use App\Services\CurrencyService;
use App\Services\FeedbackService;
use App\Services\OrderService;
use App\Services\ProductService;
use App\Traits\Livewire\WithNotification;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

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

    protected FeedbackService $feedbackService;

    protected CurrencyService $currencyService;

    public function boot(
        OrderService $orderService,
        ProductService $productService,
        FeedbackService $feedbackService,
        CurrencyService $currencyService
    ) {
        $this->orderService = $orderService;
        $this->productService = $productService;
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
        // Ensure the product is still active before initializing checkout
        if ($this->product) {
            $this->product->refresh();
        }

        if (! $this->product || $this->product->status?->value !== ActiveInactiveEnum::ACTIVE->value) {
            $this->addError('order', __('This product is no longer available.'));

            return null;
        }

        try {
            $defaultCurrency = $this->currencyService->getDefaultCurrency();

            // =================================================================
            // STEP 1: Calculate in DEFAULT CURRENCY (USD)
            // Product prices are stored in default currency
            // Tax will be calculated during checkout based on payment method
            // =================================================================
            $unitPriceDefault = (float) $this->product->price;
            $quantity = (int) $this->quantity;
            $totalAmountDefault = $unitPriceDefault * $quantity;

            // Tax amounts will be calculated later during checkout
            $taxAmountDefault = 0;
            $grandTotalDefault = $totalAmountDefault;

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

                'notes' => 'Order initiated by '.user()->username.', Order ID: '.$orderId,
                'display_symbol' => $this->displaySymbol, // Legacy field

                'points' => $totalAmountDefault * env('ORDER_POINTS_MULTIPLAYER', 100),

                'creater_id' => user()->id,
                'creater_type' => User::class,
            ]);

            // =================================================================
            // STEP 4: Store in Redis for Checkout
            // Lock subtotal in DEFAULT currency for accurate calculations
            // Tax will be added during checkout based on payment method
            // =================================================================
            Session::driver('database')->put("checkout_{$token}", [
                'order_id' => $order->id,
                'subtotal_locked' => $totalAmountDefault, // Subtotal without tax
                'price_locked' => $totalAmountDefault, // For backward compatibility
                'display_subtotal' => $totalAmountDisplay, // For reference
                'display_currency' => $this->displayCurrency,
                'exchange_rate' => $this->exchangeRate,
                'expires_at' => now()->addMinutes((int) env('ORDER_CHECKOUT_TIMEOUT_MINUTES', 10))->timestamp,
            ]);

            // Log order creation with currency details
            Log::info('Order initialized without tax - will be calculated at checkout', [
                'order_id' => $orderId,
                'user_id' => user()->id,
                'product_id' => $this->product->id,
                'quantity' => $quantity,
                'default_currency' => $defaultCurrency->code,
                'default_total_amount' => $totalAmountDefault,
                'display_currency' => $this->displayCurrency,
                'display_total_amount' => $totalAmountDisplay,
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

        return $this->displaySymbol.number_format($total, 2);
    }

    public function render()
    {

        return view('livewire.backend.user.payments.initialize-order');
    }
}
