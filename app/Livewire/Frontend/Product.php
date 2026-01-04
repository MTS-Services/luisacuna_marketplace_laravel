<?php

namespace App\Livewire\Frontend;

use App\Services\CategoryService;
use Livewire\Component;
use App\Services\GameService;
use App\Traits\WithPaginationData;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Url;

class Product extends Component
{
    use WithPaginationData;
    // Public properties
    public $categorySlug = null;
    #[Url()]
    public $search = '';
    #[Url()]
    public $sortOrder = '';


    // Protected properties
    protected GameService $game_service;
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
    public function render()
    {

        $games = $this->getGames();

       
        $category = $this->categoryService->findData($this->categorySlug, 'slug');

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

        if($this->sortOrder == 'all') $this->resetFilters(); 

        try {
            $params = [
                'category' => $this->categorySlug,
                'relations' => ['tags', 'categories'],
                'withProductCount' => true,
                'search' => $this->search,
            ];
            if($this->sortOrder){
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

    public function resetFilters()
    {
        $this->search = '';
        $this->sortOrder = '';
    }
}
