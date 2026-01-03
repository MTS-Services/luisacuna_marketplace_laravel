<?php

namespace App\Livewire\Frontend;

use App\Services\CategoryService;
use Livewire\Component;
use App\Services\GameService;
use App\Traits\WithPaginationData;
use Illuminate\Support\Facades\Log;

class Product extends Component
{
    use WithPaginationData;
    // Public properties
    public $categorySlug = null;
    public $search = '';
    public $sortOrder = 'default';


    // Protected properties
    protected GameService $game_service;
    protected $allGamesCache = null;
    protected  CategoryService $categoryService;
    public function boot(GameService $game_service, CategoryService $categoryService)
    {
        $this->game_service = $game_service;
        $this->categoryService = $categoryService;
    }
    public function mount($categorySlug)
    {
        $this->categorySlug = $categorySlug;
    }
    public function sortBy($order)
    {
        $this->sortOrder = $order;
    }
    public function render()
    {
        $games = $this->getGames();

        $category = $this->categoryService->findData($this->categorySlug, 'slug');
        // dd($games);

        $this->paginationData($games);

        $popular_games = $this->game_service->latestData(10, [
            'category' => $this->categorySlug,
            'tag' => 'popular',
            'relations' => ['tags', 'categories'],
            'sort_field' => 'name',
            'sort_direction' => 'asc',
            'withProductCount' => true
        ]);





        if ($this->categorySlug == 'boosting' || $this->categorySlug == 'coaching' || $this->categorySlug == 'top-up') {
            $new_boosting = $this->game_service->latestData(10, [
                'category' => $this->categorySlug,
                'relations' => ['tags', 'categories',],
                'withProductCount' => true
            ]);
        }

        return view('livewire.frontend.product', [
            'games' => $games ?? collect([]),
            'popular_games' => $popular_games ?? collect([]),
            'categorySlug' => $this->categorySlug,
            // Only need in boosting page
            'new_boosting' => $new_boosting ?? collect([]),
            'category' => $category,
        ]);
    }


    protected function getGames()
    {


        try {
            $params = [
                'category' => $this->categorySlug,
                'relations' => ['tags', 'categories'],
                'withProductCount' => true,
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

    public function resetFilters()
    {
        $this->search = '';
        $this->sortOrder = 'default';
    }
}
