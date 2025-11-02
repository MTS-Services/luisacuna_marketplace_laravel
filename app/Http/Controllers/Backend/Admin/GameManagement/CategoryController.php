<?php

namespace App\Http\Controllers\Backend\Admin\GameManagement;

use App\Http\Controllers\Controller;

use App\Services\Game\GameCategoryService;

class CategoryController extends Controller
{

    
    protected $masterView = 'backend.admin.pages.game-management.category.index';
    protected GameCategoryService $service;
    public function __construct(GameCategoryService $service)
    {
        $this->service = $service;
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
        $category = $this->service->findOrFail(decrypt($id));
        return view($this->masterView , [
            'category'  => $category
        ]);
    }
    public function show($id)
    {
        
      
        $category = $this->service->findData(decrypt($id));
        if (!$category) {
            abort(404);
        }

        return view($this->masterView , [
            'category'  => $category
        ]);
    }

    public function trash(){

        return view($this->masterView);

    }

}
