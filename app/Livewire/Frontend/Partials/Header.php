<?php

namespace App\Livewire\Frontend\Partials;

use App\Models\Category;
use App\Services\CategoryService;
use App\Services\LanguageService;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class Header extends Component
{
    public string $pageSlug;

    public $categories;

    public ?Collection $languages = null;
    protected CategoryService $categoryService;
    protected LanguageService $languageService;

    public function boot(LanguageService $languageService, CategoryService $categoryService)
    {
        $this->languageService = $languageService;
        $this->categoryService = $categoryService;
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
        return view('livewire.frontend.partials.header');
    }
}
