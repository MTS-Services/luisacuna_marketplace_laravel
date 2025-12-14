<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SellerKycController extends Controller
{
    //

    protected $master = 'frontend.pages.seller_kyc';
    public function index($step = 0){
        return view($this->master,compact('step'));
    }
}
