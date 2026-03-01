<?php

namespace App\Livewire\Backend\User\Payments;

use App\Enums\FeedbackType;
use App\Enums\OrderStatus;
use App\Models\Order;
use App\Models\PaymentGateway;
use App\Models\Wallet;
use App\Services\CurrencyService;
use App\Services\FeedbackService;
use App\Services\FeeSettingsService;
use App\Services\OrderService;
use App\Services\PaymentService;
use App\Services\TaxService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('frontend.layouts.app', ['title' => 'Checkout'])]
class Checkout extends Component
{
    public ?Order $order;

    public ?Collection $gateways;

    public ?string $gateway = null;

    public ?float $walletBalance = null;

    public ?float $walletBalanceDefault = null; // Add this for default currency balance

    public bool $showWalletWarning = false;

    public bool $processing = false;

    public $positiveFeedbacksCount;

    public $negativeFeedbacksCount;

    // Top-up modal properties
    public bool $showTopUpModal = false;

    public ?string $topUpGateway = null;

    public ?float $requiredTopUpAmount = null;

    public ?Collection $topUpGateways;

    // Currency properties
    public string $displayCurrency;

    public string $displaySymbol;

    public float $exchangeRate;

    // Dynamic tax properties
    public float $calculatedTaxAmount = 0; // Display currency

    public float $calculatedTaxAmountDefault = 0; // Default currency

    public float $calculatedGrandTotal = 0; // Display currency

    public float $calculatedGrandTotalDefault = 0; // Default currency

    // =========================================================

    public $priceAmount = 2000000000000000;

    public $priceCurrency = 'usd';

    public $payCurrency = 'btc';

    public $orderDescription = '';

    public $availableCurrencies = [];

    public $estimatedAmount = null;

    public $minimumAmount = 20;

    public $paymentDetails = null;

    protected OrderService $orderService;

    protected PaymentService $paymentService;

    protected CurrencyService $currencyService;

    protected FeedbackService $feedbackService;

    protected FeeSettingsService $feeSettingsService;

    protected TaxService $taxService;

    public function boot(
        OrderService $orderService,
        PaymentService $paymentService,
        FeedbackService $feedbackService,
        CurrencyService $currencyService,
        FeeSettingsService $feeSettingsService,
        TaxService $taxService
    ) {
        $this->orderService = $orderService;
        $this->paymentService = $paymentService;
        $this->currencyService = $currencyService;
        $this->feedbackService = $feedbackService;
        $this->feeSettingsService = $feeSettingsService;
        $this->taxService = $taxService;
    }

    public function mount($slug, $token)
    {
        $key = "checkout_{$token}";
        $sessionKey = Session::driver('database')->get($key);

        if (! $sessionKey) {
            return redirect()->route('checkout.invalid');
        }

        if (now()->timestamp > $sessionKey['expires_at']) {
            Session::driver('database')->forget($key);

            return redirect()->route('checkout.expired');
        }

        $this->order = $this->orderService->findData($sessionKey['order_id']);
        $this->order->load(['user', 'source.platform',  'user.feedbacksReceived', 'source.product_configs.game_configs', 'source.user', 'source.game', 'source.user.wallet']);

        if (! $this->order || $this->order->status !== OrderStatus::INITIALIZED) {
            return redirect()->route('checkout.invalid');
        }

        // Get currency information
        $currentCurrency = $this->currencyService->getCurrentCurrency();
        $this->displayCurrency = $currentCurrency->code;
        $this->displaySymbol = $currentCurrency->symbol;
        $this->exchangeRate = $currentCurrency->exchange_rate;

        $this->gateways = PaymentGateway::where('is_active', true)
            ->orderBy('sort_order', 'asc')
            ->select(['id', 'slug', 'name'])
            ->get()
            ->filter(fn ($gateway) => $gateway->isSupported());

        $this->gateway = $this->gateways->first()?->slug;

        // Load top-up gateways (exclude wallet)
        $this->topUpGateways = $this->gateways->filter(fn ($g) => $g->slug !== 'wallet');

        if ($this->gateways->where('slug', 'wallet')->isNotEmpty()) {
            $this->loadWalletBalance();
        }
        $allFeedbacks = $this->order?->user?->feedbacksReceived()->get();
        $this->positiveFeedbacksCount = $this->order?->user?->feedbacksReceived()->where('type', FeedbackType::POSITIVE->value)->count();
        $this->negativeFeedbacksCount = $this->order?->user?->feedbacksReceived()->where('type', FeedbackType::NEGATIVE->value)->count();

        // Initialize calculated amounts based on default gateway
        $this->recalculateTax();
    }

    protected function loadWalletBalance()
    {
        try {
            // Get wallet balance in DEFAULT currency (USD)
            $this->walletBalanceDefault = Wallet::where('user_id', $this->order->user_id)
                ->value('balance') ?? 0;

            // Convert to DISPLAY currency for UI comparison
            $this->walletBalance = $this->currencyService->convertFromDefault(
                $this->walletBalanceDefault,
                $this->displayCurrency
            );

            Log::info('Wallet balance loaded', [
                'user_id' => $this->order->user_id,
                'balance_default' => $this->walletBalanceDefault,
                'balance_display' => $this->walletBalance,
                'currency' => $this->displayCurrency,
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to load wallet balance', [
                'user_id' => $this->order->user_id,
                'error' => $e->getMessage(),
            ]);
            $this->walletBalance = 0;
            $this->walletBalanceDefault = 0;
        }
    }

    public function updatedGateway()
    {
        // Recalculate tax based on selected payment method
        $this->recalculateTax();

        if ($this->gateway === 'wallet' && $this->walletBalance !== null) {
            // Compare in DISPLAY currency with calculated grand total
            $this->showWalletWarning = $this->walletBalance < $this->calculatedGrandTotal;
        } else {
            $this->showWalletWarning = false;
        }
    }

    /**
     * Recalculate tax based on the selected payment method
     *
     * Tax Rules:
     * 1. Wallet selected with sufficient balance: NO TAX - display original amount
     * 2. Wallet insufficient OR Stripe/Crypto selected: TAX applied on entire order amount
     * 3. Top-up scenario: Tax is recalculated only on the remaining balance to be topped up
     */
    protected function recalculateTax(): void
    {
        try {
            // Determine if it's a top-up scenario (wallet insufficient)
            $isTopUp = $this->gateway === 'wallet' &&
                       $this->walletBalanceDefault !== null &&
                       $this->walletBalanceDefault < $this->order->default_total_amount;

            // Use TaxService to calculate tax
            $taxCalc = $this->taxService->calculateTax(
                paymentMethod: $this->gateway ?? 'unknown',
                amountDefault: $this->order->default_total_amount,
                walletBalanceDefault: $this->walletBalanceDefault,
                isTopUp: $isTopUp
            );

            // Set calculated tax in default currency
            $this->calculatedTaxAmountDefault = $taxCalc['tax_amount_default'] ?? 0;
            $this->calculatedGrandTotalDefault = $taxCalc['grand_total_default'] ?? $this->order->default_total_amount;

            // Convert to display currency
            $this->calculatedTaxAmount = $this->currencyService->convertFromDefault(
                $this->calculatedTaxAmountDefault,
                $this->displayCurrency
            );

            $this->calculatedGrandTotal = $this->currencyService->convertFromDefault(
                $this->calculatedGrandTotalDefault,
                $this->displayCurrency
            );

            Log::info('Tax recalculated at checkout', [
                'order_id' => $this->order->order_id,
                'gateway' => $this->gateway,
                'is_topup' => $isTopUp,
                'scenario' => $taxCalc['scenario'] ?? 'unknown',
                'wallet_balance_default' => $this->walletBalanceDefault,
                'order_amount_default' => $this->order->default_total_amount,
                'tax_amount_default' => $this->calculatedTaxAmountDefault,
                'grand_total_default' => $this->calculatedGrandTotalDefault,
                'tax_amount_display' => $this->calculatedTaxAmount,
                'grand_total_display' => $this->calculatedGrandTotal,
                'currency' => $this->displayCurrency,
            ]);
        } catch (\Exception $e) {
            Log::error('Error calculating tax at checkout', [
                'order_id' => $this->order->order_id,
                'gateway' => $this->gateway,
                'error' => $e->getMessage(),
            ]);

            // Fallback: no tax if error
            $this->calculatedTaxAmountDefault = 0;
            $this->calculatedGrandTotalDefault = $this->order->default_total_amount;
            $this->calculatedTaxAmount = 0;
            $this->calculatedGrandTotal = $this->order->total_amount;
        }
    }

    public function render()
    {
        return view('livewire.backend.user.payments.checkout');
    }

    /**
     * Process payment with wallet top-up logic
     */
    public function processPayment()
    {

        if ($this->processing) {
            return;
        }

        $this->processing = true;

        $this->validate([
            'gateway' => 'required|in:'.$this->gateways->pluck('slug')->join(','),
        ]);

        try {
            if ($this->order->user_id !== user()->id) {
                Log::warning('Unauthorized payment attempt', [
                    'order_id' => $this->order->order_id,
                    'order_user_id' => $this->order->user_id,
                    'requesting_user_id' => user()->id,
                ]);
                session()->flash('error', 'Unauthorized access to this order.');

                return;
            }

            // Check if wallet is selected and balance is insufficient
            if ($this->gateway === 'wallet' && $this->walletBalance < $this->calculatedGrandTotal) {
                // For top-up scenario: calculate tax only on remaining balance
                $remainingBalanceDefault = $this->order->default_total_amount - $this->walletBalanceDefault;

                // Calculate tax only on the remaining amount (for top-up)
                $topUpTaxCalc = $this->taxService->calculateTax(
                    paymentMethod: 'stripe', // Use stripe rate for top-up calculation
                    amountDefault: $remainingBalanceDefault,
                    walletBalanceDefault: 0, // No wallet balance for top-up
                    isTopUp: false
                );

                $topUpTaxAmountDefault = $topUpTaxCalc['tax_amount_default'] ?? 0;
                $topUpGrandTotalDefault = $remainingBalanceDefault + $topUpTaxAmountDefault;

                // Set calculated tax for display
                $this->calculatedTaxAmountDefault = $topUpTaxAmountDefault;
                $this->calculatedGrandTotalDefault = $topUpGrandTotalDefault;

                // Convert to display currency
                $this->calculatedTaxAmount = $this->currencyService->convertFromDefault(
                    $this->calculatedTaxAmountDefault,
                    $this->displayCurrency
                );

                $this->calculatedGrandTotal = $this->currencyService->convertFromDefault(
                    $this->calculatedGrandTotalDefault,
                    $this->displayCurrency
                );

                // Calculate shortage in DISPLAY currency
                $this->requiredTopUpAmount = $this->calculatedGrandTotal - $this->walletBalance;
                $this->showTopUpModal = true;
                $this->topUpGateway = $this->topUpGateways->first()?->slug;
                $this->processing = false;

                Log::info('Insufficient wallet balance - showing top-up modal', [
                    'order_id' => $this->order->order_id,
                    'wallet_balance_default' => $this->walletBalanceDefault,
                    'wallet_balance_display' => $this->walletBalance,
                    'order_total_default' => $this->order->default_total_amount,
                    'order_total_display' => $this->order->total_amount,
                    'remaining_balance_default' => $remainingBalanceDefault,
                    'top_up_tax_default' => $this->calculatedTaxAmountDefault,
                    'top_up_grand_total_default' => $this->calculatedGrandTotalDefault,
                    'calculated_tax_display' => $this->calculatedTaxAmount,
                    'calculated_grand_total_display' => $this->calculatedGrandTotal,
                    'shortage_display' => $this->requiredTopUpAmount,
                    'currency' => $this->displayCurrency,
                ]);

                return;
            }

            // ========================================================
            // UPDATE ORDER WITH CALCULATED TAX BEFORE PAYMENT
            // This ensures the order has the correct tax amounts
            // based on the payment method
            // ========================================================
            $this->taxService->updateOrderWithTax(
                $this->order,
                $this->calculatedTaxAmountDefault,
                $this->calculatedTaxAmount,
                $this->calculatedGrandTotalDefault,
                $this->calculatedGrandTotal
            );

            // Re-load order to ensure it has updated values
            $this->order->refresh();

            // Process normal payment
            $result = $this->paymentService->processPayment(
                order: $this->order,
                gateway: $this->gateway,
                paymentData: [
                    'display_currency' => $this->displayCurrency,
                    'exchange_rate' => $this->exchangeRate,
                    'tax_amount' => $this->calculatedTaxAmount,
                    'tax_amount_default' => $this->calculatedTaxAmountDefault,
                    'grand_total' => $this->calculatedGrandTotal,
                    'grand_total_default' => $this->calculatedGrandTotalDefault,
                ]
            );

            if ($result['success']) {
                Log::info('Payment initialized successfully', [
                    'order_id' => $this->order->order_id,
                    'gateway' => $this->gateway,
                    'user_id' => user()->id,
                    'currency' => $this->displayCurrency,
                ]);

                // if ($this->gateway === 'stripe' && isset($result['checkout_url'])) {
                //     return redirect()->to($result['checkout_url']);
                // } elseif ($this->gateway === 'wallet' && isset($result['redirect_url'])) {
                //     session()->flash('success', $result['message']);
                //     return redirect()->to($result['redirect_url']);
                // } else {
                //     session()->flash('success', $result['message']);
                //     return redirect()->route('user.order.complete', ['orderId' => $this->order->order_id]);
                // }

                if (isset($result['checkout_url']) && ! empty($result['checkout_url'])) {
                    return redirect()->to($result['checkout_url']);
                } elseif ($this->gateway === 'wallet' && isset($result['redirect_url'])) {
                    session()->flash('success', $result['message']);

                    return redirect()->to($result['redirect_url']);
                } else {
                    session()->flash('success', $result['message']);

                    return redirect()->route('user.order.complete', ['orderId' => $this->order->order_id]);
                }
            } else {
                session()->flash('error', $result['message'] ?? 'Payment processing failed');
            }
        } catch (\Exception $e) {
            Log::error('Payment processing error in Livewire', [
                'order_id' => $this->order->order_id,
                'gateway' => $this->gateway,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            session()->flash('error', 'An unexpected error occurred. Please try again.');
        } finally {
            $this->processing = false;
        }
    }

    /**
     * Process top-up and then payment
     */
    public function processTopUpAndPayment()
    {
        if ($this->processing) {
            return;
        }

        $this->processing = true;

        $this->validate([
            'topUpGateway' => 'required|in:'.$this->topUpGateways->pluck('slug')->join(','),
        ]);

        try {
            // For top-up scenario: tax is already calculated on remaining balance only
            // Prepare the final amounts for order update
            $remainingBalanceDefault = $this->order->default_total_amount - $this->walletBalanceDefault;
            $topUpTaxAmountDefault = $this->calculatedTaxAmountDefault;
            $topUpGrandTotalDefault = $remainingBalanceDefault + $topUpTaxAmountDefault;

            // ========================================================
            // UPDATE ORDER WITH CALCULATED TAX BEFORE TOP-UP PAYMENT
            // For top-up scenarios, tax is only on remaining balance
            // ========================================================
            $this->taxService->updateOrderWithTax(
                $this->order,
                $topUpTaxAmountDefault,
                $this->calculatedTaxAmount,
                $topUpGrandTotalDefault,
                $this->calculatedGrandTotal
            );

            // Re-load order to ensure it has updated values
            $this->order->refresh();

            // Process top-up payment through selected gateway
            $result = $this->paymentService->processTopUpAndPayment(
                order: $this->order,
                topUpGateway: $this->topUpGateway,
                topUpAmount: $this->requiredTopUpAmount,
                paymentData: [
                    'display_currency' => $this->displayCurrency,
                    'exchange_rate' => $this->exchangeRate,
                    'tax_amount' => $this->calculatedTaxAmount,
                    'tax_amount_default' => $topUpTaxAmountDefault,
                    'grand_total' => $this->calculatedGrandTotal,
                    'grand_total_default' => $topUpGrandTotalDefault,
                ]
            );

            if ($result['success']) {
                Log::info('Top-up payment initialized successfully', [
                    'order_id' => $this->order->order_id,
                    'top_up_gateway' => $this->topUpGateway,
                    'top_up_amount' => $this->requiredTopUpAmount,
                    'user_id' => user()->id,
                    'currency' => $this->displayCurrency,
                    'remaining_balance_default' => $remainingBalanceDefault,
                    'tax_amount_default' => $topUpTaxAmountDefault,
                    'grand_total_default' => $topUpGrandTotalDefault,
                ]);

                // Redirect to payment gateway
                if (isset($result['checkout_url'])) {
                    return redirect()->to($result['checkout_url']);
                } else {
                    session()->flash('success', $result['message']);

                    return redirect()->route('user.order.complete', ['orderId' => $this->order->order_id]);
                }
            } else {
                session()->flash('error', $result['message'] ?? 'Top-up payment failed');
                $this->closeTopUpModal();
            }
        } catch (\Exception $e) {
            Log::error('Top-up payment processing error', [
                'order_id' => $this->order->order_id,
                'top_up_gateway' => $this->topUpGateway,
                'error' => $e->getMessage(),
            ]);

            session()->flash('error', 'An unexpected error occurred. Please try again.');
            $this->closeTopUpModal();
        } finally {
            $this->processing = false;
        }
    }

    public function closeTopUpModal()
    {
        $this->showTopUpModal = false;
        $this->topUpGateway = null;
    }
}
