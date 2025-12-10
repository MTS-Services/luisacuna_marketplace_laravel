<?php

namespace App\Http\Controllers\Backend\Admin\ProductManagement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ItemsController extends Controller
{
   protected string $masterView = 'backend.admin.pages.product-management.items';

    public function index()
    {
        return view($this->masterView);
    }
}
