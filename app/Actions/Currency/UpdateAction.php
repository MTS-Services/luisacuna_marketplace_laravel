<?php

namespace App\Actions\Currency;

use App\Models\Currency;
use App\Repositories\Contracts\CurrencyRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UpdateAction
{
    public function __construct(
        protected CurrencyRepositoryInterface $interface
    ) {}

    public function execute(int $id, array $data): Currency
    {
        return DB::transaction(function () use ($id, $data) {

            // Fetch Currency
            $findData = $this->interface->find($id);

            if (!$findData) {
                Log::error('Currency not found', ['currency_id' => $id]);
                throw new \Exception('Currency not found');
            }

            $oldData = $findData->getAttributes();

            // Update Currency
            $updated = $this->interface->update($id, $data);

            if (!$updated) {
                Log::error('Failed to update Currency', ['currency_id' => $id]);
                throw new \Exception('Failed to update Currency');
            }

            // Refresh model
            $findData = $findData->fresh();

            // Detect changes
            $changes = [];
            foreach ($findData->getAttributes() as $key => $value) {
                if (isset($oldData[$key]) && $oldData[$key] != $value) {
                    $changes[$key] = [
                        'old' => $oldData[$key],
                        'new' => $value
                    ];
                }
            }

            return $findData;
        });
    }
}
