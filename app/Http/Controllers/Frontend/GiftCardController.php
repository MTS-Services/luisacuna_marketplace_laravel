<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;

class GiftCardController extends Controller
{


    protected $masterView = 'frontend.pages.gift_card';

    public function index()
    {
        return view($this->masterView);
    }
}