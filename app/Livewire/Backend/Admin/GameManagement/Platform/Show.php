<?php

namespace App\Livewire\Backend\Admin\GameManagement\Platform;

use App\Models\GamePlatform;
use Livewire\Component;

class Show extends Component
{
    public GamePlatform $data;
    public function mount(GamePlatform $data): void{
        $this->data = $data;
    }
    public function render()
    {
        return view('livewire.backend.admin.game-management.platform.show');
    }
}
