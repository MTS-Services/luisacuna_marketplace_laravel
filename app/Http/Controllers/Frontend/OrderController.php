<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    //Index
    public $master = "frontend.pages.order";
    public function index(){

        return view($this->master);

    }

    public function cancel(){

        return view($this->master);
        
    }

    public function chatHelp(){ 

        return view($this->master);
        
    }

    public function chatHelpTwo(){

        return view($this->master);

    }

    public function complete(){

        return view($this->master);
        
    }

    public function chatHelpThree(){
        return view($this->master);
    }   
}
