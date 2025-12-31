<?php

namespace App\Livewire\Backend\Admin\ProfileManagement;

use App\Models\Admin;
use Livewire\Component;
use App\Services\AdminService;

class Index extends Component
{
    public Admin $admin;

    public function mount(AdminService $service)
    {
        $adminId = admin()->id;
        $this->admin = $service->findData($adminId);
    }

    public function render()
    {
        return view('livewire.backend.admin.profile-management.index');
    }
}
