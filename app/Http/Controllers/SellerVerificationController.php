<?php

namespace App\Http\Controllers;


class SellerVerificationController extends Controller
{
    //

    protected $master = 'frontend.pages.seller_verification';
    public function index($step = 0){
        if($step !=  0){
             $step = decrypt($step);
        }
        return view($this->master,[
            'step' => $step,
        ]);
        
    }
}
