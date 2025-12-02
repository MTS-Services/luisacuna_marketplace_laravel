<?php

namespace App\Http\Controllers\Backend\Admin\BannerManagement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    //
    public $master = 'backend.admin.pages.banner-management.banner';

    public function index()
    {
        return view($this->master);
    }

    public function create()
    {
        return view($this->master);
    }
}
