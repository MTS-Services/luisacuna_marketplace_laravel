<?php

namespace App\Livewire\Backend\User\Loyalty;

use App\Services\UserService;
use Livewire\Component;

class LoyaltyComponent extends Component
{
    public $user = null;
    public $rank = null;
    public $achievements = [];

    protected UserService $userService;

    public function boot(UserService $userService)
    {
        $this->userService = $userService;
    }
    public function mount()
    {
        $this->user = user()->load('userRank.rank.achievements');
        $this->rank = $this->user?->userRank?->first()->rank;
        $this->achievements = $this->rank?->achievements;
    }
    public function render()
    {
        return view('livewire.backend.user.loyalty.loyalty-component');
    }
}
