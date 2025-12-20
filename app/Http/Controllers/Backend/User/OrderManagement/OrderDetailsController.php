<?php

namespace App\Http\Controllers\Backend\User\OrderManagement;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Services\ProductService;
use App\Http\Controllers\Controller;

class OrderDetailsController extends Controller
{
    protected $masterView = 'backend.user.pages.orders.order-details';


    public function orderDetails(string $encryptedId)
    {

        $orderId = decrypt($encryptedId);
       

        return view($this->masterView, [
            'orderId' => $orderId
        ]);
    }
}
