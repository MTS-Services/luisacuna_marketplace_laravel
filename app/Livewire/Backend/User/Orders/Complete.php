<?php

namespace App\Livewire\Backend\User\Orders;

use Livewire\Component;

class Complete extends Component
{
    public $order;
    public function render()
    {
        return view('livewire.backend.user.orders.complete');
    }
}
