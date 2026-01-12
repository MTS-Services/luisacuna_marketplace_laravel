<?php

namespace App\Http\Controllers\Backend\Admin\OrderManagement;

use App\Http\Controllers\Controller;
use App\Services\OrderService;
use Illuminate\Http\Request;

class OrderController extends Controller
{

    protected OrderService $service;
    protected $masterView = 'backend.admin.pages.order-management.order';
    public function __construct(OrderService $service)
    {
        $this->service = $service;
    }
    public function index()
    {
        return view($this->masterView);
    }

    public function progressOrders()
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

    public function disputeOrders(){
        return view($this->masterView);
    }

    public function show($orderID)
    {
        $data = $this->service->findData(column_value: $orderID, column_name: 'order_id');
        if (!$data) {
            abort(404);
        }

        return view($this->masterView, [
            'data' => $data
        ]);
    }
}
