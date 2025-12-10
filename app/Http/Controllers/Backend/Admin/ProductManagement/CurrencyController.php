<?php

namespace App\Http\Controllers\Backend\Admin\ProductManagement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CurrencyController extends Controller
{
    protected string $masterView = 'backend.admin.pages.product-management.category';

    public function index($categorySlug)
    {
        return view($this->masterView, compact('categorySlug'));
    }
}
