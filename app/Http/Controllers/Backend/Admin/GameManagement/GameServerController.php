<?php

namespace App\Http\Controllers\Backend\Admin\GameManagement;

use App\Http\Controllers\Controller;


class GameServerController extends Controller
{
    //
    public $master = 'backend.admin.pages.game-management.game_server';

    public function index(){

        return view($this->master);
    }

    public function create(){

        return view($this->master);

    }
}
