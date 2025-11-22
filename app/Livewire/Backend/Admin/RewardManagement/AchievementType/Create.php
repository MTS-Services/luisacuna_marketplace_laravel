<?php

namespace App\Livewire\Backend\Admin\RewardManagement\AchievementType;

use Livewire\Component;
use App\Livewire\Forms\AchievementTypeForm;
use App\Services\AchievementTypeService;
use App\Traits\Livewire\WithNotification;

class Create extends Component
{
    public AchievementTypeForm $form;

    use WithNotification;

    protected AchievementTypeService $service;

    public function boot(AchievementTypeService $service)
    {
        $this->service = $service;
    }

    public function render()
    {
        return view('livewire.backend.admin.reward-management.achievement-type.create');
    }

    public function save(): void
    {
        $data = $this->form->validate();
        try {
            $data['created_by'] = admin()->id;
            $this->service->createData($data);
            $this->form->reset();
            $this->dispatch('hideAchievementTypeModals');

            $this->success('Achievement Type created successfully');
        } catch (\Exception $e) {
            $this->error('Failed to create data: ' . $e->getMessage());
        }
    }

    public function resetForm(): void
    {
        $this->form->reset();
    }
}
