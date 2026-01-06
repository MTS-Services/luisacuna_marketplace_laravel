<?php

namespace App\Livewire\Backend\User\Orders;

use App\Models\Order;
use Livewire\Component;
use App\Enums\OrderStatus;
use App\Services\OrderService;

class Complete extends Component
{
    public Order $order;
    public $isVisitSeller = false;
    public $conversationId = null;
    public $commentText = '';


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
