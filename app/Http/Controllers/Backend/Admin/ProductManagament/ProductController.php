<?php

namespace App\Http\Controllers\Backend\Admin\ProductManagament;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\ProductService;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class ProductController extends Controller implements HasMiddleware
{
    protected $masterView = 'backend.admin.pages.product-management.product';

    public function __construct(protected ProductService $service) {}


    public static function middleware(): array
    {
        return [
            'auth:admin', // Applies 'auth:admin' to all methods

            // Permission middlewares using the Middleware class
            new Middleware('permission:product-list', only: ['index']),
            new Middleware('permission:product-create', only: ['create']),
            new Middleware('permission:product-edit', only: ['edit']),
            new Middleware('permission:product-show', only: ['show']),
            new Middleware('permission:product-trash', only: ['trash']),
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
    public function edit(string $encryptedId)
    {
        $data = $this->service->findData(decrypt($encryptedId));
        if (!$data) {
            abort(404);
        }
        return view($this->masterView, [
            'data' => $data
        ]);
    }
    public function show(string $encryptedId)
    {
        $data = $this->service->findData(decrypt($encryptedId));
        if (!$data) {
            abort(404);
        }
        return view($this->masterView, [
            'data' => $data
        ]);
    }
    public function trash()
    {
        return view($this->masterView);
    }
}
