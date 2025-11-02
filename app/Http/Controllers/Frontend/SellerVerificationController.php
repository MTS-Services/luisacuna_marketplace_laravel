<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;

class SellerVerificationController extends Controller
{
    protected $masterView = 'frontend.pages.seller_verification';

    public function index()
    {
        return view($this->masterView);
    }
}
