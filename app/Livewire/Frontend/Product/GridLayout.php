<?php

namespace App\Livewire\Frontend\Product;

use App\Models\Game;
use App\Models\GameConfig;
use App\Services\GameService;
use App\Services\PlatformService;
use App\Services\ProductService;
use Livewire\Component;

class GridLayout extends Component
{

    public $game;

    public $platforms;

    public $perPage = 2;

    public $categorySlug;

    public $gameSlug;

    protected $datas;

    protected PlatformService $platformService;
    protected ProductService $productService;
    protected GameService $gameService;

    public function boot(PlatformService $platformService, ProductService $productService , GameService $gameService){

        $this->platformService = $platformService;

        $this->productService = $productService;

        $this->gameService = $gameService;

    }
    public function mount($gameSlug, $categorySlug){

        $this->gameSlug = $gameSlug;

        $this->categorySlug = $categorySlug;


        $this->game = $this->gameService->findData($gameSlug, 'slug')->load(['gameConfig', 'tags']) ;   

        
        $this->datas = $this->getDatas();

        $this->platforms = $this->platformService->getAllDatas() ?? [];
    }

    public function getDatas(){
        
     return  $this->productService->getPaginatedData($this->perPage, [

            'gameSlug' => $this->gameSlug,

            'categorySlug' => $this->categorySlug,


        ]);
    }

    public function serachFilters(){
       
       
    }
    public function render()
    {
       
        return view('livewire.frontend.product.grid-layout', [
            'datas' => $this->datas
        ]);
    }
}
