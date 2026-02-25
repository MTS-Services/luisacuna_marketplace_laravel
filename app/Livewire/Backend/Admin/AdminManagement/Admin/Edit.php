<?php

namespace App\Livewire\Backend\Admin\AdminManagement\Admin;

use App\Enums\AdminStatus;
use App\Livewire\Forms\Backend\Admin\AdminManagement\AdminForm;
use App\Models\Admin;
use App\Models\Role;
use App\Services\AdminService;
use App\Services\RoleService;
use App\Support\SuperAdminGuard;
use App\Traits\Livewire\WithNotification;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class Edit extends Component
{
    use WithFileUploads, WithNotification;

    public AdminForm $form;

    public Admin $data;

    public $existingFile;

    public $existingFiles;

    protected AdminService $service;

    protected RoleService $roleService;

    public function boot(AdminService $service, RoleService $roleService)
    {
        $this->service = $service;
        $this->roleService = $roleService;
    }

    public function mount(Admin $data): void
    {
        $this->data = $data;
        $superAdminRoleId = Role::getSuperAdminRoleId();
        if ((int) $this->data->role_id === $superAdminRoleId && ! SuperAdminGuard::isSuperAdmin()) {
            abort(403, 'Only a Super Admin can edit an admin with the Super Admin role.');
        }
        $this->form->setData($data);
        $this->existingFile = $data->avatar;
        $this->existingFiles = $data->images->pluck('image')->toArray();
    }

    public function render()
    {
        $roles = $this->roleService->getAllDatas();
        if (! SuperAdminGuard::isSuperAdmin()) {
            $roles = $roles->filter(fn ($role) => (int) $role->id !== Role::SUPER_ADMIN_ROLE_ID);
        }

        return view('livewire.backend.admin.admin-management.admin.edit', [
            'statuses' => AdminStatus::options(),
            'roles' => $roles,
        ]);
    }

    public function save()
    {
        $data = $this->form->validate();
        try {
            $data['updated_by'] = admin()->id;

            $this->data = $this->service->updateData($this->data->id, $data);

            Log::info('Data updated successfully', ['data_id' => $this->data->id]);

            $this->success('Data updated successfully');

            return $this->redirect(route('admin.am.admin.index'), navigate: true);

        } catch (\Illuminate\Auth\Access\AuthorizationException $e) {
            $this->error($e->getMessage());
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation failed', [
                'errors' => $e->errors(),
            ]);
            throw $e;
        } catch (\Exception $e) {
            Log::error('Failed to update Data', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            $this->error('Failed to update Data: '.$e->getMessage());
        }
    }

    public function resetForm(): void
    {
        $this->form->reset();
        $this->form->setData($this->data);

        // Reset existing files display
        $this->existingFile = $this->data->avatar;
        $this->existingFiles = $this->data->images->pluck('image')->toArray();
        $this->dispatch('file-input-reset');
    }
}
