<?php

namespace App\Livewire\Frontend\Partials;

use App\Services\CategoryService;
use Livewire\Component;

class Sidebar extends Component
{
    public $categories;

    protected CategoryService $categoryService;

    public function boot(CategoryService $categoryService): void
    {
        $this->categoryService = $categoryService;
    }

    public function render()
    {
        $this->categories = $this->categoryService->getDatas(
            sortField: 'sort_order',
            order: 'asc',
            status: 'active'
        );

        return view('livewire.frontend.partials.sidebar');
    }
}
