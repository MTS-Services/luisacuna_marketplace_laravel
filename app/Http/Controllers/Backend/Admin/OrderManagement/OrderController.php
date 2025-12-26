<?php

namespace App\Http\Controllers\Backend\Admin\OrderManagement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrderController extends Controller
{

    protected $masterView = 'backend.admin.pages.order-management.order';
    public function index()
    {
        return view($this->masterView);
    }

    public function paidOrders()
    {
        return view($this->masterView);
    }
    public function completedOrders()
    {
        return view($this->masterView);
    }
    public function cancelledOrders()
    {
        return view($this->masterView);
    }

    public function show($orderId)
    {
        return null;
    
    }
}
