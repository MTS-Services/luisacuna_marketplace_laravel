<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    protected $masterView = 'frontend.pages.home';

    public function index()
    {
        return view($this->masterView);
    }

    public function selling(){

        return view($this->masterView);

    }

    public function selectGame(){
        return view($this->masterView);
    }   
}
