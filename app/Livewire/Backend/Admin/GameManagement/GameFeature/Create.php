<?php

namespace App\Livewire\Backend\Admin\GameManagement\GameFeature;

use App\Enums\GameFeatureStatus;
use App\Livewire\Forms\Backend\Admin\GameManagement\GameFeatureForm;
use App\Services\GameFeatureService;
use App\Traits\Livewire\WithNotification;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class Create extends Component
{
   use WithNotification, WithFileUploads;

    public GameFeatureForm $form;

    protected GameFeatureService $service;

    /**
     * Inject the CurrencyService via the boot method.
     */
    public function boot(GameFeatureService $service): void
    {
        $this->service = $service;
    }

    /**
     * Initialize default form values.
     */
    public function mount(): void
    {
         $this->form->status = GameFeatureStatus::ACTIVE->value;
    }

    /**
     * Render the component view.
     */
    public function render()
    {
        return view('livewire.backend.admin.game-management.game-feature.create', [
            'statuses' => GameFeatureStatus::options(),
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

            return $this->redirect(route('admin.gm.server.index'), navigate: true);
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
    }
}
