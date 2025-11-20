<?php

namespace App\Http\Withdrawal;

use App\Models\WithdrawalGateway;

abstract class WithdrawalMethod
{
    /**
     * The payment method name.
     *
     * @var string
     */
    protected $name;

    /**
     * The associated gateway.
     */
    protected ?WithdrawalGateway $gateway;

    /**
     * Create a new method instance.
     */
    public function __construct(?WithdrawalGateway $gateway)
    {
        $this->gateway = $gateway;
    }
}
