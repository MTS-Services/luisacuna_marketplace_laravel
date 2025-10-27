<?php

namespace App\Livewire\Frontend\Components;

use Livewire\Component;

class UserProfileComponent extends Component
{



    public $activeTab = 'currency';

    public $activeInnerMenu='shop';
    public function switchTab($tab)
    {
        $this->activeTab = $tab;
    }

    public function switchInnerMenu($menu)
    {
        $this->activeInnerMenu = $menu;
    }

    public function render()
    {
        return view('livewire.frontend.components.user-profile-component');
    }
}
