<?php

namespace App\Livewire\Frontend\Partials;

use Livewire\Component;
use App\Models\Category;
use App\Services\GameService;
use App\Services\CategoryService;
use App\Services\CurrencyService;
use App\Services\LanguageService;
use App\Services\NotificationService;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\On;

class Header extends Component
{
    public string $pageSlug;
    public string $search = '';

    public int $unreadNotificationCount = 0;

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
    protected NotificationService $notificationService;

    public function boot(LanguageService $languageService, CategoryService $categoryService, GameService $game_service, CurrencyService $currencyService, NotificationService $notificationService)
    {
        $this->languageService = $languageService;
        $this->categoryService = $categoryService;
        $this->game_service = $game_service;
        $this->currencyService = $currencyService;
        if (auth()->guard('web')->check()) {
            $this->notificationService = $notificationService;
        }
    }

    public function mount(string $pageSlug = 'home')
    {
        $this->pageSlug = $pageSlug;
    }

    #[On('notification-created')]
    #[On('notification-updated')]
    #[On('notification-received')]
    #[On('notification-read')]
    public function refreshNotificationCount()
    {
        if (auth()->guard('web')->check()) {
            $this->unreadNotificationCount = $this->notificationService->getUnreadCount();
        }
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
                $this->allGamesCache = $this->game_service->getAllDatas([], $this->sortField = 'name',  $this->order = 'asc');
            }
        } else {
            if ($this->allGamesCache === null) {
                $this->allGamesCache = $this->game_service->getAllDatas([], $this->sortField = 'name',  $this->order = 'asc');
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
