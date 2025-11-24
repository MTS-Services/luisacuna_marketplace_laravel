<?php

namespace App\Livewire\Frontend;

use App\Models\Game;
use Livewire\Component;
use App\Services\CategoryService;

class CurrencyComponent extends Component
{
    protected CategoryService $category_service;

    public function boot(CategoryService $category_service)
    {
        $this->category_service = $category_service;
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

        
        // $games = $this->category_service->getGamesByCategory('currency');
        // $popular_games = $this->category_service->getGamesByCategoryAndTag('currency', 'popular');

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
