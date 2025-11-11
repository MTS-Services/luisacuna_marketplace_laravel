<?php

namespace App\Livewire\Backend\Admin\GameManagement\Platform;

use App\Enums\GamePlatformStatus;

use App\Livewire\Forms\Backend\Admin\GameManagement\GamePlatformForm;

use App\Services\GamePlatformService;
use App\Traits\Livewire\WithNotification;
use Illuminate\Support\Str;
use Livewire\Component;

class Create extends Component
{

    use WithNotification;

    public GamePlatformForm $form;

    public GamePlatformService $service;



    public function boot(GamePlatformService $service): void
    {
       
        $this->service = $service;
    }

    /**
     * Initialize default form values.
     */
    public function mount(): void
    {
        $this->form->status = GamePlatformStatus::ACTIVE->value;
    }

    /**
     * Render the component view.
     */
    public function render()
    {
        return view('livewire.backend.admin.game-management.platform.create', [

            'statuses' => GamePlatformStatus::options(),

        ]);
    }

    /**
     * Handle form submission to create a new currency.
     */
    public function save()
    {
        $this->form->validate();

        try {
            $data = $this->form->fillables();
            if (! isset($data['slug'])) $data['slug'] = Str::slug($data['name']);
            $data['created_by'] = admin()->id;

            $this->service->createData($data);

            $this->success('Data created successfully.');

            return $this->redirect(route('admin.gm.platform.index'), navigate: true);
        } catch (\Exception $e) {

            $this->error('Failed to create data');
        }
    }

    /**
     * Cancel creation and redirect back to index.
     */
    public function resetForm(): void
    {
        $this->form->reset();
    }
}
