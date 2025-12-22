<?php

namespace App\Livewire\Backend\User\Payments;

use App\Enums\OrderStatus;
use App\Livewire\Backend\User\Wallet\Wallet;
use App\Models\Order;
use App\Models\Payment;
use App\Models\PaymentGateway;
use App\Services\ConversationService;
use App\Services\OrderService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\FacadesDB;
use Illuminate\Support\Facades\Log;
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
    protected ConversationService $conversationService;

    public function boot(OrderService $orderService, ConversationService $conversationService)
    {
        $this->orderService = $orderService;
        $this->conversationService = $conversationService;
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

        // Load wallet balance directly from database (much faster)
        $this->loadWalletBalance();
    }

    protected function loadWalletBalance()
    {
        if ($this->gateways->where('slug', 'wallet')->isEmpty()) {
            return;
        }

        $user = user();
        $user->load('wallet');
        $this->walletBalance = $user->wallet?->balance ?? 0;

        // try {
        //     // Direct database query - much faster than HTTP request
        //     $wallet = Wallet::where('user_id', $this->order->user_id)->first();
        //     $this->walletBalance = $wallet?->balance ?? 0;
        // } catch (\Exception $e) {
        //     Log::error('Failed to load wallet balance', ['error' => $e->getMessage()]);
        //     $this->walletBalance = 0;
        // }
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

            // Security check: Verify order status
            if ($this->order->status !== OrderStatus::INITIALIZED) {
                session()->flash('error', 'This order cannot be paid. Status: ' . $this->order->status->label());
                return;
            }

            // Check for existing successful payment
            $existingPayment = Payment::where('order_id', $this->order->id)
                ->whereIn('status', ['success', 'completed'])
                ->first();

            if ($existingPayment) {
                session()->flash('error', 'This order has already been paid.');
                return redirect()->route('user.payment.success', ['order_id' => $this->order->order_id]);
            }

            // Get selected payment gateway
            $paymentGateway = PaymentGateway::where('slug', $this->gateway)
                ->where('is_active', true)
                ->first();

            if (!$paymentGateway) {
                session()->flash('error', 'Selected payment gateway is not available.');
                return;
            }

            // Verify gateway is supported
            if (!$paymentGateway->isSupported()) {
                session()->flash('error', 'This payment gateway is currently not supported.');
                return;
            }

            // Start database transaction for wallet payments
            DB::beginTransaction();

            try {
                // Call payment method directly (no HTTP request)
                $paymentMethod = $paymentGateway->paymentMethod();
                $result = $paymentMethod->startPayment($this->order);

                if ($result['success']) {
                    DB::commit();

                    // Log successful payment initialization
                    Log::info('Payment initialized successfully', [
                        'order_id' => $this->order->order_id,
                        'gateway' => $this->gateway,
                        'user_id' => user()->id,
                    ]);

                    // Handle different payment methods
                    if ($this->gateway === 'stripe' && isset($result['checkout_url'])) {
                        // Redirect to Stripe Checkout
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
                    DB::rollBack();
                    session()->flash('error', $result['message'] ?? 'Payment processing failed');
                }
            } catch (\Exception $e) {
                DB::rollBack();
                throw $e;
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
