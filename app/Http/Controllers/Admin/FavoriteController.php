<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
     protected $masterView = 'backend.admin.pages.master-favorite.favorite-favorite';

    public function index()
    {
        return view($this->masterView);
    }
    public function show()
    {

        return view($this->masterView);

    }

    public function create()
    {

        return view($this->masterView);
    }
       public function edit(string $encryptedId)
    {

        return view($this->masterView);
    }
}
