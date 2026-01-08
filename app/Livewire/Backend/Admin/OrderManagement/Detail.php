<?php

namespace App\Livewire\Backend\Admin\OrderManagement;

use App\Models\Order;
use Livewire\Component;
use Livewire\Attributes\On;
use App\Services\OrderService;

class Detail extends Component
{
    public Order $data;
    public function mount(Order $data): void
    {
        $this->data = $data;
    }
    public function render()
    {
        return view('livewire.backend.admin.order-management.detail');
    }
}
