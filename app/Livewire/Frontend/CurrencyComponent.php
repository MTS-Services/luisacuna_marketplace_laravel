<?php

namespace App\Livewire\Frontend;

use App\Models\Game;
use Livewire\Component;
use App\Services\CategoryService;
use App\Services\GameService;

class CurrencyComponent extends Component
{
    public $search = '';

    protected CategoryService $category_service;
    protected GameService $game_service;

    public function boot(CategoryService $category_service, GameService $game_service)
    {
        $this->category_service = $category_service;
        $this->game_service = $game_service;
    }
    public function render()
    {

        $pagination = [
            'total' => 100,
            'per_page' => 2,
            'current_page' => 1,
            'last_page' => 10,
            'from' => 1,
            'to' => 2,
        ];


        if (!empty($this->search)) {
            $allGames = $this->game_service->getGamesByCategory($this->search, 'slug', $this->search);
        }

        $allGames = $this->category_service->getGamesByCategory('currency');
        $games = $allGames;
        $popular_games = $allGames->filter(function ($game) {
            return $game->tags->contains('slug', 'popular');
        });



        return view('livewire.frontend.currency-component', [
            'pagination' => $pagination,
            'games' => $games,
            'popular_games' => $popular_games
        ]);
    }
}
