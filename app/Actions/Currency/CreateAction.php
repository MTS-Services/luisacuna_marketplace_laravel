<?php

namespace App\Actions\Currency;

use App\Models\Currency;
use App\Repositories\Contracts\CurrencyRepositoryInterface;
use Illuminate\Support\Facades\DB;

class CreateAction
{
    public function __construct(
        protected CurrencyRepositoryInterface $interface
    ) {}


    public function execute(array $data): Currency
    {
        return DB::transaction(function () use ($data) {
            $findData = $this->interface->create($data);
            // Dispatch event
            // event(new CurrencyCreated($findData));
            return $findData->fresh();
        });
    }
}
