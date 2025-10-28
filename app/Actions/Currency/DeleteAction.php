<?php

namespace App\Actions\Currency;


use App\Repositories\Contracts\CurrencyRepositoryInterface;
use Illuminate\Support\Facades\DB;

class DeleteAction
{
    public function __construct(
        protected CurrencyRepositoryInterface $interface
    ) {}

    public function execute(int $currencyId, bool $forceDelete = false): bool
    {
        return DB::transaction(function () use ($currencyId, $forceDelete) {
            $currency = null;

            if ($forceDelete) {
                $currency = $this->interface->findTrashed($currencyId);
            } else {
                $currency = $this->interface->find($currencyId);
            }

            if (!$currency) {
                throw new \Exception('Currency not found');
            }

            // Dispatch event before deletion
            // event(new CurrencyDeleted($currency));

            if ($forceDelete) {
                return $this->interface->forceDelete($currencyId);
            }

            return $this->interface->delete($currencyId);
        });
    }

    public function restore(int $currencyId): bool
    {
        return $this->interface->restore($currencyId);
    }
}
