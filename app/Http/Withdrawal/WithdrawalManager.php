<?php

namespace App\Http\Withdrawal;

use Illuminate\Support\Collection;

class WithdrawalManager
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
            'payoneer' => Pa::class,
            'paypal' => CoinbaseMethod::class,
        ]);
    }

    /**
     * Get the payment methods.
     */
    public function getPaymentMethods(): Collection
    {
        return $this->paymentMethods;
    }
}
