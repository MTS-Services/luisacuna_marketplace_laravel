<?php

namespace App\Livewire\Backend\Admin\GameManagement\Platform;

use App\Enums\GamePlatformStatus;
use App\Livewire\Forms\Backend\Admin\GameManagement\GamePlatformForm;
use App\Models\GamePlatform;
use App\Services\GamePlatformService;
use App\Traits\Livewire\WithNotification;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;

class Edit extends Component
{

    use WithNotification, WithFileUploads;
    public GamePlatformForm $form;
    public GamePlatform $data;
    protected GamePlatformService $service;

    public function boot(GamePlatformService $service)
    {
        $this->service = $service;
    }
    public function mount(GamePlatform $data)
    {
        $this->data = $data;

        $this->form->setData($data);
    }
    public function render()
    {
        return view(
            'livewire.backend.admin.game-management.platform.edit',
            [
                'statuses' => GamePlatformStatus::options(),
            ]
        );
    }

    /**
     * Handle form submission to update the language.
     */
    public function save()
    {
        $this->form->validate();
        try {
            $data = $this->form->fillables();

            $data['updated_by'] = admin()->id;

            if(! isset($data['slug'])) $data['slug'] = Str::slug($data['name']);
           
            $this->service->updateData($this->data->id, $data);

            $this->success('Data updated successfully.');

            return $this->redirect(route('admin.gm.platform.index'), navigate: true);
        } catch (\Exception $e) {

          
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
}
