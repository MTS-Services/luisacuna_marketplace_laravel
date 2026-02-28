<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PaymentGatewayController extends Controller
{
    protected string $masterView = 'backend.admin.pages.payment-gateway.master';

    public function paymentIndex()
    {
        return view($this->masterView);
    }
}
