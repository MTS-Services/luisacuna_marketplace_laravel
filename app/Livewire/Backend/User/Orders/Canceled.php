<?php

namespace App\Livewire\Backend\User\Orders;

use App\Models\Order;
use Livewire\Component;
use App\Services\OrderService;

class Canceled extends Component
{
    // public Order $order;


    // public function mount( string $orderId)
    // {
    //     $this->order = Order::where('order_id', $orderId)->with(['user', 'source'])->first();
    // }


    public Order $order;
    public $isVisitSeller = false;
    public $conversationId = null;


    protected OrderService $orderService;
    public function boot(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function mount(string $orderId)
    {
        $this->order = $this->orderService->findData($orderId, 'order_id');
        $this->order->load(['user', 'source.user', 'source.game', 'source.platform', 'transactions', 'messages.conversation']);
        $this->isVisitSeller = $this->order->user_id !== user()->id;
        $this->conversationId = $this->order->messages?->first()?->conversation->id ?? null;
        $this->dispatch('conversation-selected', conversationId: $this->conversationId);
    }

    public function render()
    {
        return view('livewire.backend.user.orders.canceled');
    }
}
