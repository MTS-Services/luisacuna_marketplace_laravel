<?php

namespace App\Livewire\Backend\Admin\AdminManagement\Admin;

use App\Enums\AdminStatus;
use App\Livewire\Forms\Backend\Admin\AdminManagement\AdminForm;
use App\Models\Admin;
use App\Services\AdminService;
use App\Services\RoleService;
use App\Traits\Livewire\WithNotification;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class Edit extends Component
{
    use WithFileUploads, WithNotification;

    public AdminForm $form;
    public Admin $data;
    public $existingAvatar;
    public $dataId;

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
        $this->dataId = $data->id;
        $this->form->setData($data);
        $this->existingAvatar = $data->avatar_url;
    }

    public function render()
    {
        $roles = $this->roleService->getAllDatas();
        return view('livewire.backend.admin.admin-management.admin.edit', [
            'statuses' => AdminStatus::options(),
            'roles' => $roles
        ]);
    }

    public function save()
    {
        $data =  $this->form->validate();

        try {

            $data['updated_by'] = admin()->id;

            $this->data = $this->service->updateData($this->dataId, $data);
            Log::info('Data updated successfully', ['data_id' => $this->data->id]);

            $this->success('Data updated successfully');
            
            return $this->redirect(route('admin.am.admin.index'), navigate: true);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation failed', [
                'errors' => $e->errors()
            ]);
            throw $e;
        } catch (\Exception $e) {
            Log::error('Failed to update Data', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            $this->error('Failed to update Data: ' . $e->getMessage());
        }
    }

    public function removeAvatar(): void
    {
        $this->form->remove_avatar = true;
        $this->existingAvatar = null;
        $this->form->avatar = null;
    }

      public function resetForm(): void
    {
        $this->form->setData($this->data);
        $this->form->resetValidation();
    }
}
