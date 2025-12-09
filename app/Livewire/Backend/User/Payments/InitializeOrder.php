<?php

namespace App\Livewire\Backend\User\Payments;

use App\Models\Currency;
use App\Models\Order;
use App\Models\Product;
use App\Services\OrderService;
use App\Traits\Livewire\WithNotification;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class InitializeOrder extends Component
{

    use WithNotification;
    public ?Product $product = null;
    public int $quantity = 1;

    public OrderService $orderService ;
    public function boot (OrderService $orderService)
    {
     $this->orderService = $orderService;   
    }

    public function mount($productId)
    {
        $this->product = Product::where('id', decrypt($productId))->first();
    }

    public function updatedQuantity()
    {
        // Prevent invalid quantity
        if ($this->quantity < 1) {
            $this->quantity = 1;
        }

        if ($this->product && $this->quantity > $this->product->quantity) {
            $this->quantity = $this->product->quantity;
        }
    }

    //Here to Buy Now button triggered submit method to inital orders. 

    public function submit()
    {

        $token = bin2hex(random_bytes(126));
        $order = $this->orderService->createData([
            'order_id' => generate_order_id_hybrid(),
            'user_id' => user()->id,
            'source_id' => $this->product->id,
            'source_type' => Product::class,
            'total_amount' => $this->product->price,
            'tax_amount' => 0,
            'grand_total' => ($this->product->price * $this->quantity),
        ]);
        Session::driver('database')->put("checkout_{$token}", [
            'order_id' => $order->id,
            'price_locked' => ($this->product->price * $this->quantity),
            'expires_at' => now()->addMinutes((int) env('ORDER_CHECKOUT_TIMEOUT_MINUTES', 5))->timestamp,
        ]);
        return $this->redirect(
            route('game.checkout', ['slug' => encrypt($this->product->id), 'token' => $token]),
            navigate: true
        );


    }

    public function render()
    {
        return view('livewire.backend.user.payments.initialize-order');
    }
}
