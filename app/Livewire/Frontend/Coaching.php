<?php

namespace App\Livewire\Frontend;

use App\Services\GameService;
use Livewire\Component;


class Coaching extends Component
{
    public $search = '';
    public $sortOrder = 'default';
    public $perPage = 9;
    public $currentPage = 1;


    protected GameService $game_service;


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
            $allCoachings = $this->game_service->getGamesByCategory('coaching');
            $popular_coachings = $allCoachings->filter(fn($game) => $game->tags->contains('slug', 'popular'));
            $newly_coachings = $allCoachings->filter(fn($game) => $game->tags->contains('slug', 'newly'));

            $coachings = $this->game_service->searchGamesByCategory('coaching', $this->search);
        } else {
            $allCoachings = $this->game_service->getGamesByCategory('coaching');

            $coachings = $allCoachings;
            $popular_coachings = $allCoachings->filter(fn($game) => $game->tags->contains('slug', 'popular'));
            $newly_coachings = $allCoachings->filter(fn($game) => $game->tags->contains('slug', 'newly'));
        }

        $coachings = $this->applySorting($coachings);
        // Pagination apply
        $coachings = $coachings->forPage($this->currentPage, $this->perPage);

        // Pagination data
        $pagination = $this->getPaginationData();


        return view('livewire.frontend.coaching', [
            'coachings' => $coachings,
            'popular_coachings' => $popular_coachings,
            'newly_coachings' => $newly_coachings,
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
            $allCoachings = $this->game_service->getGamesByCategory('coaching');
            $coachingsCollection = $this->game_service->searchGamesByCategory('coaching', $this->search);
        } else {
            $allCoachings = $this->game_service->getGamesByCategory('coaching');
            $coachingsCollection = $allCoachings;
        }

        $coachingsCollection = $this->applySorting($coachingsCollection);
        $total = $coachingsCollection->count();
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
