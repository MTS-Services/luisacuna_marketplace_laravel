<?php

namespace App\Http\Payment\Methods;

use App\Http\Payment\PaymentMethod;
use App\Models\Order;

class PaypalMethod extends PaymentMethod
{
    public function startPayment(Order $order, array $paymentData)
    {
        dd($order, $paymentData);
    }
}
