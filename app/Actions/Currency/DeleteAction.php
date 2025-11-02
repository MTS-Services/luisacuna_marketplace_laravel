<?php

namespace App\Actions\Currency;


use App\Repositories\Contracts\CurrencyRepositoryInterface;
use Illuminate\Support\Facades\DB;

class DeleteAction
{
    public function __construct(
        protected CurrencyRepositoryInterface $interface
    ) {}

    public function execute(int $id, bool $forceDelete = false, int $actionerId): bool
    {
        return DB::transaction(function () use ($id, $forceDelete, $actionerId) {
            $currency = null;

            if ($forceDelete) {
                $currency = $this->interface->findTrashed($id);
            } else {
                $currency = $this->interface->find($id);
            }

            if (!$currency) {
                throw new \Exception('Currency not found');
            }

            // Dispatch event before deletion
            // event(new CurrencyDeleted($currency));

            if ($forceDelete) {
                return $this->interface->forceDelete($id);
            }
            return $this->interface->delete($id, $actionerId);
        });
    }
}
