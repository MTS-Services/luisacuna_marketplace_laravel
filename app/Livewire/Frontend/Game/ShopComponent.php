<?php

namespace App\Livewire\Frontend\Game;

use App\Services\CategoryService;
use Livewire\Component;

class ShopComponent extends Component
{
    public $gameSlug;

    public $categorySlug;

    public $layoutView = 'list_grid';

    protected CategoryService $categoryService;

    public function boot(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function mount($gameSlug, $categorySlug)
    {
        $this->gameSlug = $gameSlug;

        $this->categorySlug = $categorySlug;

        $category = $this->categoryService->findData($this->categorySlug, 'slug');

        if ($category === null) {
            abort(404);
        }

        $this->layoutView = $category->layout?->value ?? 'list_grid';
    }

    public function render()
    {
        return view('livewire.frontend.game.shop-component', [
            'gameSlug' => $this->gameSlug,
            'categorySlug' => $this->categorySlug,
        ]);
    }

    public function resetAllFilters()
    {
        $this->reset();
    }
}
