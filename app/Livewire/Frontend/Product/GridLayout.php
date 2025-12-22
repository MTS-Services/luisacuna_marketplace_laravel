<?php

namespace App\Livewire\Frontend\Product;

use App\Services\GameService;
use App\Services\PlatformService;
use App\Services\ProductService;
use App\Traits\WithPaginationData;
use Livewire\Component;

class GridLayout extends Component
{
    use WithPaginationData;

    public $game;

    public $platforms;

   

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
         
        $this->datas = $this->getDatas();

        $this->pagination = $this->paginationData($this->datas);
       
        return view('livewire.frontend.product.grid-layout', [
            'datas' => $this->datas
        ]);
    }

    public function resetAllFilters(){
        // $this->reset();
        // $this->render()->skip()->dispatch();
    }
}
