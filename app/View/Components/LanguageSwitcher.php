<?php

namespace App\View\Components;

use App\Services\LanguageService;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\Component;

class LanguageSwitcher extends Component
{
    public ?Collection $languages = null;

    protected LanguageService $languageService;

    /**
     * Create a new component instance.
     */
    public function __construct(LanguageService $languageService)
    {
        $this->languageService = $languageService;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $this->languages = $this->languageService->getActiveData();
        return view('components.language-switcher');
    }
}
