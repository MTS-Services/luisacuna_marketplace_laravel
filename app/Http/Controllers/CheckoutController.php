<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    //

    public function checkout($slug, $token){


       
        return view('frontend.pages.game', compact('slug', 'token'));

    }
}
