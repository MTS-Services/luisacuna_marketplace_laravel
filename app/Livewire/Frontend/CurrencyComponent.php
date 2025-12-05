<?php

namespace App\Livewire\Frontend;

use Livewire\Component;
use App\Services\GameService;

class CurrencyComponent extends Component
{
    public $search = '';
    public $sortOrder = 'default';
    public $perPage = 9;
    public $currentPage = 1;

    protected GameService $game_service;
    protected $allGamesCache = null;

    public function boot(GameService $game_service)
    {
        $this->game_service = $game_service;
    }

    public function sortBy($order)
    {
        $this->sortOrder = $order;
    }

    public function render()
    {
       
        if ($this->allGamesCache === null) {
            $this->allGamesCache = $this->game_service->getGamesByCategory('currency');
        }

        // Search logic
        if (!empty($this->search)) {
            $games = $this->game_service->searchGamesByCategory('currency', $this->search);
        } else {
            $games = $this->allGamesCache;
        }

        // Popular games 
        $popular_games = $this->allGamesCache->filter(function ($game) {
            return $game->tags->contains('slug', 'popular');
        });

        // Sorting apply
        $games = $this->applySorting($games);

        // Pagination data 
        $pagination = $this->getPaginationData($games);

        // Pagination apply
        $games = $games->forPage($this->currentPage, $this->perPage);

        return view('livewire.frontend.currency-component', [
            'pagination' => $pagination,
            'games' => $games,
            'popular_games' => $popular_games
        ]);
    }

    protected function applySorting($collection)
    {
        if ($this->sortOrder === 'asc') {
            return $collection->sortBy('name')->values();
        } elseif ($this->sortOrder === 'desc') {
            return $collection->sortByDesc('name')->values();
        }

        return $collection;
    }

    public function gotoPage($page)
    {
        $this->currentPage = $page;
    }

    public function previousPage()
    {
        if ($this->currentPage > 1) {
            $this->currentPage--;
        }
    }

    public function nextPage()
    {
       
        if ($this->allGamesCache === null) {
            $this->allGamesCache = $this->game_service->getGamesByCategory('currency');
        }

        
        $gamesCollection = !empty($this->search) 
            ? $this->game_service->searchGamesByCategory('currency', $this->search)
            : $this->allGamesCache;

        $pagination = $this->getPaginationData($gamesCollection);
        
        if ($this->currentPage < $pagination['last_page']) {
            $this->currentPage++;
        }
    }

    protected function getPaginationData($gamesCollection)
    {
        // Null check
        if ($gamesCollection === null || $gamesCollection->isEmpty()) {
            return [
                'total' => 0,
                'per_page' => $this->perPage,
                'current_page' => $this->currentPage,
                'last_page' => 1,
                'from' => 0,
                'to' => 0,
            ];
        }

        $gamesCollection = $this->applySorting($gamesCollection);
        $total = $gamesCollection->count();
        $lastPage = (int) ceil($total / $this->perPage);

        return [
            'total' => $total,
            'per_page' => $this->perPage,
            'current_page' => $this->currentPage,
            'last_page' => $lastPage,
            'from' => (($this->currentPage - 1) * $this->perPage) + 1,
            'to' => min($this->currentPage * $this->perPage, $total),
        ];
    }
}