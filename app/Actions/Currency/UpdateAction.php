<?php

namespace App\Actions\Currency;

use App\Models\Currency;
use App\Repositories\Contracts\CurrencyRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UpdateAction
{
    public function __construct(
        protected CurrencyRepositoryInterface $currencyInterface
    ) {}

    public function execute(int $currencyId, array $data): Currency
    {
        return DB::transaction(function () use ($currencyId, $data) {

            // Fetch Currency
           $currency = $this->currencyInterface->find($currencyId);

            if (!$currency) {
                Log::error('Currency not found', ['currency_id' => $currencyId]);
                throw new \Exception('Currency not found');
            }

            $oldData =$currency->getAttributes();
            
            // Update Currency
            $updated = $this->currencyInterface->update($currencyId, $data);

            if (!$updated) {
                Log::error('Failed to update Currency', ['currency_id' => $currencyId]);
                throw new \Exception('Failed to update Currency');
            }

            // Refresh model
           $currency =$currency->fresh();

            // Detect changes
            $changes = [];
            foreach ($currency->getAttributes() as $key => $value) {
                if (isset($oldData[$key]) && $oldData[$key] != $value) {
                    $changes[$key] = [
                        'old' => $oldData[$key],
                        'new' => $value
                    ];
                }
            }


            return$currency;
        });
    }
}
