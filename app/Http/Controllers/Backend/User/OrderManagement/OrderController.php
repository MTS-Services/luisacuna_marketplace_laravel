<?php

namespace App\Http\Controllers\Backend\User\OrderManagement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    protected $masterView='backend.user.pages.orders.order';

    public function purchasedOrders()
    {
        return view($this->masterView);
    }

    public function soldOrders()
    {
        return view($this->masterView);
    }
}
