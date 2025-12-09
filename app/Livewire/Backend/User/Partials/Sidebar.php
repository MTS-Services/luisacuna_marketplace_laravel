<?php

namespace App\Livewire\Backend\User\Partials;

use Livewire\Component;
use App\Services\CategoryService;

class Sidebar extends Component
{
    public string $pageSlug;
    public string $breadcrumb;
    public $categories;

    protected CategoryService $categoryService;

    public function boot(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function mount(string $pageSlug = 'home', string $breadcrumb = '')
    {
        $this->pageSlug = $pageSlug;
        $this->breadcrumb = $breadcrumb;
    }

    public function render()
    {
        $this->categories = $this->categoryService->getDatas(status: "active");
        return view('backend.user.layouts.partials.sidebar');
    }
}
