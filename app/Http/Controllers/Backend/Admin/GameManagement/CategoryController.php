<?php

namespace App\Http\Controllers\Backend\Admin\GameManagement;

use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    protected $masterView = 'backend.admin.pages.game-management.category.index';
    public function index()
    {
        return view($this->masterView);
    }
}
