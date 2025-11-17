<?php

namespace App\Http\Controllers\Backend\Admin\Language;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
class LanguageController extends Controller implements HasMiddleware
{
    protected $masterView = 'backend.admin.pages.language.language';


    public static function middleware(): array
        {
            return [
                'auth:admin', // Applies 'auth:admin' to all methods

                // Permission middlewares using the Middleware class
                new Middleware('permission:admin-list', only: ['index']),
                new Middleware('permission:admin-create', only: ['create']),
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

}
