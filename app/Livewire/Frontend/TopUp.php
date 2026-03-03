<?php

namespace App\Livewire\Frontend;

use App\Models\Game;
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
            $newly_topUps = $allTopUps->filter(fn($game) => $game->tags->contains('slug', 'newly'));

            $topUpsCollection = $this->game_service->searchGamesByCategory('topUp', $this->search);
        } else {
            $allTopUps = $this->game_service->getGamesByCategory('topUp');

            $topUpsCollection = $allTopUps;
            $newly_topUps = $allTopUps->filter(fn($game) => $game->tags->contains('slug', 'newly'));
        }

        $popular_topUps = Game::query()
            ->active()
            ->whereHas(
                'categories',
                fn($q) => $q
                    ->where('categories.slug', 'top-up')
                    ->where('game_categories.is_popular', true)
            )
            ->with(['categories', 'gameTranslations' => fn($q) => $q->where('language_id', get_language_id())])
            ->orderBy('name', 'asc')
            ->limit(10)
            ->get();
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
