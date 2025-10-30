<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;

class GameController extends Controller
{
    protected $masterView = 'frontend.pages.game';

    public function index($slug)
    {
        return view($this->masterView, compact('slug'));
    }
}
