<?php

namespace App\Livewire\Backend\Admin\GameManagement\Rarity;

use App\Enums\RarityStatus;
use App\Livewire\Forms\RarityForm;
use App\Services\RarityService;
use App\Traits\Livewire\WithNotification;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithNotification, WithFileUploads;

    public RarityForm $form;

    protected RarityService $service;



    public function boot(RarityService $service): void
    {

        $this->service = $service;

    }

    /**
     * Initialize default form values.
     */
    public function mount(): void
    {
        $this->form->status = RarityStatus::ACTIVE->value;
    }

    /**
     * Render the component view.
     */
    public function render()
    {
        return view('livewire.backend.admin.game-management.rarity.create', [

            'statuses' => RarityStatus::options(),

        ]);
    }

    /**
     * Handle form submission to create a new currency.
     */
    public function save()
    {
        $data = $this->form->validate();

        
        try {

            $data['created_by'] = admin()->id;
            $this->service->createData($data);
            $this->success('Data created successfully.');

            return $this->redirect(route('admin.gm.rarity.index'), navigate: true);

        } catch (\Throwable $e) {
            log_error($e);
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
