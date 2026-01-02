<?php

namespace App\Livewire\Test;

use App\Enums\OrderStatus;
use App\Models\Order;
use App\Models\PaymentGateway;
use App\Models\TestItem;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class Checkout extends Component
{
    public ?Order $order;
    public ?Collection $gateways;
    public ?string $gateway;

    public ?string $cardNumber;
    public ?string $cardExpiry;
    public ?string $cardCvc;

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

        $this->order = Order::where('id', $sessionKey['order_id'])->with(['user', 'source'])->first();

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
        return view('livewire.test.checkout');
    }
}
