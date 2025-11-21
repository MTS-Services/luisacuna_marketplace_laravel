<?php

namespace App\Http\Controllers\Backend\Admin\ProductManagament;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\ProductTypeService;

use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;

class ProductTypeController extends Controller implements HasMiddleware
{
    protected $masterView = 'backend.admin.pages.product-management.productType';

    public function __construct(protected ProductTypeService $service) {}


    public static function middleware(): array
    {
        return [
            'auth:admin', // Applies 'auth:admin' to all methods

            // Permission middlewares using the Middleware class
            new Middleware('permission:product-type-list', only: ['index']),
            new Middleware('permission:product-type-create', only: ['create']),
            new Middleware('permission:product-type-edit', only: ['edit']),
            new Middleware('permission:product-type-show', only: ['show']),
            new Middleware('permission:product-type-trash', only: ['trash']),
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
