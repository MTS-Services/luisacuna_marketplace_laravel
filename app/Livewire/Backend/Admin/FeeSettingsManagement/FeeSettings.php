<?php

namespace App\Livewire\Backend\Admin\FeeSettingsManagement;

use Livewire\Component;
use App\Models\FeeSettings as FeeSettingsModel;
use Illuminate\Support\Facades\Log;
use App\Services\FeeSettingsService;
use App\Livewire\Forms\FeeSettingsForm;
use App\Traits\Livewire\WithNotification;

class FeeSettings extends Component
{
    use WithNotification;

    public FeeSettingsForm $form;
    public ?FeeSettingsModel $data = null;

    protected FeeSettingsService $service;

    public function boot(FeeSettingsService $service)
    {
        $this->service = $service;
    }

    public function mount()
    {
        $active = $this->service->getActiveFee();

        if ($active) {
            $this->data = $active;
            $this->form->setData($active);
        }
    }

    public function save()
    {
        $data = $this->form->validate();

        try {
            $data['updated_by'] = admin()->id;

            $this->service->createFeeSetting($data);

            $this->success('Fee settings updated successfully!');
        } catch (\Exception $e) {
            Log::error('Fee Setting Error: ' . $e->getMessage(), [
                'exception' => $e,
            ]);
            $this->error('Failed to update fee settings.');
        }
    }

    public function render()
    {
        return view('livewire.backend.admin.fee-settings-management.fee-settings');
    }

    public function resetForm()
    {
        $this->form->setData($this->data);
        $this->dispatch('file-input-reset');
    }
}
