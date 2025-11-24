<?php

namespace App\Livewire\Frontend;

use App\Services\GameService;
use Livewire\Component;

class CurrencyComponent extends Component
{
    protected GameService $gameService;

    public function boot(GameService $gameService)
    {
        $this->gameService = $gameService;
    }
    public function render()
    {

        $pagination = [
            'total' => 100,
            'per_page' => 10,
            'current_page' => 1,
            'last_page' => 11,
            'from' => 1,
            'to' => 2,
        ];


        $allGames = $this->gameService->getAllDatas();

        $games = $allGames->filter(function ($game) {
            return !empty($game->currency) || isset($game->currency);
        });



        return view('livewire.frontend.currency-component', [
            'pagination' => $pagination,
            'games' => $games
        ]);
    }
}
