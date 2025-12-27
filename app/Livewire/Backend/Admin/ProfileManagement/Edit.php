<?php

namespace App\Livewire\Backend\Admin\ProfileManagement;

use App\Models\Admin;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Services\AdminService;
use Illuminate\Support\Facades\Log;
use App\Traits\Livewire\WithNotification;
use App\Livewire\Forms\Backend\Admin\AdminManagement\AdminForm;

class Edit extends Component
{

    use WithFileUploads, WithNotification;

    public AdminForm $form;
    public Admin $data;
    public $existingFile;
    public $existingFiles;

    protected AdminService $service;


    public function boot(AdminService $service)
    {
        $this->service = $service;
    }

    public function mount(Admin $data): void
    {
        $this->data = $data;
        $this->form->setData($data);
        $this->existingFile = $data->avatar;
        $this->existingFiles = $data->images->pluck('image')->toArray();
    }

    public function render()
    {
        return view('livewire.backend.admin.profile-management.edit');
    }

    public function save()
    {
        $data = $this->form->validate();
        try {
            $data['updated_by'] = admin()->id;

            $this->data = $this->service->updateData($this->data->id, $data);

            Log::info('Data updated successfully', ['data_id' => $this->data->id]);

            $this->success('Data updated successfully');

            return $this->redirect(route('admin.profile.index'), navigate: true);
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
