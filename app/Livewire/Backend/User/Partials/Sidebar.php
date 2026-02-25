<?php

namespace App\Livewire\Backend\User\Partials;

use App\Services\CategoryService;
use Livewire\Component;

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
        $this->categories = $this->categoryService->getDatas(
            sortField: 'sort_order',
            order: 'asc',
            status: 'active'
        );

        return view('backend.user.layouts.partials.sidebar');
    }
}
