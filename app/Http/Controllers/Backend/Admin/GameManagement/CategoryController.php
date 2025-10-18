<?php

namespace App\Http\Controllers\Backend\Admin\GameManagement;

use App\Http\Controllers\Controller;
use App\Models\GameCategory;

class CategoryController extends Controller
{
    protected $masterView = 'backend.admin.pages.game-management.category.index';
    public function index()
    {
        return view($this->masterView);
    }

    public function create()
    {
        return view($this->masterView);
    }

    public function edit($id)
    {
        $category = GameCategory::findOrFail($id);
        return view($this->masterView , [
            'category'  => $category
        ]);
    }
}
