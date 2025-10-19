<?php

namespace App\Livewire\Backend\Admin\Components\GameManagement\Category;

use App\Models\GameCategory;
use Livewire\Component;

class Show extends Component
{
    public GameCategory $category;
    public function mount(GameCategory $category):void{
        $this->category = $category;
    }
    public function render()
    {
        return view('livewire.backend.admin.components.game-management.category.show');
    }
}
