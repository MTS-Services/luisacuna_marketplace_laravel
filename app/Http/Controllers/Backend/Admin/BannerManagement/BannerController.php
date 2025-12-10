<?php

namespace App\Http\Controllers\Backend\Admin\BannerManagement;

use App\Http\Controllers\Controller;
use App\Services\HeroService;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    //
    public $master = 'backend.admin.pages.banner-management.banner';

    public function  __construct(protected HeroService $heroService)
    {
        
    }
    public function index()
    {
        return view($this->master);
    }

    public function create()
    {
        return view($this->master);
    }

    public function edit($encryptId)
    {
        $data = $this->heroService->findData(decrypt($encryptId));
        if (!$data) {
            abort(404,"Item Not Found");   
        }
         return view($this->master, [
            'data' => $data
         ]);
    }
}
