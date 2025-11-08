<?php

namespace App\Livewire\Backend\Admin\AdminManagement\Role;


use App\Livewire\Forms\RoleForm;

use App\Models\Role;
use App\Services\RoleService;
use App\Traits\Livewire\WithNotification;
use Livewire\Component;
use Livewire\Attributes\Locked;


class Edit extends Component
{
    use WithNotification;

    public RoleForm $form;

    #[Locked]
    public Role $data;
    protected RoleService $service;
    public function boot(RoleService $service): void
    {
        $this->service = $service;
    }
    public function mount(Role $data): void
    {
        $this->data = $data;
        $this->form->setData($this->data);
    }

    public function render()
    {
        return view('livewire.backend.admin.admin-management.role.edit');
    }
    public function save()
    {
        $data = $this->form->validate();
        try {

            $data['updated_by'] = admin()->id;
            $this->service->updateData($this->data->id, $data);
            $this->success('Data updated successfully.');

            return $this->redirect(route('admin.am.role.index'), navigate: true);
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
