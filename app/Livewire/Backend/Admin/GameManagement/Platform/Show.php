<?php

namespace App\Livewire\Backend\Admin\GameManagement\Platform;

use App\Models\Platform;
use Livewire\Component;

class Show extends Component
{
    public Platform $data;
    public function mount(Platform $data): void{
        $this->data = $data;
    }
    public function render()
    {
        return view('livewire.backend.admin.game-management.platform.show');
    }
}
