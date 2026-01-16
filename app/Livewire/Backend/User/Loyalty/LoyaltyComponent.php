<?php

namespace App\Livewire\Backend\User\Loyalty;

use App\Services\AchievementService;
use Livewire\Component;
use App\Services\RankService;
use App\Services\UserAchievementProgressService;
use App\Services\UserService;
use App\Traits\Livewire\WithNotification;

class LoyaltyComponent extends Component
{

    use WithNotification;

    public $user = null;
    public $rank = null;
    // public $achievements;
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
    protected AchievementService $achievementsService;
    protected UserAchievementProgressService $userAchievementProgressService;

    public function boot(UserService $userService, RankService $rankService, AchievementService $achievementsService, UserAchievementProgressService $userAchievementProgressService)
    {
        $this->userService = $userService;
        $this->rankService = $rankService;
        $this->achievementsService = $achievementsService;
        $this->userAchievementProgressService = $userAchievementProgressService;
    }
    public function mount()
    {
        $this->user = user()->load('userPoint');

        $userPoints = $this->user->userPoint->points ?? 0;
        $this->availablePoints = $userPoints;
        $this->canRedeem = $userPoints >= 10000;

        $this->currentRank = $this->rankService->getUserRank();
        $this->completedAchievements = $this->userAchievementProgressService->completedAcheievment()->count();
    }
    public function render()
    {
        $achievements = $this->achievementsService->getPaginatedData(15, [
            'sort_field' => 'target_value',
            'sort_direction' => 'asc'
        ]);
        $achievements->load(['achievementType','progress']);
        return view('livewire.backend.user.loyalty.loyalty-component',
            [
                'achievements' => $achievements
            ]);
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

        $this->success(__('Points redeemed successfully'));

        return redirect()->route('user.loyalty');
    }
}
