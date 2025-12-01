<?php

namespace App\Livewire\Backend\Admin;

use App\Traits\Livewire\WithNotification;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Dashboard extends Component
{
    use WithNotification;
    public function mount()
    {
        $this->toastSuccess('Welcome to Admin Dashboard!');
    }
    public function render()
    {
        return view('livewire.backend.admin.dashboard');
    }
}
