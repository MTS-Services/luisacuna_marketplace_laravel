<?php

namespace App\Livewire\Backend\Admin\Components\AdminManagement\Admin;

use App\Enums\AdminStatus;
use App\Models\Admin;
use App\Services\Admin\AdminService;

use Livewire\Component;


class View extends Component
{ 


    public Admin $admin;
    public $existingAvatar;
    public $adminId;

    protected AdminService $adminService;


    public function boot(AdminService $adminService)
    {
        $this->adminService = $adminService;
    }

    public function mount(Admin $admin): void
    {
       
        $this->admin = $admin;
        $this->adminId = $admin->id;
        $this->existingAvatar = $admin->avatar_url;

    }

  public function render()
    {

         return view('livewire.backend.admin.components.admin-management.admin.view',[
            'statuses' => AdminStatus::options(),
        ]);
    }

}
