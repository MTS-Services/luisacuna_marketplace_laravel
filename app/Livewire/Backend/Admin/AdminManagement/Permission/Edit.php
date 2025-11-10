<?php

namespace App\Livewire\Backend\Admin\AdminManagement\Permission;


use App\Livewire\Forms\PermissionForm;
use App\Models\Permission;
use App\Services\PermissionService;
use App\Traits\Livewire\WithNotification;
use Livewire\Component;
use Livewire\Attributes\Locked;


class Edit extends Component
{
    use WithNotification;

    public PermissionForm $form;

    #[Locked]
    public Permission $data;
    protected PermissionService $service;
    public function boot(PermissionService $service): void
    {
        $this->service = $service;
    }
    public function mount(Permission $data): void
    {
        $this->data = $data;
        $this->form->setData($this->data);
    }

    public function render()
    {
        return view('livewire.backend.admin.admin-management.permission.edit');
    }
    public function save()
    {
        $data = $this->form->validate();
        try {

            $data['updated_by'] = admin()->id;
            $this->service->updateData($this->data->id, $data);
            $this->success('Data updated successfully.');

            return $this->redirect(route('admin.am.permission.index'), navigate: true);
        } catch (\Exception $e) {
            $this->error('Failed to update data: ' . $e->getMessage());
        }
    }
    public function resetForm(): void
    {
        $this->form->setData($this->data);
        $this->form->resetValidation();
    }
}
