<?php

namespace App\Actions\Currency;

use App\Repositories\Contracts\CurrencyRepositoryInterface;
use Illuminate\Support\Facades\Log;

class SetDefaultCurrencyAction
{
    public function __construct(
        protected CurrencyRepositoryInterface $repository
    ) {}

    /**
     * Execute the action to set a currency as default
     *
     * @param int $id Currency ID to set as default
     * @param int $actionerId ID of the user performing the action
     * @return array ['success' => bool, 'message' => string, 'data' => ?Currency]
     */
    public function execute(int $id, int $actionerId): array
    {
        try {
            // Check if currency exists
            if (!$this->repository->exists($id)) {
                return [
                    'success' => false,
                    'message' => 'Currency not found',
                    'data' => null
                ];
            }

            // Get the currency to set as default
            $currency = $this->repository->find($id);

            // Check if already default
            if ($currency->is_default) {
                return [
                    'success' => false,
                    'message' => 'This currency is already set as default',
                    'data' => $currency
                ];
            }

            // Get current default currency for logging
            $currentDefault = $this->repository->getDefaultCurrency();

            // Set as default
            $result = $this->repository->setAsDefault($id, $actionerId);

            if ($result) {
                Log::info('Default currency changed', [
                    'previous_default' => $currentDefault ? $currentDefault->code : 'None',
                    'new_default' => $currency->code,
                    'actioner_id' => $actionerId
                ]);

                return [
                    'success' => true,
                    'message' => 'Default currency updated successfully',
                    'data' => $currency->fresh()
                ];
            }

            return [
                'success' => false,
                'message' => 'Failed to update default currency',
                'data' => null
            ];

        } catch (\Exception $e) {
            Log::error('Failed to set default currency', [
                'currency_id' => $id,
                'actioner_id' => $actionerId,
                'error' => $e->getMessage()
            ]);

            return [
                'success' => false,
                'message' => 'An error occurred: ' . $e->getMessage(),
                'data' => null
            ];
        }
    }
}