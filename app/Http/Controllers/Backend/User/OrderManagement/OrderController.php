<?php

namespace App\Http\Controllers\Backend\User\OrderManagement;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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

    public function cancel(string $orderId)
    {
        return view($this->frontendMasterView, compact('orderId'));
    }
    public function complete(string $orderId)
    {
        return view($this->frontendMasterView, compact('orderId'));
    }
    public function detail($orderId)
    {
        return view($this->frontendMasterView, compact('orderId'));
    }
}
