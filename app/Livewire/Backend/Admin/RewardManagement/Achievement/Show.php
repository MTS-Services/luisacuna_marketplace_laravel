<?php

namespace App\Livewire\Backend\Admin\RewardManagement\Achievement;

use App\Models\Achievement;
use Livewire\Component;

class Show extends Component
{

    public Achievement  $data;
    public function mount(Achievement $data): void
    {
        $this->data = $data;
    }
    public function render()
    {
        return view('livewire.backend.admin.reward-management.achievement.show');
    }
}
