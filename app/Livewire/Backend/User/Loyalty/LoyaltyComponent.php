<?php

namespace App\Livewire\Backend\User\Loyalty;

use Livewire\Component;
use App\Services\RankService;
use App\Services\UserService;
use App\Traits\Livewire\WithNotification;

class LoyaltyComponent extends Component
{

    use WithNotification;

    public $user = null;
    public $rank = null;
    public $achievements;
    public $currentRank = null;
    public $nextRank = null;
    public $pointsNeeded = 0;
    public $progress = 0;

    public $canRedeem = false;
    public $availablePoints = 0;
    public $completedAchievements = 0;
    public $totalAchievements = 0;

    protected UserService $userService;
    protected RankService $rankService;

    public function boot(UserService $userService, RankService $rankService)
    {
        $this->userService = $userService;
        $this->rankService = $rankService;
    }
    public function mount()
    {
        $this->user = user()->load('userPoint');

        $userPoints = $this->user->userPoint->points ?? 0;
        $this->availablePoints = $userPoints;
        $this->canRedeem = $userPoints >= 10000;

        $this->currentRank = $this->rankService->getUserRank();
        $this->achievements = $this->rankService->getUserAchievements();

        // dd($this->currentRank, $this->achievements);
    }
    public function render()
    {
        return view('livewire.backend.user.loyalty.loyalty-component');
    }

    public function redeemPoints()
    {
        $user = user()->load('userPoint');

        $redeemed = $this->rankService->redeemUserPoints($user);

        if (!$redeemed) {
            session()->flash('error', 'You do not have enough points to redeem.');
            return;
        }

        $this->availablePoints = $user->userPoint->points;
        $this->canRedeem = $this->availablePoints >= 10000;

        $this->success('Points redeemed successfully');

        return redirect()->route('user.loyalty');
    }
}
