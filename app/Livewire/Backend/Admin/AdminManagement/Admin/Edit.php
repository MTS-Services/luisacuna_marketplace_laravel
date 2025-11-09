<?php

namespace App\Livewire\Backend\Admin\AdminManagement\Admin;

use App\Enums\AdminStatus;
use App\Livewire\Forms\Backend\Admin\AdminManagement\AdminForm;
use App\Models\Admin;
use App\Services\AdminService;
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


    public function boot(AdminService $service)
    {
        $this->service = $service;
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
        return view('livewire.backend.admin.admin-management.admin.edit', [
            'statuses' => AdminStatus::options(),
        ]);
    }

    public function save()
    {
        $this->form->validate();

        try {

            $data = $this->form->validate();

            $data['updater_id'] = admin()->id;

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
            Log::error('Failed to update Admin', [
                'admin_id' => $this->adminId,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            $this->error('Failed to update Admin: ' . $e->getMessage());
        }
    }

    public function removeAvatar(): void
    {
        Log::info('removeAvatar called', ['admin_id' => $this->adminId]);
        $this->form->remove_avatar = true;
        $this->existingAvatar = null;
        $this->form->avatar = null;
    }

    public function resetForm(): void
    {
        $this->form->reset();
    }
    public function cancel(): void
    {
        $this->redirect(route('admin.am.admin.index'), navigate: true);
    }
}
