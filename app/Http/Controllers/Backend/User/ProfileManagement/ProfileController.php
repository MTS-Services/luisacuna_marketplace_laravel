<?php

namespace App\Http\Controllers\Backend\User\ProfileManagement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    protected $masterView = 'backend.user.pages.profile';

    public function index()
    {
        return view($this->masterView);
    }
}

