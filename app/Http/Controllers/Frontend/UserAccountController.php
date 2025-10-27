<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserAccountController extends Controller
{
    
    protected $masterView = 'frontend.pages.userAccount';

    public function account()
    {
        return view($this->masterView);
    }
}
 