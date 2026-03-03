<?php

namespace App\Livewire\Frontend;

use App\Models\Game;
use App\Models\Product;
use App\Services\GameService;
use App\Services\HeroService;
use Livewire\Component;

class Home extends Component
{
    public $categorySlug;

    public $gameSlug;

    protected GameService $gameService;

    protected HeroService $heroService;

    public function boot(GameService $gameService, HeroService $heroService)
    {
        $this->gameService = $gameService;
        $this->heroService = $heroService;
    }

    public function mount($gameSlug = null, $categorySlug = null)
    {
        $this->gameSlug = $gameSlug;
        $this->categorySlug = $categorySlug;
    }

    public function render()
    {
        $heros = $this->heroService->latestData(6);

        $popular_games = Game::query()
            ->active()
            ->whereHas('categories', fn($q) => $q->where('game_categories.is_popular', true))
            ->with([
                'categories',
                'gameTranslations' => fn($q) => $q->where('language_id', get_language_id()),
            ])
            ->limit(10)
            ->get();

        $new_bostings = $this->gameService->latestData(10, [
            'categorySlug' => 'boosting',
        ]);
        $new_bostings->load(['categories']);

        $topSelling = Product::query()
            ->where('is_top_selling', true)
            ->with(['game', 'category', 'platform', 'user.feedbacksReceived'])
            ->limit(10)
            ->get();

        return view('livewire.frontend.home', [
            'popular_games' => $popular_games,
            'heros' => $heros,
            'top_selling_products' => $topSelling,
            'new_bostings' => $new_bostings,
        ]);
    }
}
