<?php

namespace App\Livewire\Backend\User\Payments;


use App\Models\User;
use App\Models\Product;
use Livewire\Component;
use App\Services\OrderService;
use App\Services\OrderMessageService;
use Illuminate\Support\Facades\Session;
use App\Traits\Livewire\WithNotification;

class InitializeOrder extends Component
{

    use WithNotification;
    public ?Product $product = null;
    public int $quantity = 1;

    protected OrderService $orderService;
    protected OrderMessageService $OrderMessage;
    public function boot(OrderService $orderService, OrderMessageService $OrderMessage)
    {
        $this->orderService = $orderService;
        $this->OrderMessage = $OrderMessage;
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


        $buyer = user(); // অথবা User::find(user()->id)
        $seller = User::find($this->product->user_id);

        $conversation = $this->OrderMessage->getOrCreateConversation($buyer, $seller);

        $this->OrderMessage->send(
            $conversation->id,
            'new order created',
        );


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
