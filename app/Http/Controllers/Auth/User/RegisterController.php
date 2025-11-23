<?php

namespace App\Http\Controllers\Auth\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    protected $masterView = 'backend.user.pages.auth.register';


    public function signUp()
    {
        return view($this->masterView);
    }

    public function emailVerify()
    {
        return view($this->masterView);
    }

    public function otp()
    {
        return view($this->masterView);
    }

    public function password()
    {
        return view($this->masterView);
    }
}
