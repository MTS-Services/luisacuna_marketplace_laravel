<?php

namespace App\Livewire\Backend\Admin\AdminManagement\Permission;

use App\Models\Admin;
use App\Models\Permission;
use Livewire\Component;

class View extends Component
{

    public Permission $data;
    public function mount(Permission $data): void
    {
        $this->data = $data;
    }
    public function render()
    {
        return view('livewire.backend.admin.admin-management.permission.view');
    }
}
