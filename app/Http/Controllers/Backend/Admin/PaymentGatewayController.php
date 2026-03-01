<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaymentGateway;

class PaymentGatewayController extends Controller
{
    protected string $masterView = 'backend.admin.pages.payment-gateway.master';

    public function paymentIndex()
    {
        return view($this->masterView);
    }

    public function paymentEdit(int $id)
    {
        $gateway = PaymentGateway::findOrFail($id);

        return view($this->masterView, [
            'gateway' => $gateway,
        ]);
    }
}
