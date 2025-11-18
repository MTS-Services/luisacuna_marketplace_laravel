<?php

namespace App\Livewire\Backend\Admin\GameManagement\Platform;

use App\Enums\PlatformStatus;
use App\Livewire\Forms\PlatformForm;
use App\Services\PlatformService;
use App\Traits\Livewire\WithNotification;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{

    use WithNotification, WithFileUploads;

    public PlatformForm $form;

    protected PlatformService $service;



    public function boot(PlatformService $service ): void
    {
       
        $this->service = $service;
       
    }

    /**
     * Initialize default form values.
     */
    public function mount(): void
    {
        $this->form->status = PlatformStatus::ACTIVE->value;
    }

    /**
     * Render the component view.
     */
    public function render()
    {
        return view('livewire.backend.admin.game-management.platform.create', [

            'statuses' => PlatformStatus::options(),

        ]);
    }

    /**
     * Handle form submission to create a new currency.
     */
    public function save()
    {
       $data =  $this->form->validate();

        try {
            
            $data['created_by'] = admin()->id;

            $this->service->createData($data);

            $this->success('Data created successfully.');

            return $this->redirect(route('admin.gm.platform.index'), navigate: true);

        } catch (\Exception $e) {

            Log::error('Failed to create data: ' . $e->getMessage());
            
            $this->error('Failed to create data');
        }
    }

    /**
     * Cancel creation and redirect back to index.
     */
    public function resetForm(): void
    {
       $this->form->reset();
       $this->dispatch('file-input-reset');
    }
}
