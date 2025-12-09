<?php

namespace App\Livewire\Frontend\Product;

use App\Models\Product;
use App\Services\ProductService;
use Livewire\Component;

class ListLayout extends Component
{
    public  $gameSlug ;
    public $categorySlug; 
    public $game ;
    protected $datas;

    public ?Product $product = null;

    protected ProductService $productService;
    public function boot(ProductService $productService){
        $this->productService = $productService;
    }
    public function mount($gameSlug, $categorySlug, $game, $datas){
        $this->gameSlug = $gameSlug;
        $this->categorySlug = $categorySlug;
        $this->game = $game;
        $this->datas = $datas;
    }
    public function selectItem($ecnryptedId){

        $this->product = $this->productService->findData(decrypt($ecnryptedId));
        
  
       
    }
    public function render()
    {
       

        return view('livewire.frontend.product.list-layout', [
            'gameSlug' => $this->gameSlug,
            'categorySlug' => $this->categorySlug,
            'game' => $this->game,
            'datas' => $this->datas,
            'product' => $this->product ?? null
        ]);
    }


}
