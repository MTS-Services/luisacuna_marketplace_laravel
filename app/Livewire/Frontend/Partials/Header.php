<?php

namespace App\Livewire\Frontend\Partials;

use App\Services\LanguageService;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class Header extends Component
{
    public string $pageSlug;

    public ?Collection $languages = null;

    protected LanguageService $languageService;

    public function boot(LanguageService $languageService)
    {
        $this->languageService = $languageService;
    }

    public function mount(string $pageSlug = 'home')
    {
        $this->pageSlug = $pageSlug;
    }

    public function render()
    {
        $this->languages = $this->languageService->getAllDatas();

        return view('livewire.frontend.partials.header');
    }
}
