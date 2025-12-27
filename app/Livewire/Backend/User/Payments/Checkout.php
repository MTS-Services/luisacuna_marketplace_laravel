<?php

namespace App\Livewire\Backend\User\Payments;

use App\Enums\OrderStatus;
use App\Models\Order;
use App\Models\PaymentGateway;
use App\Models\Wallet;
use App\Services\PaymentService;
use App\Services\OrderService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class Checkout extends Component
{
    public ?Order $order;
    public ?Collection $gateways;
    public ?string $gateway = null;
    public ?float $walletBalance = null;
    public bool $showWalletWarning = false;
    public bool $processing = false;

    protected OrderService $orderService;
    protected PaymentService $paymentService;

    public function boot(OrderService $orderService, PaymentService $paymentService)
    {
        $this->orderService = $orderService;
        $this->paymentService = $paymentService;
    }

    public function mount($slug, $token)
    {
        $key = "checkout_{$token}";
        $sessionKey = Session::driver('redis')->get($key);

        if (!$sessionKey) {
            abort(404, 'Checkout link is invalid or has expired');
        }

        // Check if 10 minutes have passed
        if (now()->timestamp > $sessionKey['expires_at']) {
            Session::driver('redis')->forget($key);
            abort(403, 'Sorry, the checkout link has expired');
        }

        $this->order = $this->orderService->findData($sessionKey['order_id']);
        $this->order->load(['user', 'source.platform', 'source.product_configs.game_configs', 'source.user' ]);

        if (!$this->order || $this->order->status !== OrderStatus::INITIALIZED) {
            abort(404, 'Checkout link is invalid or has expired');
        }

        $this->gateways = PaymentGateway::where('is_active', true)
            ->orderBy('sort_order', 'asc')
            ->select(['id', 'slug', 'name'])
            ->get()
            ->filter(fn($gateway) => $gateway->isSupported());

        $this->gateway = $this->gateways->first()?->slug;

        // Load wallet balance directly (fast)
        if ($this->gateways->where('slug', 'wallet')->isNotEmpty()) {
            $this->loadWalletBalance();
        }
    }

    protected function loadWalletBalance()
    {
        try {
            // Single optimized query
            $this->walletBalance = Wallet::where('user_id', $this->order->user_id)
                ->value('balance') ?? 0;
        } catch (\Exception $e) {
            Log::error('Failed to load wallet balance', [
                'user_id' => $this->order->user_id,
                'error' => $e->getMessage()
            ]);
            $this->walletBalance = 0;
        }
    }

    public function updatedGateway()
    {
        // Check wallet balance when wallet is selected
        if ($this->gateway === 'wallet' && $this->walletBalance !== null) {
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
     * Process payment using Service Layer
     * This is now just a thin wrapper around the service
     */
    public function processPayment()
    {
        // Prevent double submission
        if ($this->processing) {
            return;
        }

        $this->processing = true;

        $this->validate([
            'gateway' => 'required|in:' . $this->gateways->pluck('slug')->join(','),
        ]);

        try {
            // Security check: Verify order belongs to authenticated user
            if ($this->order->user_id !== user()->id) {
                Log::warning('Unauthorized payment attempt', [
                    'order_id' => $this->order->order_id,
                    'order_user_id' => $this->order->user_id,
                    'requesting_user_id' => user()->id,
                ]);
                session()->flash('error', 'Unauthorized access to this order.');
                return;
            }

            // Use PaymentService to process payment
            $result = $this->paymentService->processPayment(
                order: $this->order,
                gateway: $this->gateway,
                paymentData: []
            );

            if ($result['success']) {
                Log::info('Payment initialized successfully', [
                    'order_id' => $this->order->order_id,
                    'gateway' => $this->gateway,
                    'user_id' => user()->id,
                ]);

                // Handle different payment methods
                if ($this->gateway === 'stripe' && isset($result['checkout_url'])) {
                    return redirect()->to($result['checkout_url']);
                } elseif ($this->gateway === 'wallet' && isset($result['redirect_url'])) {
                    // Wallet payment is instant, redirect to success page
                    session()->flash('success', $result['message']);
                    return redirect()->to($result['redirect_url']);
                } else {
                    session()->flash('success', $result['message']);
                    return redirect()->route('user.payment.success', ['order_id' => $this->order->order_id]);
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
}
