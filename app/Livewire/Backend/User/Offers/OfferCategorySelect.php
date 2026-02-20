<?php

namespace App\Livewire\Backend\User\Offers;

use App\Services\CategoryService;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class OfferCategorySelect extends Component
{
    protected CategoryService $categoryService;

    public function boot(CategoryService $categoryService): void
    {
        $this->categoryService = $categoryService;
    }

    public function render(): View
    {
        return view('livewire.backend.user.offers.offer-category-select', [
            'categories' => $this->categoryService->getDatas(),
        ]);
    }
}
