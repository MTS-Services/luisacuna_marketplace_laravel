<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;

class SellGameController extends Controller
{
    protected $masterView = 'frontend.pages.sellgame';

    public function index()
    {
        return view($this->masterView);
    }

    public function delivery()
    {
        return view($this->masterView);
    }
}
