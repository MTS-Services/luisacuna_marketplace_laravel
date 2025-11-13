<?php

namespace App\Livewire\Backend\Admin\RewardManagement\Rank;

use App\Models\Rank;
use Livewire\Component;

class View extends Component
{

     public Rank $data;
    public function mount(Rank $data): void
    {
        $this->data = $data;
    }
    public function render()
    {
        return view('livewire.backend.admin.reward-management.rank.view');
    }
}
