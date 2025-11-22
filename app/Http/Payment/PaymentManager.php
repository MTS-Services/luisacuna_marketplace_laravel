<?php

namespace App\Http\Payment;

use Illuminate\Support\Collection;
use App\Http\Payment\Methods\CoinbaseMethod;
use App\Http\Payment\Methods\PaypalMethod;
use App\Http\Payment\Methods\StripeMethod;
use App\Models\PaymentGateway;

class PaymentManager
{
    /**
     * The loaded payment methods.
     */
    protected Collection $paymentMethods;

    /**
     * Construct a new payment manager instance.
     */
    public function __construct()
    {
        $this->paymentMethods = collect([
            'stripe' => StripeMethod::class,
            'coinbase' => CoinbaseMethod::class,
            'paypal' => PaypalMethod::class
        ]);
    }

    /**
     * Get the payment methods.
     */
    public function getPaymentMethods(): Collection
    {
        return $this->paymentMethods;
    }

    public function getPaymentMethod(string $type, ?PaymentGateway $gateway = null): ?PaymentMethod
    {
        $class = $this->paymentMethods->get($type);

        return $class ? app($class, $gateway ? ['gateway' => $gateway] : []) : null;
    }

    public function getPaymentMethodOrFail(string $slug, ?PaymentGateway $gateway = null): PaymentMethod
    {
        abort_if(!$this->paymentMethods->has($slug), 404);

        return $this->getPaymentMethod($slug, $gateway);
    }

    public function hasPaymentMethod(string $slug): bool
    {
        return $this->paymentMethods->has($slug);
    }
}
