<?php

namespace App\Livewire\Backend\User\Payments;

use App\Models\Currency;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class InitializeOrder extends Component
{

    public ?Product $product = null;
    public int $quantity = 1;

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

        // dd($this->product, $this->quantity , $this->product->price * $this->quantity);

        $token = bin2hex(random_bytes(126));
        $order = Order::create([
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
