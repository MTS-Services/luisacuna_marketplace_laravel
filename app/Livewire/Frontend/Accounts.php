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

        if (!empty($this->search)) {
            $accounts = $this->game_service->searchGamesByCategory('accounts', $this->search);

            if ($this->allGamesCache === null) {
                $this->allGamesCache = $this->game_service->getGamesByCategory('accounts');
            }

            $popular_accounts = $this->allGamesCache->filter(function ($game) {
                return $game->tags->contains('slug', 'popular');
            });
        } else {
            if ($this->allGamesCache === null) {
                $this->allGamesCache = $this->game_service->getGamesByCategory('accounts');
            }

            $accounts = $this->allGamesCache;
            $popular_accounts = $this->allGamesCache->filter(function ($game) {
                return $game->tags->contains('slug', 'popular');
            });
        }

        $accounts = $this->applySorting($accounts);
        $accounts = $accounts->forPage($this->currentPage, $this->perPage);
        // Pagination data
        $pagination = $this->getPaginationData();

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
        $pagination = $this->getPaginationData();
        if ($this->currentPage < $pagination['last_page']) {
            $this->currentPage++;
        }
    }

    protected function getPaginationData()
    {
        if (!empty($this->search)) {
            $allAccounts = $this->game_service->getGamesByCategory('accounts');
            $accountsCollection = $this->game_service->searchGamesByCategory('accounts', $this->search);
        } else {
            $allAccounts = $this->game_service->getGamesByCategory('accounts');
            $accountsCollection = $allAccounts;
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
