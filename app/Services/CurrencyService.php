<?php

namespace App\Services;

use App\Actions\Currency\BulkAction;
use App\Actions\Currency\CreateAction;
use App\Actions\Currency\DeleteAction;
use App\Actions\Currency\RestoreAction;
use App\Actions\Currency\SetDefaultCurrencyAction;
use App\Actions\Currency\UpdateAction;
use App\Enums\CurrencyStatus;
use App\Models\Currency;
use App\Repositories\Contracts\CurrencyRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;

class CurrencyService
{
    public function __construct(
        protected CurrencyRepositoryInterface $interface,
        protected CreateAction $createAction,
        protected UpdateAction $updateAction,
        protected DeleteAction $deleteAction,
        protected RestoreAction $restoreAction,
        protected BulkAction $bulkAction,
        protected SetDefaultCurrencyAction $setDefaultAction,
        protected Currency $model
    ) {}

    /* ================== ================== ==================
    *                          Find Methods
    * ================== ================== ================== */

    public function getAllDatas($sortField = 'created_at', $order = 'desc'): Collection
    {
        return $this->interface->all($sortField, $order);
    }


    /**
     * Set a currency as default using action class
     */

    /**
     * Set a currency as default using action class
     */
    public function setDefaultCurrency(int $id, ?int $actionerId = null): array
    {
        if ($actionerId == null) {
            $actionerId = admin()->id;
        }
        return $this->setDefaultAction->execute($id, $actionerId);
    }
    /**
     * Check if currency exists
     */
    public function exists(int $id): bool
    {
        return $this->interface->exists($id);
    }


    public function findData($column_value, string $column_name = 'id'): ?Currency
    {
        return $this->interface->find($column_value, $column_name);
    }

    public function getPaginatedData(int $perPage = 15, array $filters = []): LengthAwarePaginator
    {
        return $this->interface->paginate($perPage, $filters);
    }

    public function getTrashedPaginatedData(int $perPage = 15, array $filters = []): LengthAwarePaginator
    {
        return $this->interface->trashPaginate($perPage, $filters);
    }

    public function searchData(string $query, $sortField = 'created_at', $order = 'desc'): Collection
    {
        return $this->interface->search($query, $sortField, $order);
    }

    public function dataExists(int $id): bool
    {
        return $this->interface->exists($id);
    }

    public function getDataCount(array $filters = []): int
    {
        return $this->interface->count($filters);
    }

    /* ================== ================== ==================
    *                   Action Executions
    * ================== ================== ================== */

    public function createData(array $data): Currency
    {
        return $this->createAction->execute($data);
    }

    public function updateData(int $id, array $data): Currency
    {
        return $this->updateAction->execute($id, $data);
    }

    public function deleteData(int $id, bool $forceDelete = false, ?int $actionerId = null): bool
    {
        if ($actionerId == null) {
            $actionerId = admin()->id;
        }
        return $this->deleteAction->execute($id, $forceDelete, $actionerId);
    }

    public function restoreData(int $id, ?int $actionerId = null): bool
    {
        if ($actionerId == null) {
            $actionerId = admin()->id;
        }
        return $this->restoreAction->execute($id, $actionerId);
    }

    public function updateStatusData(int $id, CurrencyStatus $status, ?int $actionerId = null): Currency
    {
        if ($actionerId == null) {
            $actionerId = admin()->id;
        }

        return $this->updateAction->execute($id, [
            'status' => $status->value,
            'updated_by' => $actionerId,
        ]);
    }
    public function bulkRestoreData(array $ids, ?int $actionerId = null): int
    {
        if ($actionerId == null) {
            $actionerId = admin()->id;
        }
        return $this->bulkAction->execute(ids: $ids, action: 'restore', status: null, actionerId: $actionerId);
    }

    public function bulkForceDeleteData(array $ids, ?int $actionerId = null): int
    {
        if ($actionerId == null) {
            $actionerId = admin()->id;
        }
        return $this->bulkAction->execute(ids: $ids, action: 'forceDelete', status: null, actionerId: $actionerId);
    }

    public function bulkDeleteData(array $ids, ?int $actionerId = null): int
    {
        if ($actionerId == null) {
            $actionerId = admin()->id;
        }
        return $this->bulkAction->execute(ids: $ids, action: 'delete', status: null, actionerId: $actionerId);
    }
    public function bulkUpdateStatus(array $ids, CurrencyStatus $status, ?int $actionerId = null): int
    {
        if ($actionerId == null) {
            $actionerId = admin()->id;
        }
        return $this->bulkAction->execute(ids: $ids, action: 'status', status: $status->value, actionerId: $actionerId);
    }

    /* ================== ================== ==================
    *                   Accessors (optionals)
    * ================== ================== ================== */

    /**
     * Get all active currencies
     */
    public function getActiveData(): Collection
    {
        return Cache::remember('active_currencies', 3600, function () {
            return $this->model::active()->orderBy('sort_order')->get();
        });
    }

    /**
     * Get default currency
     */
    public function getDefaultCurrency(): ?Currency
    {
        return Cache::remember('default_currency', 3600, function () {
            return $this->model::where('is_default', true)->first();
        });
    }

    /**
     * Get current user's selected currency or default
     */
    public function getCurrentCurrency(): Currency
    {
        $currencyCode = Session::get('currency');

        if ($currencyCode) {
            $currency = $this->model::where('code', $currencyCode)->first();
            if ($currency) {
                return $currency;
            }
        }

        // Fallback to default currency
        return $this->getDefaultCurrency() ?? $this->model::first();
    }

    /**
     * Get current currency code
     */
    public function getCurrentCurrencyCode(): string
    {
        return $this->getCurrentCurrency()->code;
    }

    /**
     * Get current currency symbol
     */
    public function getCurrentCurrencySymbol(): string
    {
        return Session::get('currency_symbol') ?? $this->getCurrentCurrency()->symbol;
    }

    /**
     * Convert amount from default currency to target currency
     * 
     * @param float $amount Amount in default currency
     * @param string|null $targetCurrencyCode Target currency code (null = current user currency)
     * @return float Converted amount
     */
    public function convertFromDefault(float $amount, ?string $targetCurrencyCode = null): float
    {
        $defaultCurrency = $this->getDefaultCurrency();

        if (!$targetCurrencyCode) {
            $targetCurrency = $this->getCurrentCurrency();
        } else {
            $targetCurrency = $this->model::where('code', $targetCurrencyCode)->first();
        }

        // If converting to default currency, return as-is
        if ($targetCurrency->code === $defaultCurrency->code) {
            return $amount;
        }

        // Convert: amount * target_exchange_rate
        $convertedAmount = $amount * $targetCurrency->exchange_rate;

        // Round to currency's decimal places
        return round($convertedAmount, $targetCurrency->decimal_places ?? 2);
    }

    /**
     * Convert amount from any currency to default currency
     * 
     * @param float $amount Amount in source currency
     * @param string $sourceCurrencyCode Source currency code
     * @return float Amount in default currency
     */
    public function convertToDefault(float $amount, string $sourceCurrencyCode): float
    {
        $defaultCurrency = $this->getDefaultCurrency();
        $sourceCurrency = $this->model::where('code', $sourceCurrencyCode)->first();

        // If already in default currency, return as-is
        if ($sourceCurrency->code === $defaultCurrency->code) {
            return $amount;
        }

        // Convert: amount / source_exchange_rate
        $defaultAmount = $amount / $sourceCurrency->exchange_rate;

        return round($defaultAmount, $defaultCurrency->decimal_places ?? 2);
    }

    /**
     * Convert amount between two currencies
     * 
     * @param float $amount
     * @param string $fromCurrency
     * @param string $toCurrency
     * @return float
     */
    public function convert(float $amount, string $fromCurrency, string $toCurrency): float
    {
        // First convert to default currency
        $defaultAmount = $this->convertToDefault($amount, $fromCurrency);

        // Then convert to target currency
        return $this->convertFromDefault($defaultAmount, $toCurrency);
    }

    /**
     * Format amount with currency symbol
     * 
     * @param float $amount
     * @param string|null $currencyCode
     * @return string
     */
    public function formatAmount(float $amount, ?string $currencyCode = null): string
    {
        if (!$currencyCode) {
            $currency = $this->getCurrentCurrency();
        } else {
            $currency = $this->model::where('code', $currencyCode)->first();
        }

        $decimalPlaces = $currency->decimal_places ?? 2;
        $formattedAmount = number_format($amount, $decimalPlaces);

        return $currency->symbol . $formattedAmount;
    }

    /**
     * Get currency data for order processing
     * Returns both default and current currency info
     */
    public function getCurrencyDataForOrder(): array
    {
        $defaultCurrency = $this->getDefaultCurrency();
        $currentCurrency = $this->getCurrentCurrency();

        return [
            'default_currency' => $defaultCurrency->code,
            'default_symbol' => $defaultCurrency->symbol,
            'current_currency' => $currentCurrency->code,
            'current_symbol' => $currentCurrency->symbol,
            'exchange_rate' => $currentCurrency->exchange_rate,
            'is_converted' => $currentCurrency->code !== $defaultCurrency->code,
        ];
    }

    /**
     * Clear currency cache (call this when currencies are updated)
     */
    public function clearCache(): void
    {
        Cache::forget('active_currencies');
        Cache::forget('default_currency');
    }
}
