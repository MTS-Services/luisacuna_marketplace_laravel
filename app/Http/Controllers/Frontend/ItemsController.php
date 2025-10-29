<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;

class ItemsController extends Controller
{
    
    protected $masterView = 'frontend.pages.items';

    public function items()
    {
        return view($this->masterView);
    }
}
