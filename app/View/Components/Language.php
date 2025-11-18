<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Services\LanguageService;
use Illuminate\Database\Eloquent\Collection;

class Language extends Component
{
    protected LanguageService $languageService;
    public string $locale;

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
        $this->locale = $this->languageService->findData(app()->getLocale(), 'locale')->locale ?? app()->getLocale() ?? 'en';
        return view('components.language');
    }
}
