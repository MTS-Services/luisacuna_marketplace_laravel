<?php

namespace App\Livewire\Backend\Admin\GameManagement\Category;

use App\Models\Category;
use Livewire\Component;

class Show extends Component
{
    public Category $data;
    public function mount(Category $data): void
    {
        $this->data = $data;
    }
    public function render()
    {
        return view('livewire.backend.admin.game-management.category.show');
    }
}
