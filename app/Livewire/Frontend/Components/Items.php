<?php

namespace App\Livewire\Frontend\Components;

use Livewire\Component;

class Items extends Component
{

    public $activeTab = 'items';

    public function switchTab($tab)
    {
        $this->activeTab = $tab;
    }
    public function render()
    {
        return view('livewire.frontend.components.items');
    }
}
