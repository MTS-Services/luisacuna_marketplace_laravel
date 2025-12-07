<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Services\ProductService;

class GameController extends Controller
{
    protected $masterView = 'frontend.pages.game';

    public function __construct(protected ProductService $service){}

    public function index($gameSlug, $categorySlug)
    {
        return view($this->masterView, compact('gameSlug', 'categorySlug'));
    }


    public function buy($gameSlug, $categorySlug, $productId){
        // $this->service->findData($productId, 'id')->slug;
        return view($this->masterView, compact('gameSlug', 'categorySlug', 'productId'));
    }

    public function checkout($orderId){
        $gameSlug = 'game-1'; // Retrieve gameSlug based on orderId
        $categorySlug = 'currency'; // Retrieve categorySlug based on orderId
        $sellerSlug = 'seller-1'; // Retrieve sellerSlug based on orderId
        return view($this->masterView, compact('gameSlug', 'categorySlug', 'sellerSlug', 'orderId'));
    }
}
