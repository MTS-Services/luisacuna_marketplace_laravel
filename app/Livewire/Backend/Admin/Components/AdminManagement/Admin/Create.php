<?php

namespace App\Livewire\Backend\Admin\Components\AdminManagement\Admin;

use App\DTOs\Admin\CreateAdminDTO;
use App\Enums\AdminStatus;
use App\Livewire\Forms\Backend\Admin\AdminManagement\AdminForm;
use App\Services\Admin\AdminService;
use App\Traits\Livewire\WithNotification;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads, WithNotification;

    public AdminForm $form;

    protected AdminService $adminService;

    public function boot(AdminService $adminService)
    {
        $this->adminService = $adminService;
    }

    public function mount(): void
    {
        $this->form->status = AdminStatus::ACTIVE->value;
    }

    public function render()
    {
        return view('livewire.backend.admin.components.admin-management.admin.create', [
            'statuses' => AdminStatus::options(),
        ]);
    }
    public function save()
    {
       

        try {
            $data =  $this->form->fillables();
           
            $admin = $this->adminService->createAdmin($data);

            $this->dispatch('Admin is created');
            $this->success('Admin created successfully');

            Log::info('Admin created successfully' , $admin);

            return $this->redirect(route('admin.am.admin.index'), navigate: true);

        } catch (\Exception $e) {

            Log::error('Failed to create user: ' , $e);

            $this->error('Failed to create user: ' . $e->getMessage());
        }
    }

    public function resetForm(): void{
        $this->form->reset();
    }
    public function cancel(): void
    {
        $this->redirect(route('admin.am.admin.index'), navigate: true);
    }
}
