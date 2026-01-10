<?php

namespace App\Livewire\Backend\User\Orders;

use App\Models\Order;
use App\Services\OrderService;
use Livewire\Component;

class Details extends Component
{

    public Order $data;
    public $isVisitSeller = false;


    protected OrderService $orderService;

    public function boot(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }
    public function mount($orderId): void
    {
        
        $this->data = $this->orderService->findData($orderId, 'order_id');
        $this->isVisitSeller = $this->data->user_id !== user()->id;

        // dd($this->data);
    }
    public function render()
    {
        return view('livewire.backend.user.orders.details');
    }
}
