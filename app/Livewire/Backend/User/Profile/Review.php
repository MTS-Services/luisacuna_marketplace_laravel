<?php

namespace App\Livewire\Backend\User\Profile;

use App\Models\User;
use Livewire\Component;

class Review extends Component
{
     public $user;
    public $reviewItem = 'all';
       public function mount(User $user)
    {
        $this->user = $user;
    }
    public function switchReviewItem($item)
    {
        $this->reviewItem = $item;
    }
    public function render()
    {
        return view('livewire.backend.user.profile.review');
    }
}
