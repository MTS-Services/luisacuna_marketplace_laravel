<?php

namespace App\Livewire\Frontend;

use App\Services\GameService;
use Livewire\Component;

class Items extends Component
{

    public $activeTab = 'giftCard';
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
    public function switchTab($tab)
    {
        $this->activeTab = $tab;
    }
    public function sortBy($order)
    {
        $this->sortOrder = $order;
    }

    public function render()
    {

        // $items = $this->game_service->getGamesByCategory('items');
        // $popular_items = $this->game_service->getGamesByCategoryAndTag('items', 'popular');

        if (!empty($this->search)) {
            $items = $this->game_service->searchGamesByCategory('items', $this->search);

            if ($this->allGamesCache === null) {
                $this->allGamesCache = $this->game_service->getGamesByCategory('items');
            }

            $popular_items = $this->allGamesCache->filter(function ($game) {
                return $game->tags->contains('slug', 'popular');
            });
        } else {
            if ($this->allGamesCache === null) {
                $this->allGamesCache = $this->game_service->getGamesByCategory('items');
            }

            $items = $this->allGamesCache;
            $popular_items = $this->allGamesCache->filter(function ($game) {
                return $game->tags->contains('slug', 'popular');
            });
        }

        $items = $this->applySorting($items);

        // Pagination apply
        $items = $items->forPage($this->currentPage, $this->perPage);

        // Pagination data
        $pagination = $this->getPaginationData();


        return view('livewire.frontend.items', [
            'items' => $items,
            'popular_items' => $popular_items,
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
            $allItems = $this->game_service->getGamesByCategory('items');
            $itemsCollection = $this->game_service->searchGamesByCategory('items', $this->search);
        } else {
            $allItems = $this->game_service->getGamesByCategory('items');
            $itemsCollection = $allItems;
        }

        $itemsCollection = $this->applySorting($itemsCollection);
        $total = $itemsCollection->count();
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
