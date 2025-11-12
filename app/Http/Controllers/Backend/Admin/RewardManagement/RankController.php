<?php

namespace App\Http\Controllers\Backend\Admin\RewardManagement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RankController extends Controller
{
    //
    public $masterview = 'backend.admin.pages.reward-management.rank';
    public function index(){
        return view($this->masterview);
    }
}
