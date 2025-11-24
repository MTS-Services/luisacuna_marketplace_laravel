<?php

namespace App\Livewire\Backend\User\Profile;

use Livewire\Component;
use Livewire\Attributes\Url;

class ProfileCategoryItems extends Component
{
     #[Url(keep: true)]
    public $activeTab = 'currency';
    public function render()
    {
        return view('livewire.backend.user.profile.profile-category-items');
    }
}
