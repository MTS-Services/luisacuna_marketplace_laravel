<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;

class SellerVerificationController extends Controller
{
    protected $masterView = 'frontend.pages.seller_verification';

    public function verify()
    {
        return view($this->masterView);
    }

    public function index()
    {
        return view($this->masterView);
    }

    public function three()
    {
        return view($this->masterView);
    }

    public function four()
    {
        return view($this->masterView);
    }

    public function five()
    {
        return view($this->masterView);
    }

    public function six()
    {
        return view($this->masterView);
    }

}
