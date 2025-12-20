<?php

namespace App\Http\Controllers\Backend\User\OrderManagement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OngoingOrderController extends Controller
{
    protected $masterView = 'backend.user.pages.orders.ongoing-order';

    public function details()
    {
        return view($this->masterView);
    }

    public function description()
    {
        return view($this->masterView);
    }
}
