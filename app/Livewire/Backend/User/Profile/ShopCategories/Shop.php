<?php

namespace App\Livewire\Backend\User\Profile\ShopCategories;

use Livewire\Attributes\Url;
use Livewire\Component;

class Shop extends Component
{

    #[Url(keep: true)]
    public $activeTab = 'currency';

    public function render()
    {

        return view('livewire.backend.user.profile.shop-categories.shop');
    }
}
