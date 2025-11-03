<?php

namespace App\Http\Controllers\Backend\admin\ProductManagament;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Product\ProductService;

class ProductController extends Controller
{
    protected $masterView = 'backend.admin.pages.product-management.product';

    public function __construct(protected ProductService $service)
    {}

    public function index()
    {
        return view($this->masterView);
    }
    public function create()
    {
        return view($this->masterView);
    }
}
