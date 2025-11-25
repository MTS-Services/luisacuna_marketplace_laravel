<?php

namespace App\Livewire\Backend\User\Profile;

use App\Models\User;
use Livewire\Component;

class ProfileComponent extends Component
{ 
   public $user;

    public function mount(User $user) {
        $this->user = $user;
    }

    public function render()
    {
        return view('livewire.backend.user.profile.profile-component');
    }
}
