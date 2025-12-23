<?php

namespace App\Http\Controllers\Backend\User\OrderManagement;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Services\ProductService;
use App\Http\Controllers\Controller;

class OrderDetailsController extends Controller
{
    protected $masterView = 'backend.user.pages.orders.order-details';

    // public function orderDetails()
    // {
    //     return view($this->masterView);
    // }
    public function cancel()
    {
        return view($this->masterView);
    }
    public function complete()
    {
        return view($this->masterView);
    }

    public function detail()
    {
        return view($this->masterView);
    }
}
