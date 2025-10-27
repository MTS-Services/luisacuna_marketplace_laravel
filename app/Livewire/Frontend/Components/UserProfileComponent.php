<?php

namespace App\Livewire\Frontend\Components;

use Livewire\Component;

class UserProfileComponent extends Component
{



    public $activeTab = 'currency';


    public function switchTab($tab)
    {
        $this->activeTab = $tab;
    }

    public function render()
    {
        return view('livewire.frontend.components.user-profile-component');
    }
}
