<?php

namespace App\Livewire\Backend\Admin\GameManagement\GameFeature;

use App\Enums\GameFeatureStatus;
use App\Livewire\Forms\Backend\Admin\GameManagement\GameFeatureForm;
use App\Models\GameFeature;
use App\Services\GameFeatureService;
use App\Traits\Livewire\WithNotification;
use Livewire\Component;
use Livewire\WithFileUploads;

class Edit extends Component
{
 use WithNotification, WithFileUploads;

    public GameFeatureForm $form;
    public GameFeature $data;
    protected GameFeatureService $service;
    public $existingFile; 
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
    public function mount(GameFeature $data): void
    {
        $this->form->setData($data);
        $this->data = $data;
        $this->existingFile = $data->icon;
    }

    /**
     * Render the component view.
     */
    public function render()
    {
        return view('livewire.backend.admin.game-management.game-feature.edit', [
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
            $data['updated_by'] = admin()->id;
            $this->service->updateData($this->data->id, $data);

            $this->success('Data updated successfully.');
            return $this->redirect(route('admin.gm.game-feature.index'), navigate: true);
        } catch (\Exception $e) {
            $this->error('Failed to update data: ' . $e->getMessage());
        }
    }

    /**
     * Cancel creation and redirect back to index.
     */
    public function cancel(): void
    {
        $this->form->reset();

        $this->redirect(route('admin.gm.game-feature.index'), navigate: true);
    }

    public function resetForm(){
        $this->form->reset();
        $this->form->setData($this->data);

        // Reset existing files display
        $this->existingFile = $this->data->icon;
        $this->dispatch('file-input-reset');
    }
}
