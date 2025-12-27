<?php

namespace App\Livewire\Backend\Admin\OrderManagement;

use App\Models\Order;
use Livewire\Component;
use Livewire\Attributes\On;
use App\Services\OrderService;

class Detail extends Component
{
    public bool $isLoading = true;
    public bool $orderDetailModalShow = false;
    // public Order $order;
    public $order;


    protected OrderService $orderService;

    public function boot(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }
    // public function boot()
    // {
    //     $this->order = new Order();
    // }
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
        $this->isLoading = true;
        $this->order = $this->orderService->findData($orderId, 'order_id');

        $this->order->load(['user', 'source.user', 'source.game', 'transactions']);



        $this->orderDetailModalShow = true;
        $this->isLoading = false;
    }
}
