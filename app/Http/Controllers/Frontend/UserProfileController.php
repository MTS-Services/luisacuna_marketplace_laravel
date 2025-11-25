<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserProfileController extends Controller
{
    protected $masterView = 'frontend.pages.userProfile';
    
    public function index($username)
    {
        $user=User::where('username', '=', $username)->firstOrFail();
        return view($this->masterView , compact('user'));
    }
    public function shop()
    {
        return view($this->masterView);
    }
}
