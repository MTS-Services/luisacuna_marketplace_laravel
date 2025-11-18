<?php

namespace App\Http\Controllers\Backend\Admin\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class GeneralSettingsController extends Controller implements HasMiddleware
{
     protected $masterView = 'backend.admin.pages.settings.general-settings';


     public static function middleware(): array
        {
            return [
                'auth:admin', // Applies 'auth:admin' to all methods

                // Permission middlewares using the Middleware class
                new Middleware('permission:admin-list', only: ['index']),
            ];
        }

    public function index()
    {
        return view($this->masterView);
    }
}
