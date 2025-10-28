<?php

namespace App\Actions\Currency;

use App\Events\Currency\CurrencyCreated;
use App\Models\Currency;
use App\Repositories\Contracts\CurrencyRepositoryInterface;
use Illuminate\Support\Facades\DB;

class CreateAction
{
    public function __construct(
        protected CurrencyRepositoryInterface $currencyInterface
    ) {}


    public function execute(array $data): Currency
    {
        return DB::transaction(function () use ($data) {
            $currency = $this->currencyInterface->create($data);
            // Dispatch event
            // event(new CurrencyCreated($currency));
            return $currency->fresh();
        });
    }
}
