<?php

namespace App\Livewire\Backend\Admin\GameManagement\Platform;

use App\Enums\PlatformStatus;
use App\Livewire\Forms\PlatformForm;
use App\Models\Platform;
use App\Services\PlatformService;
use App\Traits\Livewire\WithNotification;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;

class Edit extends Component
{

    use WithNotification, WithFileUploads;
    public PlatformForm $form;
    public ?string $existingFile;
    public Platform $data;
    protected PlatformService $service;

    public function boot(PlatformService $service)
    {
        $this->service = $service;
    }
    public function mount(Platform $data)
    {
        $this->data = $data;
        $this->existingFile = $data->icon;
        $this->form->setData($data);

    }
    public function render()
    {
        return view(
            'livewire.backend.admin.game-management.platform.edit',
            [
                'statuses' => PlatformStatus::options(),
            ]
        );
    }

    /**
     * Handle form submission to update the language.
     */
    public function save()
    {
        $data = $this->form->validate();
        try {
          
            $data['updated_by'] = admin()->id;

            $this->service->updateData($this->data->id, $data);

            $this->success('Data updated successfully.');

            return $this->redirect(route('admin.gm.platform.index'), navigate: true);
        } catch (\Exception $e) {

            Log::error("Faild to Update Data". $e->getMessage());
            
            $this->error('Failed to update data');
        }
    }

    /**
     * Cancel editing and redirect back to index.
     */
    public function cancel()
    {
        // $this->form->reset();
        // $this->form->resetValidation();

        return $this->redirect(route('admin.as.currency.index'), navigate: true);

    }

       public function resetForm(): void
    {
        $this->form->reset();
        $this->form->setData($this->data);
        // $this->existingFile = $this->data->icon;
        $this->existingFile = $this->data->avatar;
    
        $this->dispatch('file-input-reset');
    }
}
