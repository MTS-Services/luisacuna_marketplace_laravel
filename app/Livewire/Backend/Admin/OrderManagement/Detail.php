<?php

namespace App\Livewire\Backend\Admin\OrderManagement;

use App\Models\Order;
use Livewire\Attributes\On;
use Livewire\Component;

class Detail extends Component
{
    public bool $isLoading = true;
    public bool $orderDetailModalShow = true;
    public Order $order;

    public function boot()
    {
        $this->order = new Order();
    }

    public function closeModal()
    {
        $this->orderDetailModalShow = false;
    }

    public function render()
    {
        return view('livewire.backend.admin.order-management.detail');
    }

    #[On('order-detail-modal-open')]
    public function fetchOrderDetail($orderId)
    {
        $this->order = Order::where('order_id', $orderId)->with(['user', 'source'])->first();
    }
}
