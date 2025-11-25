<?php

namespace App\Livewire\Backend\User\Profile\ShopCategories;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Livewire\Attributes\Url;
use Livewire\Component;

class Shop extends Component
{

    #[Url(keep: true)]
    public $activeTab = 'currency';
    public $user;

    public function mount(User $user)
    {
        $this->user = $user;
    }
    public function render()
    {
        return view('livewire.backend.user.profile.shop-categories.shop');
    }
}
