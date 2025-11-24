<?php

namespace App\Livewire\Backend\User\Profile\ShopCategories;

use Livewire\Component;

class Shop extends Component
{
    public $activeTab = 'currency';
    public function switchTab($tab)
    {
        $this->activeTab = $tab;
    }

    public function render()
    {

        return view('livewire.backend.user.profile.shop-categories.shop');
    }
}
