<?php

namespace App\Livewire\Backend\User\Orders;

use App\Models\Order;
use Livewire\Component;
use App\Enums\OrderStatus;

class Complete extends Component
{
    public Order $order;


    public function mount(string $orderId)
    {
        $this->order = Order::where('order_id', $orderId)->with(['user', 'source'])->first();
    }
    public function cancelOrder()
    {
        $this->order->status = OrderStatus::CANCELLED->value;
        $this->order->save();

        return redirect()->route('user.order.purchased-orders');
    }
    public function render()
    {
        return view('livewire.backend.user.orders.complete');
    }
}
