<?php

namespace App\Http\Controllers\Backend\Admin\UserManagement;

use App\Http\Controllers\Controller;

use App\Services\UserService;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;


class UserController extends Controller implements HasMiddleware
{
    protected $masterView = 'backend.admin.pages.user-management.user.user';

    protected UserService $service;
    public function __construct(UserService $service)
    {
        $this->service = $service;
    }


    public static function middleware(): array
        {
            return [
                'auth:admin', // Applies 'auth:admin' to all methods

                // Permission middlewares using the Middleware class
                new Middleware('permission:admin-list', only: ['index']),
                new Middleware('permission:admin-create', only: ['create']),
                new Middleware('permission:admin-edit', only: ['edit']),
                new Middleware('permission:admin-view', only: ['view']),
                new Middleware('permission:admin-trash', only: ['trash']),
                new Middleware('permission:admin-profileInfo', only: ['profileInfo']),
                new Middleware('permission:admin-shopInfo', only: ['shopInfo']),
                new Middleware('permission:admin-kycInfo', only: ['kycInfo']),
                new Middleware('permission:admin-statistic', only: ['statistic']),
                new Middleware('permission:admin-referral', only: ['referral']),
            ];
        }

    public function index()
    {
        return view($this->masterView);
    }
    public function create()
    {
        return view($this->masterView);
    }
    public function view(string $id)
    {
        $user = $this->service->getDataById($id);

        if (!$user) {
            abort(404);
        }

        return view($this->masterView, [
            'user' => $user
        ]);
    }
    public function edit(string $id)
    {
        $user = $this->service->getDataById($id);
        if (!$user) {
            abort(404);
        }
        return view($this->masterView, [
            'user' => $user
        ]);
    }
    public function trash()
    {
        return view($this->masterView);
    }
    public function profileInfo($id)
    {
        $user = $this->service->getDataById($id);
        if (!$user) {
            abort(404);
        }
        return view($this->masterView, [
            'user' => $user
        ]);
    }
    public function shopInfo($id)
    {
        $user = $this->service->getDataById($id);
        if (!$user) {
            abort(404);
        }
        return view($this->masterView, [
            'user' => $user
        ]);
    }
    public function kycInfo($id)
    {

        $user = $this->service->getDataById($id);
        if (!$user) {
            abort(404);
        }
        return view($this->masterView, [
            'user' => $user
        ]);
    }
    public function statistic($id)
    {
        $user = $this->service->getDataById($id);
        if (!$user) {
            abort(404);
        }
        return view($this->masterView, [
            'user' => $user
        ]);
    }
    public function referral($id)
    {
        $user = $this->service->getDataById($id);
        if (!$user) {
            abort(404);
        }
        return view($this->masterView, [
            'user' => $user
        ]);
    }
}
