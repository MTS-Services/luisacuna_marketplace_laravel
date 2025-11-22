<?php

namespace App\Livewire\Backend\Admin\RewardManagement\AchievementType;


use App\Models\AchievementType;
use Livewire\Component;

class Show extends Component
{
    public AchievementType $data;
    public function mount(AchievementType $data): void
    {
        $this->data = $data;
    }
    public function render()
    {
        return view('livewire.backend.admin.reward-management.achievement-type.show');
    }
}
