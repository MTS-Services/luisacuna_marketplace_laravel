<?php

namespace App\Livewire\Frontend\Partials;

use Livewire\Component;
use App\Models\Category;
use App\Services\GameService;
use App\Services\CategoryService;
use App\Services\CurrencyService;
use App\Services\LanguageService;
use Illuminate\Database\Eloquent\Collection;

class Header extends Component
{
    public string $pageSlug;
    public string $search = '';

    public $categories;
    public $sortField;
    public $order;
    public $currencies;

    public ?Collection $languages = null;
    protected GameService $game_service;
    protected $popularGamesCache  = null;
    protected $allGamesCache = null;
    protected CategoryService $categoryService;
    protected LanguageService $languageService;
    protected CurrencyService $currencyService;

    public function boot(LanguageService $languageService, CategoryService $categoryService, GameService $game_service, CurrencyService $currencyService)
    {
        $this->languageService = $languageService;
        $this->categoryService = $categoryService;
        $this->game_service = $game_service;
        $this->currencyService = $currencyService;
    }

    public function mount(string $pageSlug = 'home')
    {
        $this->pageSlug = $pageSlug;
    }

    public function render()
    {
        // $categories= Category::where('status','active')->get();
        $this->languages = $this->languageService->getAllDatas();
        $this->categories = $this->categoryService->getDatas(status: "active");
        $this->currencies = $this->currencyService->getAllDatas();

        // dd($this->currencies);

        $popular_games = collect();
        $search_results = collect();

        if (!empty($this->search)) {
            $search_results = $this->game_service->searchData($this->search);

            if ($this->allGamesCache === null) {
                $this->allGamesCache = $this->game_service->getAllDatas([],$this->sortField = 'name',  $this->order = 'asc');
            }
        } else {
            if ($this->allGamesCache === null) {
                $this->allGamesCache = $this->game_service->getAllDatas([],$this->sortField = 'name',  $this->order = 'asc');
            }
            $popular_games = $this->allGamesCache->filter(function ($game) {
                return $game->tags->contains('slug', 'popular');
            });
        }


        return view('livewire.frontend.partials.header', [
            'popular_games' => $popular_games,
            'search_results' => $search_results,
        ]);
    }
}
