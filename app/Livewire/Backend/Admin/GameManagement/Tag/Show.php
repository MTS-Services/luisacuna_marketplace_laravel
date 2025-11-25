<?php

namespace App\Livewire\Backend\Admin\GameManagement\Tag;

use App\Models\Tag;
use Livewire\Component;

class Show extends Component
{
    public Tag $data;
    public function mount(Tag $data)
    {
        $this->data = $data;
    }
    public function render()
    {
        return view('livewire.backend.admin.game-management.tag.show');
    }
}
