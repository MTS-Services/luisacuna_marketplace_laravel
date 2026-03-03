<?php

namespace App\Livewire\Frontend\Partials;

use App\Services\CategoryService;
use App\Services\ConversationService;
use App\Services\CurrencyService;
use App\Services\GameService;
use App\Services\LanguageService;
use App\Services\NotificationService;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\On;
use Livewire\Component;

class Header extends Component
{
    public string $pageSlug;

    public string $search = '';

    public int $unreadNotificationCount = 0;

    public int $unreadMessageCount = 0;

    public $categories;

    public $sortField;

    public $order;

    public $currencies;

    public ?Collection $languages = null;

    protected GameService $game_service;

    protected CategoryService $categoryService;

    protected LanguageService $languageService;

    protected CurrencyService $currencyService;

    protected NotificationService $notificationService;

    protected ConversationService $conversationService;

    public function boot(LanguageService $languageService, CategoryService $categoryService, GameService $game_service, CurrencyService $currencyService, NotificationService $notificationService, ConversationService $conversationService)
    {
        $this->languageService = $languageService;
        $this->categoryService = $categoryService;
        $this->game_service = $game_service;
        $this->currencyService = $currencyService;

        if (auth()->guard('web')->check()) {
            $this->notificationService = $notificationService;
            $this->conversationService = $conversationService;
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

    #[On('message-created')]
    #[On('message-updated')]
    #[On('message-received')]
    #[On('message-read')]
    public function refreshMessageCount()
    {
        if (auth()->guard('web')->check()) {
            $this->unreadMessageCount = $this->conversationService->getUnreadCount();
        }
    }

    public $popular_games = [];

    public function openGlobalSearch()
    {
        $this->popular_games = collect();

        if (empty($this->search)) {
            $this->popular_games = \App\Models\Game::query()
                ->active()
                ->whereHas('categories', fn($q) => $q->where('game_categories.is_popular', true))
                ->with(['gameTranslations' => fn($q) => $q->where('language_id', get_language_id())])
                ->orderBy('name', 'asc')
                ->limit(12)
                ->get();
        }
    }

    public function render()
    {
        // $categories= Category::where('status','active')->get();
        $this->languages = $this->languageService->getAllDatas();
        $this->categories = $this->categoryService->getDatas(
            sortField: 'sort_order',
            order: 'asc',
            status: 'active'
        );
        $this->currencies = $this->currencyService->getAllDatas();

        $search_results = collect();

        if (! empty($this->search)) {
            $search_results = $this->game_service->searchData($this->search);
        }

        return view('livewire.frontend.partials.header', [
            'search_results' => $search_results,
        ]);
    }
}
