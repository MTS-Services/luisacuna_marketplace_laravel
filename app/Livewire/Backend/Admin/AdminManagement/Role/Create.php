<?php

namespace App\Livewire\Backend\Admin\AdminManagement\Role;





use App\Livewire\Forms\RoleForm;
use App\Services\RoleService;
use App\Traits\Livewire\WithNotification;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads, WithNotification;

    public RoleForm $form;

    protected RoleService $service;

    public function boot(RoleService $service)
    {
        $this->service = $service;
    }

    public function mount(): void
    {

    }

    public function render()
    {
        return view('livewire.backend.admin.admin-management.role.create');
    }
    public function save()
    {


        $data = $this->form->validate();
        try {
            $data['created_by'] = admin()->id;
            $this->service->createData($data);
            $this->success('Data created successfully');

            return $this->redirect(route('admin.am.role.index'), navigate: true);
        } catch (\Exception $e) {

            Log::error('Failed to create data: ' . $e->getMessage());
            $this->error('Failed to create data: ');
        }
    }

    public function resetForm(): void
    {
        $this->form->reset();
    }
    public function cancel(): void
    {
        $this->redirect(route('admin.am.role.index'), navigate: true);
    }
}
