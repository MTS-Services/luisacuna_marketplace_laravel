<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserProfileController extends Controller
{
     protected UserService $service;
    public function __construct(UserService $service)
    {
        $this->service = $service;
    }

    protected $masterView = 'frontend.pages.userProfile';
    
    public function index(string $username)
    {
       $user = $this->service->findData($username, 'username');

        if (!$user) {
             abort(404, 'User not found.');
        }
        return view($this->masterView, [
            'user' => $user
        ]);
    }



    public function shop()
    {
        return view($this->masterView);
    }
}
