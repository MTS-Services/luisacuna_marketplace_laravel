<?php

namespace App\Http\Controllers\Backend\Admin\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class ApplicationSettingController extends Controller implements HasMiddleware
{
    protected $masterView = 'backend.admin.pages.settings.application-settings';


    public static function middleware(): array
    {
        return [
            'auth:admin', // Applies 'auth:admin' to all methods
            new Middleware('permission:general-settings', only: ['generalSettings']),
            new Middleware('permission:database-settings', only: ['databaseSettings']),
        ];
    }

    public function generalSettings()
    {
        return view($this->masterView);
    }
    public function databaseSettings()
    {
        return view($this->masterView);
    }
}
