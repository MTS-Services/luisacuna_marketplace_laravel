<?php

namespace App\Livewire\Frontend;

use App\Services\GameService;
use Livewire\Component;


class TopUp extends Component
{
    protected GameService $game_service;

    public $search = '';
    public $sortOrder = 'default';
    public $perPage = 9;
    public $currentPage = 1;


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
            $allTopUps = $this->game_service->getGamesByCategory('topUp');
            $popular_topUps = $allTopUps->filter(fn($game) => $game->tags->contains('slug', 'popular'));
            $newly_topUps = $allTopUps->filter(fn($game) => $game->tags->contains('slug', 'newly'));

            $topUpsCollection = $this->game_service->searchGamesByCategory('topUp', $this->search);
        } else {
            $allTopUps = $this->game_service->getGamesByCategory('topUp');

            $topUpsCollection = $allTopUps;
            $popular_topUps = $allTopUps->filter(fn($game) => $game->tags->contains('slug', 'popular'));
            $newly_topUps = $allTopUps->filter(fn($game) => $game->tags->contains('slug', 'newly'));
        }
        // $topUps = $this->applySorting($topUps);

        // Sorting apply
        $topUpsCollection = $this->applySorting($topUpsCollection);

        // Pagination apply
        $topUps = $topUpsCollection->forPage($this->currentPage, $this->perPage);

        // Pagination data
        $pagination = $this->getPaginationData();


        return view('livewire.frontend.top-up', [
            'topUps' => $topUps,
            'popular_topUps' => $popular_topUps,
            'newly_topUps' => $newly_topUps,
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
            $allTopUps = $this->game_service->getGamesByCategory('topUp');
            $topUpsCollection = $this->game_service->searchGamesByCategory('topUp', $this->search);
        } else {
            $allTopUps = $this->game_service->getGamesByCategory('topUp');
            $topUpsCollection = $allTopUps;
        }

        $topUpsCollection = $this->applySorting($topUpsCollection);
        $total = $topUpsCollection->count();
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
