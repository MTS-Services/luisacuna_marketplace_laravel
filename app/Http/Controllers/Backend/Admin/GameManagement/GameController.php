<?php

namespace App\Http\Controllers\Backend\Admin\GameManagement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GameController extends Controller
{
    //
    public $masterView = 'backend.admin.pages.game-management.game.index';
    public function index()
    {
        return view($this->masterView);
    }
}
