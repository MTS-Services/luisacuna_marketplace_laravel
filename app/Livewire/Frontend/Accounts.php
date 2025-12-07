<?php

namespace App\Livewire\Frontend;

use App\Services\GameService;
use Livewire\Component;


class Accounts extends Component
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
            $this->allGamesCache = $this->game_service->getGamesByCategory('accounts');
        }

        if (!empty($this->search)) {
            $accounts = $this->game_service->searchGamesByCategory('accounts', $this->search);
        } else {
            $accounts = $this->allGamesCache;
        }

        $popular_accounts = $this->allGamesCache->filter(function ($game) {
            return $game->tags->contains('slug', 'popular');
        });

        $accounts = $this->applySorting($accounts);
        
        $pagination = $this->getPaginationData($accounts);
        
        $accounts = $accounts->forPage($this->currentPage, $this->perPage);

        return view('livewire.frontend.accounts', [
            'accounts' => $accounts,
            'popular_accounts' => $popular_accounts,
            'pagination' => $pagination
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
            $this->allGamesCache = $this->game_service->getGamesByCategory('accounts');
        }

        $accountsCollection = !empty($this->search) 
            ? $this->game_service->searchGamesByCategory('accounts', $this->search)
            : $this->allGamesCache;

        $pagination = $this->getPaginationData($accountsCollection);
        
        if ($this->currentPage < $pagination['last_page']) {
            $this->currentPage++;
        }
    }

    protected function getPaginationData($accountsCollection)
    {
        if ($accountsCollection === null || $accountsCollection->isEmpty()) {
            return [
                'total' => 0,
                'per_page' => $this->perPage,
                'current_page' => $this->currentPage,
                'last_page' => 1,
                'from' => 0,
                'to' => 0,
            ];
        }

        $accountsCollection = $this->applySorting($accountsCollection);
        $total = $accountsCollection->count();
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