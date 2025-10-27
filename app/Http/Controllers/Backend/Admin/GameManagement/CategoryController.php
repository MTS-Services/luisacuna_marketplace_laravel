<?php

namespace App\Http\Controllers\Backend\Admin\GameManagement;

use App\Http\Controllers\Controller;
use App\Models\GameCategory;
use App\Services\Game\GameCategoryService;

class CategoryController extends Controller
{

    
    protected $masterView = 'backend.admin.pages.game-management.category.index';
    protected GameCategoryService $gameCategoryService;
    public function __construct(GameCategoryService $gameCategoryService)
    {
        $this->gameCategoryService = $gameCategoryService;
    }
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
        $category = $this->gameCategoryService->findOrFail($id);
        return view($this->masterView , [
            'category'  => $category
        ]);
    }
    public function show($id)
    {
        $category = $this->gameCategoryService->findOrFail($id);
        return view($this->masterView , [
            'category'  => $category
        ]);
    }

    public function trash(){

        return view($this->masterView);

    }

}
