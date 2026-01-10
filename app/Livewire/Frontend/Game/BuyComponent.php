<?php

namespace App\Livewire\Frontend\Game;


use App\Services\ProductService;
use App\Traits\WithPaginationData;
use Livewire\Component;

class BuyComponent extends Component
{

    use WithPaginationData;
    public $gameSlug;
    public $categorySlug;
    public $productId;
    public $product;
    public $game;
    public $user;
    protected ProductService $service;

    public function boot(ProductService $service)
    {
        $this->service = $service;
    }
    public function mount($gameSlug, $categorySlug, $productId)
    {
        $this->gameSlug = $gameSlug;
        $this->categorySlug = $categorySlug;
        $this->productId = decrypt($productId);
        $this->product = $this->service->findData($this->productId)->load(['games', 'user']);
        $this->game = $this->product->games;
        $this->user = $this->product->user;

    }
    public function render()
    {
        $othersSellerProducts =  $this->othersSellerProducts();
        $this->paginationData($othersSellerProducts);
        return view('livewire.frontend.game.buy-component', [

            'relatedProducts' => $othersSellerProducts,
        ]);
    }

    public function othersSellerProducts(){
      return  $this->service->getPaginatedData($this->perPage, [
            'categorySlug' => $this->categorySlug,
            'gameSlug' => $this->gameSlug,
        ]);
    }
}
