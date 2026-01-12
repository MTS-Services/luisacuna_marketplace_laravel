<?php

namespace App\Livewire\Backend\User\Payments;

use App\Models\Order;
use App\Models\Wallet;
use Livewire\Component;
use App\Enums\OrderStatus;
use App\Enums\FeedbackType;
use App\Models\PaymentGateway;
use App\Services\CurrencyService;
use App\Services\OrderService;
use App\Services\PaymentService;
use App\Services\FeedbackService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Database\Eloquent\Collection;

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

    protected OrderService $orderService;
    protected PaymentService $paymentService;
    protected CurrencyService $currencyService;
    protected FeedbackService $feedbackService;



    public function boot(OrderService $orderService, PaymentService $paymentService, FeedbackService $feedbackService, CurrencyService $currencyService)
    {
        $this->orderService = $orderService;
        $this->paymentService = $paymentService;
        $this->currencyService = $currencyService;
        $this->feedbackService = $feedbackService;
    }

    public function mount($slug, $token)
    {
        $key = "checkout_{$token}";
        $sessionKey = Session::driver('redis')->get($key);

        if (!$sessionKey) {
            abort(404, 'Checkout link is invalid or has expired');
        }

        if (now()->timestamp > $sessionKey['expires_at']) {
            Session::driver('redis')->forget($key);
            abort(403, 'Sorry, the checkout link has expired');
        }

        $this->order = $this->orderService->findData($sessionKey['order_id']);
        $this->order->load(['user', 'source.platform',  'user.feedbacksReceived', 'source.product_configs.game_configs', 'source.user', 'source.game', 'source.user.wallet']);

        if (!$this->order || $this->order->status !== OrderStatus::INITIALIZED) {
            abort(404, 'Checkout link is invalid or has expired');
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
            ->filter(fn($gateway) => $gateway->isSupported());

        $this->gateway = $this->gateways->first()?->slug;

        // Load top-up gateways (exclude wallet)
        $this->topUpGateways = $this->gateways->filter(fn($g) => $g->slug !== 'wallet');

        if ($this->gateways->where('slug', 'wallet')->isNotEmpty()) {
            $this->loadWalletBalance();
        }
        $allFeedbacks = $this->order?->user?->feedbacksReceived()->get();
        $this->positiveFeedbacksCount = $this->order?->user?->feedbacksReceived()->where('type', FeedbackType::POSITIVE->value)->count();
        $this->negativeFeedbacksCount = $this->order?->user?->feedbacksReceived()->where('type', FeedbackType::NEGATIVE->value)->count();
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
                'error' => $e->getMessage()
            ]);
            $this->walletBalance = 0;
            $this->walletBalanceDefault = 0;
        }
    }

    public function updatedGateway()
    {
        if ($this->gateway === 'wallet' && $this->walletBalance !== null) {
            // Compare in DISPLAY currency (both are in same currency now)
            $this->showWalletWarning = $this->walletBalance < $this->order->grand_total;
        } else {
            $this->showWalletWarning = false;
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
            'gateway' => 'required|in:' . $this->gateways->pluck('slug')->join(','),
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
            if ($this->gateway === 'wallet' && $this->walletBalance < $this->order->grand_total) {
                // Calculate shortage in DISPLAY currency
                $this->requiredTopUpAmount = $this->order->grand_total - $this->walletBalance;
                $this->showTopUpModal = true;
                $this->topUpGateway = $this->topUpGateways->first()?->slug;
                $this->processing = false;

                Log::info('Insufficient wallet balance - showing top-up modal', [
                    'order_id' => $this->order->order_id,
                    'wallet_balance_display' => $this->walletBalance,
                    'order_total_display' => $this->order->grand_total,
                    'shortage_display' => $this->requiredTopUpAmount,
                    'currency' => $this->displayCurrency,
                ]);

                return;
            }

            // Process normal payment
            $result = $this->paymentService->processPayment(
                order: $this->order,
                gateway: $this->gateway,
                paymentData: [
                    'display_currency' => $this->displayCurrency,
                    'exchange_rate' => $this->exchangeRate,
                ]
            );

            if ($result['success']) {
                Log::info('Payment initialized successfully', [
                    'order_id' => $this->order->order_id,
                    'gateway' => $this->gateway,
                    'user_id' => user()->id,
                    'currency' => $this->displayCurrency,
                ]);

                if ($this->gateway === 'stripe' && isset($result['checkout_url'])) {
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
            'topUpGateway' => 'required|in:' . $this->topUpGateways->pluck('slug')->join(','),
        ]);

        try {
            // Process top-up payment through selected gateway
            $result = $this->paymentService->processTopUpAndPayment(
                order: $this->order,
                topUpGateway: $this->topUpGateway,
                topUpAmount: $this->requiredTopUpAmount,
                paymentData: [
                    'display_currency' => $this->displayCurrency,
                    'exchange_rate' => $this->exchangeRate,
                ]
            );

            if ($result['success']) {
                Log::info('Top-up payment initialized successfully', [
                    'order_id' => $this->order->order_id,
                    'top_up_gateway' => $this->topUpGateway,
                    'top_up_amount' => $this->requiredTopUpAmount,
                    'user_id' => user()->id,
                    'currency' => $this->displayCurrency,
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
