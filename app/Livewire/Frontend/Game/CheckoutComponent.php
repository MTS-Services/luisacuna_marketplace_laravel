<?php

namespace App\Livewire\Frontend\Game;

use App\Enums\OrderStatus;
use App\Models\Order;
use App\Models\PaymentGateway;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Session;
use Livewire\Component;
use App\Services\OrderService;

class CheckoutComponent extends Component
{

    public ?Order $order;
    public ?Collection $gateways;
    public ?string $gateway;

    public ?string $cardNumber;
    public ?string $cardExpiry;
    public ?string $cardCvc;

    protected OrderService $orderService;

    public function boot(OrderService $orderService)
    {
        $this->orderService = $orderService;

    }
    public function mount($slug, $token)
    {
        $key = $key = "checkout_{$token}";
        $sessionKey = Session::driver('redis')->get($key);

        if (!$sessionKey) {
            abort(404, 'Checkout link is invalid or has expired');
        }

        // 2. Check if 10 minutes have passed
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
    }

    public function render()
    {
        return view('livewire.frontend.game.checkout-component');
    }
}
