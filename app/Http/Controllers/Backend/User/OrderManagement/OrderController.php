<?php

namespace App\Http\Controllers\Backend\User\OrderManagement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    protected $userMasterView='backend.user.pages.orders.order';
    protected $frontendMasterView='backend.user.pages.orders.order-details';

    public function purchasedOrders()
    {
        return view($this->userMasterView);
    }

    public function soldOrders()
    {
        return view($this->userMasterView);
    }

    public function cancel($orderId)
    {
        return view($this->frontendMasterView, compact('orderId'));
    }
    public function complete($orderId)
    {
        return view($this->frontendMasterView, compact('orderId'));
    }
    public function detail($orderId)
    {
        return view($this->frontendMasterView, compact('orderId'));
    }
}
