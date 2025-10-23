<?php

namespace App\Livewire\Backend\Admin\Components\Language;

use Livewire\Component;
use App\Services\Language\LanguageService;

class Index extends Component
{
    protected $languageService;
    public function boot(LanguageService $languageService)
    {
        $this->languageService = $languageService;
    }
    public function render()
    {
        return view('livewire.backend.admin.components.language.index');
    }
}
