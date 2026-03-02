<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Services\UserService;

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

        if (! $user) {
            abort(404, __('User not found.'));
        }

        return view($this->masterView, [
            'user' => $user,
        ]);
    }
}
