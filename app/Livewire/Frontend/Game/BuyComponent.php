<?php

namespace App\Livewire\Frontend\Game;

use App\Services\ProductService;
use App\Traits\WithPaginationData;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Url;
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

    #[Url(keep: true)]
    public $sellerFilter = 'recommended';

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

        if (Auth::check() && (int) $this->product->user_id === (int) Auth::id()) {
            session()->flash('message', __('You cannot purchase your own product.'));
            $this->redirect(route('game.index', ['gameSlug' => $this->gameSlug, 'categorySlug' => $this->categorySlug]), navigate: true);
        }
    }
    public function render()
    {
        $othersSellerProducts =  $this->othersSellerProducts();
        $this->paginationData($othersSellerProducts);
        return view('livewire.frontend.game.buy-component', [

            'relatedProducts' => $othersSellerProducts,
        ]);
    }

    public function othersSellerProducts()
    {
        //   return  $this->service->getPaginatedData($this->perPage, [
        //         'categorySlug' => $this->categorySlug,
        //         'gameSlug' => $this->gameSlug,
        //     ]);

        $filters = [];

        if ($this->sellerFilter === 'positive_reviews') {
            $filters['positive_reviews'] = true;
        }

        // Handle other filters
        if ($this->sellerFilter === 'lowest_price') {
            $filters['sort_field'] = 'price';
            $filters['sort_direction'] = 'asc';
        }
        if ($this->sellerFilter === 'in_stock') {
            $filters['sort_field'] = 'quantity';
            $filters['sort_direction'] = 'desc';
        }
        if ($this->sellerFilter === 'top_sold') {
            $filters['top_sold'] = true;
        }

        $filters['skipSelf'] = true;
        $filters['gameSlug'] = $this->gameSlug;
        $filters['categorySlug'] = $this->categorySlug;

        $otherSellers = $this->service->getSellers(11, $filters);
        $otherSellers->load('user.feedbacksReceived');
        return $otherSellers;
    }
}
