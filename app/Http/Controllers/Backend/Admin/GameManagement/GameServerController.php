<?php

namespace App\Http\Controllers\Backend\Admin\GameManagement;

use App\Http\Controllers\Controller;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class GameServerController extends Controller implements HasMiddleware
{
    //
    public $master = 'backend.admin.pages.game-management.game_server';

    public static function middleware(): array
        {
            return [
                'auth:admin', // Applies 'auth:admin' to all methods

                // Permission middlewares using the Middleware class
                new Middleware('permission:admin-list', only: ['index']),
                new Middleware('permission:admin-create', only: ['create']),
            ];
        }

    public function index(){

        return view($this->master);
    }

    public function create(){

        return view($this->master);

    }
}
