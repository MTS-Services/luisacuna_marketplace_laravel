<?php

namespace App\Livewire\Backend\Admin\WithdrawalManagement\WithdrawalMethod;

use App\Models\WithdrawalMethod;
use Livewire\Component;

class Show extends Component
{
    public WithdrawalMethod  $data;
    public function mount(WithdrawalMethod $data): void
    {
        $this->data = $data;
    }
    public function render()
    {
        return view('livewire.backend.admin.withdrawal-management.withdrawal-method.show');
    }
}
