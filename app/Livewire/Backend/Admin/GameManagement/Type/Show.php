<?php

namespace App\Livewire\Backend\Admin\GameManagement\Type;

use App\Models\Type;
use Livewire\Component;

class Show extends Component
{
    public Type $data;
    public function mount(Type $data)
    {
        $this->data = $data;
    }
    public function render()
    {
        return view('livewire.backend.admin.game-management.type.show');
    }
}
