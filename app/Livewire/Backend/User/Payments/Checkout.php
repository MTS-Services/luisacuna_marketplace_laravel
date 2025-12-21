<?php

namespace App\Livewire\Backend\User\Payments;

use App\Enums\OrderStatus;
use App\Models\Order;
use App\Models\PaymentGateway;
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

    protected OrderService $orderService;

    public function boot(OrderService $orderService)
    {
        $this->orderService = $orderService;
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
        $this->order->load(['user', 'source']);

        if (!$this->order || $this->order->status !== OrderStatus::INITIALIZED) {
            abort(404, 'Checkout link is invalid or has expired');
        }

        $this->gateways = PaymentGateway::enabled()
            ->select(['id', 'slug', 'name'])
            ->get()
            ->filter(fn($gateway) => $gateway->isSupported());

        $this->gateway = $this->gateways->first()?->slug;

        // Get wallet balance if wallet gateway is available
        if ($this->gateways->where('slug', 'wallet')->isNotEmpty()) {
            $walletGateway = PaymentGateway::where('slug', 'wallet')->first();
            if ($walletGateway) {
                $walletMethod = $walletGateway->paymentMethod();
                $balanceInfo = $walletMethod->getWalletBalance($this->order->user_id);
                $this->walletBalance = $balanceInfo['balance'];
            }
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

    public function processPayment()
    {
        $this->validate([
            'gateway' => 'required|in:' . $this->gateways->pluck('slug')->join(','),
        ]);

        try {
            // Get selected payment gateway
            $paymentGateway = PaymentGateway::where('slug', $this->gateway)
                ->where('is_active', true)
                ->first();

            if (!$paymentGateway) {
                session()->flash('error', 'Selected payment gateway is not available.');
                return;
            }

            // Get payment method instance
            $paymentMethod = $paymentGateway->paymentMethod();

            // Start payment
            $result = $paymentMethod->startPayment($this->order);

            if ($result['success']) {
                // Handle different payment methods
                if ($this->gateway === 'stripe') {
                    // Redirect to Stripe Checkout
                    return redirect()->to($result['checkout_url']);
                } elseif ($this->gateway === 'wallet') {
                    // Wallet payment is instant, redirect to success page
                    session()->flash('success', $result['message']);
                    return redirect()->route('user.payment.success', ['order_id' => $this->order->order_id]);
                }
            } else {
                session()->flash('error', $result['message']);
            }
        } catch (\Exception $e) {
            Log::error('Payment processing error', [
                'order_id' => $this->order->order_id,
                'gateway' => $this->gateway,
                'error' => $e->getMessage(),
            ]);

            session()->flash('error', 'An error occurred while processing your payment. Please try again.');
        }
    }
}
