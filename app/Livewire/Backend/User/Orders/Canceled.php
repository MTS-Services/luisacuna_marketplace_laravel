<?php

namespace App\Livewire\Backend\User\Orders;

use App\Models\Order;
use Livewire\Component;

class Canceled extends Component
{
    public Order $order;


    public function mount( string $orderId)
    {
        $this->order = Order::where('order_id', $orderId)->with(['user', 'source'])->first();
    }

    public function render()
    {
        return view('livewire.backend.user.orders.canceled');
    }
}
