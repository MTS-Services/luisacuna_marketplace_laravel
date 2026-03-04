<?php

namespace App\Livewire\Backend\Admin\Partials;

use App\Services\LanguageService;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class Lang extends Component
{
    protected LanguageService $languageService;

    public function boot(LanguageService $languageService): void
    {
        $this->languageService = $languageService;
    }

    public function getLanguagesProperty(): Collection
    {
        return $this->languageService->getActiveData();
    }

    public function getSelectedLangLocaleProperty(): string
    {
        return Session::get('locale', config('app.locale', 'en'));
    }

    public function switchLocale(string $locale): mixed
    {
        $validLocales = $this->languages->pluck('locale')->toArray();
        if (! in_array($locale, $validLocales)) {
            return null;
        }

        Session::put('locale', $locale);
        App::setLocale($locale);

        return $this->redirect(request()->header('Referer', route('admin.dashboard')), navigate: true);
    }

    public function render(): View
    {
        return view('livewire.backend.admin.partials.lang');
    }
}
