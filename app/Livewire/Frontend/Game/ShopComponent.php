<?php

namespace App\Livewire\Frontend\Game;

use App\Models\Product;
use App\Services\CategoryService;
use App\Services\GameService;
use Livewire\Component;

class ShopComponent extends Component
{
    public $gameSlug;
    public $categorySlug;
    public $search = '';
    public $selectedDevice = null;
    public $selectedAccountType = null;
    public $selectedPrice = null;
    public $selectedDeliveryTime = null;
    public $selectedRegion = null;
    public $selectedSort = null;
    public $layoutView = 'list-grid';
    public $game;
    protected $category = null;
    public  $products ;

    // Service

    protected GameService $gameService;
    protected CategoryService $categoryService;
    public function boot(GameService $gameService, CategoryService $categoryService){
        $this->gameService = $gameService;
        $this->categoryService = $categoryService;
    }

    public function tagSelected($tag)
    {
        $this->search = $tag;
        $this->serachFilter(); // Trigger search when tag is selected
    }


    public function mount($gameSlug, $categorySlug)
    {


        $this->gameSlug = $gameSlug;

       $this->game = $this->gameService->findData($gameSlug, 'slug')
        ->load([
        'products' => function ($query) use ($categorySlug) {
            $query->whereHas('category', function ($q) use ($categorySlug) {
                $q->where('slug', $categorySlug);
            })->with('product_configs.game_configs');
        },
        'gameConfig',
        'categories'
    ]);

        $this->products = $this->game->products;



        $this->categorySlug = $categorySlug;

      //    $this->category = $this->categoryService->findData($categorySlug, 'slug')->load(['games.gameConfig', 'games.products']);
        
        $this->category = $this->categoryService->findData($categorySlug, 'slug');

        $this->layoutView = $this->category->layout->value ?? 'grid';

      
    }

    public function render()
    {   
        



        return view('livewire.frontend.game.shop-component', [
            'gameSlug' => $this->gameSlug,
            'categorySlug' => $this->categorySlug,
            'datas' => $this->products,
        ]);
    }

    public function serachFilter()
    {
        // Simulate search/fetch logic
        sleep(1);
        
        // Your actual search logic here
        // Example: $this->datas = YourModel::where('name', 'like', '%' . $this->search . '%')->get();
        
        // Dispatch event to stop loading
        $this->dispatch('loaded');
    }

    public function resetAllFilters()
    {
        $this->search = '';
        $this->selectedDevice = null;
        $this->selectedAccountType = null;
        $this->selectedPrice = null;
        $this->selectedDeliveryTime = null;
        
        $this->serachFilter(); // Trigger search to reset filters
    }   

    public function changeView()
    {
        // Logic to change view layout
        $this->layoutView = $this->layoutView === 'grid' ? 'list' : 'grid';
    }

}