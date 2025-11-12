<?php

namespace App\Http\Controllers\Backend\Admin\Settings;

use App\Http\Controllers\Controller;

class GeneralSettingsController extends Controller
{
     protected $masterView = 'backend.admin.pages.settings.general-settings';


    public function index()
    {
        return view($this->masterView);
    }
}