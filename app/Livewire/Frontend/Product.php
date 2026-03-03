<?php

namespace App\Livewire\Frontend;

use App\Enums\GameStatus;
use App\Models\Game;
use App\Services\CategoryService;
use App\Services\GameService;
use App\Traits\WithPaginationData;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Url;
use Livewire\Component;

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

    protected CategoryService $categoryService;

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

        $popular_games = Game::query()
            ->active()
            ->whereHas(
                'categories',
                fn($q) => $q
                    ->where('categories.slug', $this->categorySlug)
                    ->where('game_categories.is_popular', true)
            )
            ->with([
                'categories',
                'gameTranslations' => fn($q) => $q->where('language_id', get_language_id()),
            ])
            ->when($category, fn($q) => $q->withCount([
                'products' => fn($q) => $q->where('category_id', $category->id),
            ]))
            ->orderBy('name', 'asc')
            ->limit(10)
            ->get();

        if ($this->categorySlug == 'boosting' || $this->categorySlug == 'coaching' || $this->categorySlug == 'top-up') {
            $new_boosting = $this->game_service->latestData(10, [
                'categorySlug' => $this->categorySlug,
                'relations' => ['tags', 'categories'],
                'withProductCount' => true,
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

        if ($this->sortOrder == 'all') {
            $this->resetFilters();
        }

        try {
            $params = [
                'categorySlug' => $this->categorySlug,
                'relations' => ['tags', 'categories'],
                'withProductCount' => true,
                'hasProduct' => true,
                'search' => $this->search,
                'status' => GameStatus::ACTIVE,
            ];
            if ($this->sortOrder) {
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
