<?php

namespace App\Http\Controllers\Backend\Admin\EmailTemplate;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EmailTemplateController extends Controller
{
    //
  public $masterView = 'backend.admin.pages.email-template.index';
    public function index()
    {
        return view($this->masterView);
    }

    public function edit($id){
        return view($this->masterView , compact('id'));
    }
}
