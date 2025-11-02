<?php

namespace App\Http\Controllers\Backend\admin\ProductManagament;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductTypeController extends Controller
{
    protected $masterView = 'backend.admin.pages.product-management.productType';

    public function index()
    {
        return view($this->masterView);
    }
    public function create()
    {
        return view($this->masterView);
    }
}
