<?php

namespace App\Http\Controllers\Backend\Admin\OfferManagement;

use App\Http\Controllers\Controller;
use App\Services\OfferItemService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
class OfferController extends Controller implements HasMiddleware
{
    protected $masterView = 'backend.admin.pages.offer-management.offer-item';

    public function __construct(protected OfferItemService $service) {}

     public static function middleware(): array
        {
            return [
                'auth:admin', // Applies 'auth:admin' to all methods

                // Permission middlewares using the Middleware class
                new Middleware('permission:offer-list', only: ['index']),
            ];
        }
    public function index()
    {
        return view($this->masterView);
    }
}
