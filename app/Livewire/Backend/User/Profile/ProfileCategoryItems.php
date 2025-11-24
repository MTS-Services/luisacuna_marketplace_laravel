<?php

namespace App\Livewire\Backend\User\Profile;

use App\Services\GameService;
use Livewire\Component;
use Livewire\Attributes\Url;

class ProfileCategoryItems extends Component
{
     #[Url(keep: true)]
    public $activeTab = 'currency';

     protected GameService $gameService;
    public function boot(GameService $gameService)
    {
        $this->gameService = $gameService;
    }
    public function render()
    {   $games = $this->gameService->getAllDatas();
        return view('livewire.backend.user.profile.profile-category-items', [
            'games' => $games,
        ]);
    }
}
