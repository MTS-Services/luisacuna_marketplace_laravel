<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;

class GameController extends Controller
{
    protected $masterView = 'frontend.pages.game';

    public function index($gameSlug, $categorySlug)
    {
        return view($this->masterView, compact('gameSlug', 'categorySlug'));
    }


    public function buy($gameSlug, $categorySlug, $sellerSlug){
        return view($this->masterView, compact('gameSlug', 'categorySlug', 'sellerSlug'));
    }
}
