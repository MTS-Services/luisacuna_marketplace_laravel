<?php

namespace App\Livewire\Backend\Admin\AdminManagement\Role;

use App\Livewire\Forms\RoleForm;
use App\Models\Role;
use App\Services\PermissionService;
use App\Services\RoleService;
use App\Traits\Livewire\WithNotification;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\Attributes\Locked;

class Edit extends Component
{
    use WithNotification;

    public RoleForm $form;

    #[Locked]
    public Role $data;

    protected RoleService $service;
    protected PermissionService $permissionService;

    public function boot(RoleService $service, PermissionService $permissionService): void
    {
        $this->service = $service;
        $this->permissionService = $permissionService;
    }

    public function mount(Role $data): void
    {
        $this->data = $data;
        $this->form->setData($this->data);

        // Load existing role permissions
        $this->form->permissions = $this->data->permissions()->pluck('id')->toArray();
    }

    public function render()
    {
        // Get permissions grouped by prefix
        $permissions = $this->permissionService->getAllGroupedByPrefix('prefix', 'asc');
        return view(
            'livewire.backend.admin.admin-management.role.edit',
            [
                'permissions' => $permissions,
            ]
        );
    }

    public function save()
    {
        $data = $this->form->validate();

        try {
            $data['updated_by'] = admin()->id;
            $this->service->updateData($this->data->id, $data);

            // Sync permissions with the role
            if (!empty($data['permissions'])) {
                $this->data->permissions()->sync($data['permissions']);
            } else {
                // If no permissions selected, detach all
                $this->data->permissions()->detach();
            }

            $this->success('Role updated successfully with selected permissions');
            return $this->redirect(route('admin.am.role.index'), navigate: true);
        } catch (\Exception $e) {
            Log::error('Failed to update role: ' . $e->getMessage(), [
                'exception' => $e,
                'trace' => $e->getTraceAsString()
            ]);
            $this->error('Failed to update role. Please try again.');
        }
    }

    public function resetForm(): void
    {
        $this->form->reset();

        $this->form->setData($this->data);
        $this->form->permissions = $this->data->permissions()->pluck('id')->toArray();
    }
}
