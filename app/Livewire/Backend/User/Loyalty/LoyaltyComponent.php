<?php

namespace App\Livewire\Backend\User\Loyalty;

use Livewire\Component;
use App\Services\RankService;
use App\Services\UserService;

class LoyaltyComponent extends Component
{


    public $user = null;
    public $rank = null;
    public $achievements = [];
    public $currentRank = null;
    public $nextRank = null;
    public $pointsNeeded = 0;
    public $progress = 0;

    protected UserService $userService;
    protected RankService $rankService;

    public function boot(UserService $userService, RankService $rankService)
    {
        $this->userService = $userService;
        $this->rankService = $rankService;
    }
    public function mount()
    {
        $this->user = user()->load('userRank.rank.achievements', 'userPoint');
        $this->rank = $this->user?->userRank?->first()?->rank;
        $this->currentRank = $this->rank;
        $this->achievements = $this->rank?->achievements;

        // Next rank and points needed calculate 
        if ($this->currentRank) {
            $this->nextRank = $this->rankService->getNextRank($this->currentRank->id);
            $userPoints = $this->user->userPoint->points ?? 0;
            $this->pointsNeeded = $this->rankService->calculatePointsNeeded($userPoints, $this->nextRank);
        }

        // progress
        $userPoints = $this->user->userPoint->points ?? 0;
        $maxPoints = $this->currentRank?->maximum_points ?? 0;

        if ($maxPoints > 0) {
            $this->progress = ($userPoints / $maxPoints) * 100;
        } else {
            $this->progress = 0;
        }
    }
    public function render()
    {
        return view('livewire.backend.user.loyalty.loyalty-component');
    }
}
