<?php

namespace App\Livewire\Backend\Admin\GameManagement\Rarity;

use App\Models\Rarity;
use Livewire\Component;

class Show extends Component
{
    public Rarity $data;
    public function mount(Rarity $data)
    {
        $this->data = $data;
    }
    public function render()
    {
        return view('livewire.backend.admin.game-management.rarity.show');
    }
}
