<?php

namespace App\Http\Controllers\Backend\Admin\EmailTemplate;

use App\Http\Controllers\Controller;

class EmailTemplateController extends Controller
{
    public string $masterView = 'backend.admin.pages.email-template.index';

    public function index()
    {
        return view($this->masterView);
    }

    public function edit(string $id)
    {
        return view($this->masterView, compact('id'));
    }
}
