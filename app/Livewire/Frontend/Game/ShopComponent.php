<?php

namespace App\Livewire\Frontend\Game;

use App\Models\Product;
use App\Services\CategoryService;
use App\Services\GameService;
use App\Services\ProductService;
use Livewire\Component;

class ShopComponent extends Component
{
    public $gameSlug;
    public $categorySlug;
    public $layoutView = 'list_grid';

    protected CategoryService $categoryService;

    public function boot( CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }
    public function mount($gameSlug, $categorySlug)
    {
        $this->gameSlug = $gameSlug;

        $this->categorySlug = $categorySlug;

        $this->layoutView =   $this->categoryService->findData($categorySlug, 'slug')->layout->value;

    }

    public function render()
    {
        return view('livewire.frontend.game.shop-component', [
            'gameSlug' => $this->gameSlug,
            'categorySlug' => $this->categorySlug,
        ]);
    }

}
