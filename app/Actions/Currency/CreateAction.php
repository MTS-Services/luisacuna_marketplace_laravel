<?php

namespace App\Actions\Currency;

use App\Models\Currency;
use App\Models\ExchangeRate;
use App\Repositories\Contracts\CurrencyRepositoryInterface;
use Illuminate\Support\Facades\DB;

class CreateAction
{
    public function __construct(
        protected CurrencyRepositoryInterface $interface
    ) {
    }

    public function execute(array $data): Currency
    {
        return DB::transaction(function () use ($data) {
            // Create the currency
            $newData = $this->interface->create($data);         
            
            return $newData->fresh();
        });
    }
}