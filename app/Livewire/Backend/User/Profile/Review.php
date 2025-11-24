<?php

namespace App\Livewire\Backend\User\Profile;

use Livewire\Component;

class Review extends Component
{
    public $reviewItem = 'all';
    public function switchReviewItem($item)
    {
        $this->reviewItem = $item;
    }
    public function render()
    {
        return view('livewire.backend.user.profile.review');
    }
}
