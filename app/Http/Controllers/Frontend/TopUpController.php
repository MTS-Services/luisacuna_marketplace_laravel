<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TopUpController extends Controller
{
    protected $masterView = 'frontend.pages.product';

    public function index()
    {
        return view($this->masterView, [
            'categorySlug' => 'top-up'
        ]);
    }
}
