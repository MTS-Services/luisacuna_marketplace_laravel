<?php

namespace App\Livewire\Frontend;

use Livewire\Component;
use App\Services\GameService;
use Illuminate\Support\Facades\Log;

class Product extends Component
{
    // Public properties
    public $categorySlug = null;

    public $search = '';
    public $sortOrder = 'default';
    public $perPage = 9;
    public $currentPage = 1;

    // Protected properties
    protected GameService $game_service;
    protected $allGamesCache = null;

    /**
     * Boot method - Dependency injection
     */
    public function boot(GameService $game_service)
    {
        $this->game_service = $game_service;
    }

    /**
     * Mount method - Component initialization
     */
    public function mount($categorySlug)
    {
        $this->categorySlug = $categorySlug;
    }

    /**
     * Sort by method
     */
    public function sortBy($order)
    {
        $this->sortOrder = $order;
        $this->currentPage = 1;
    }

    /**
     * Render method - Main view rendering
     */
    public function render()
    {
        $games = $this->getGames();
        
        $popular_games = $this->game_service->getAllDatas([
            'category' => $this->categorySlug,
            'tag' => 'popular',
            'relations' => ['tags', 'categories']
        ]);

        // $pagination = $this->getPaginationData($games);

        return view('livewire.frontend.product', [
            'games' => $games ?? collect([]),
            'popular_games' => $popular_games ?? collect([]),
            'categorySlug' => $this->categorySlug,
            // 'pagination' => $pagination,
        ]);
    }

    /**
     * Get games with all filters applied
     */
    protected function getGames()
    {
        try {
            // Base parameters
            $params = [
                'category' => $this->categorySlug,
                'relations' => ['tags', 'categories'],
                'page' => $this->currentPage,
            ];

            if (!empty($this->search)) {
                $params['search'] = $this->search;
            }

            if ($this->sortOrder !== 'default') {
                $params['sort_field'] = 'name';
                $params['sort_direction'] = $this->sortOrder;
            }

            $games = $this->game_service->paginateDatas($this->perPage, $params);

            return $games;

        } catch (\Exception $e) {
            Log::error('Error fetching games: ' . $e->getMessage());
            return collect([]);
        }
    }

    /**
     * Apply sorting to collection
     */
    protected function applySorting($collection)
    {
        if ($collection === null || $collection->isEmpty()) {
            return collect([]);
        }

        if ($this->sortOrder === 'asc') {
            return $collection->sortBy('name')->values();
        } elseif ($this->sortOrder === 'desc') {
            return $collection->sortByDesc('name')->values();
        }

        return $collection;
    }



    /**
     * Reset filters
     */
    public function resetFilters()
    {
        $this->search = '';
        $this->sortOrder = 'default';
        $this->currentPage = 1;
    }
}