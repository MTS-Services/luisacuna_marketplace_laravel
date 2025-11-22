<?php

namespace App\Livewire\Backend\Admin\RewardManagement\AchievementType;

use Livewire\Component;
use App\Models\AchievementType;
use Livewire\Attributes\Locked;
use App\Services\AchievementTypeService;
use App\Traits\Livewire\WithNotification;
use App\Livewire\Forms\AchievementTypeForm;

class Edit extends Component
{
    use WithNotification;

    public AchievementTypeForm $form;

    #[Locked]
   public AchievementType $data;
    protected AchievementTypeService $service;


    public function boot(AchievementTypeService $service)
    {
        $this->service = $service;
    }
    public function mount(AchievementType $data): void
    {
        $this->data = $data;
        $this->form->setData($data);
    }
    public function render()
    {
        return view('livewire.backend.admin.reward-management.achievement-type.edit');
    }

    /**
     * Handle form submission to create a new Achievement.
     */
    public function save()
    {
        $data = $this->form->validate();
        try {
            $data['updated_by'] = admin()->id;
            $this->service->updateData($this->data->id, $data);
             $this->dispatch('toggleAchievementTypeEditModal');

            $this->success('Data updated successfully.');
        } catch (\Exception $e) {
            $this->error('Failed to update data: ' . $e->getMessage());
        }
    }

    /**
     * Cancel creation and redirect back to index.
     */
    public function resetForm(): void
    {
        $this->form->setData($this->data);
        $this->form->resetValidation();
    }
}
