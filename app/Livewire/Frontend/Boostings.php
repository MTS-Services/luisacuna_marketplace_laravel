<?php

namespace App\Livewire\Frontend;

use App\Services\GameService;
use Livewire\Component;

class Boostings extends Component
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
            $allBoostings = $this->game_service->getGamesByCategory('boosting');
            $popular_boostings = $allBoostings->filter(fn($game) => $game->tags->contains('slug', 'popular'));
            $newly_boostings = $allBoostings->filter(fn($game) => $game->tags->contains('slug', 'newly'));

            $boostings = $this->game_service->searchGamesByCategory('boosting', $this->search);
        } else {
            $allBoostings = $this->game_service->getGamesByCategory('boosting');

            $boostings = $allBoostings;
            $popular_boostings = $allBoostings->filter(fn($game) => $game->tags->contains('slug', 'popular'));
            $newly_boostings = $allBoostings->filter(fn($game) => $game->tags->contains('slug', 'newly'));
        }

        $boostings = $this->applySorting($boostings);
        // Pagination apply
        $boostings = $boostings->forPage($this->currentPage, $this->perPage);

        // Pagination data
        $pagination = $this->getPaginationData();


        return view('livewire.frontend.boostings', [
            'boostings' => $boostings,
            'popular_boostings' => $popular_boostings,
            'newly_boostings' => $newly_boostings,
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
            $allBoostings = $this->game_service->getGamesByCategory('boosting');
            $boostingsCollection = $this->game_service->searchGamesByCategory('boosting', $this->search);
        } else {
            $allBoostings = $this->game_service->getGamesByCategory('boosting');
            $boostingsCollection = $allBoostings;
        }

        $boostingsCollection = $this->applySorting($boostingsCollection);
        $total = $boostingsCollection->count();
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
