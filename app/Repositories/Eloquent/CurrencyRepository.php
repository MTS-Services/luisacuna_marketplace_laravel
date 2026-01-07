<?php

namespace App\Repositories\Eloquent;

use App\Models\Currency;
use App\Models\ExchangeRate;
use App\Models\ExchangeRateHistory;
use App\Repositories\Contracts\CurrencyRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CurrencyRepository implements CurrencyRepositoryInterface
{
    public function __construct(
        protected Currency $model,
        protected ExchangeRate $exchangeRateModel,
        protected ExchangeRateHistory $exchangeRateHistoryModel,
    ) {}


    /* ================== ================== ==================
    *                      Find Methods
    * ================== ================== ================== */

    public function all(string $sortField = 'created_at', $order = 'desc'): Collection
    {
        $query = $this->model->query();
        return $query->orderBy($sortField, $order)->get();
    }

    public function find($column_value, string $column_name = 'id',  bool $trashed = false): ?Currency
    {
        $model = $this->model;
        if ($trashed) {
            $model = $model->withTrashed();
        }
        return $model->where($column_name, $column_value)->first();
    }

    public function findTrashed($column_value, string $column_name = 'id'): ?Currency
    {
        $model = $this->model->onlyTrashed();
        return $model->where($column_name, $column_value)->first();
    }



    public function paginate(int $perPage = 15, array $filters = []): LengthAwarePaginator
    {
        $search = $filters['search'] ?? null;
        $sortField = $filters['sort_field'] ?? 'created_at';
        $sortDirection = $filters['sort_direction'] ?? 'desc';

        if ($search) {
            // Scout Search
            return Currency::search($search)
                ->query(fn($query) => $query->filter($filters)->orderBy($sortField, $sortDirection))
                ->paginate($perPage);
        }

        // Normal Eloquent Query
        return $this->model->query()
            ->filter($filters)
            ->orderBy($sortField, $sortDirection)
            ->paginate($perPage);
    }

    /**
     * Paginate only trashed records with optional search.
     */
    public function trashPaginate(int $perPage = 15, array $filters = []): LengthAwarePaginator
    {
        $search = $filters['search'] ?? null;
        $sortField = $filters['sort_field'] ?? 'deleted_at';
        $sortDirection = $filters['sort_direction'] ?? 'desc';

        if ($search) {
            // 👇 Manually filter trashed + search
            return Currency::search($search)
                ->onlyTrashed()
                ->query(fn($query) => $query->filter($filters)->orderBy($sortField, $sortDirection))
                ->paginate($perPage);
        }

        return $this->model->onlyTrashed()
            ->filter($filters)
            ->orderBy($sortField, $sortDirection)
            ->paginate($perPage);
    }

    public function exists(int $id): bool
    {
        return $this->model->where('id', $id)->exists();
    }

    public function count(array $filters = []): int
    {
        $query = $this->model->query();

        if (!empty($filters)) {
            $query->filter($filters);
        }

        return $query->count();
    }

    public function search(string $query, string $sortField = 'created_at', $order = 'desc'): Collection
    {
        return $this->model->search($query)->orderBy($sortField, $order)->get();
    }


    /* ================== ================== ==================
    *                    Data Modification Methods
    * ================== ================== ================== */

    public function create(array $data): Currency
    {
        $currency =  $this->model->create($data);

        if($currency){
            Log::info("Currency Translations Created", [
                'currency_id' => $currency->id,
                'name' => $currency->name
            ]);
            $currency = $currency->fresh();
             $currency->dispatchTranslation(
                defaultLanguageLocale: 'en',
                targetLanguageIds: null
            );
        }
        
        $defaultCurrency = $this->getDefaultCurrency();

        if ($defaultCurrency) {
            $this->exchangeRateModel->create([
                'base_currency' => $defaultCurrency->id,
                'target_currency' => $currency->id,
                'rate' => $currency->exchange_rate, 
                'last_updated_at' => now(),
                'created_by' => $data['created_by'] ?? null,
            ]);
        }

        return $currency;
    }

    public function update(int $id, array $data): bool
    {
        return DB::transaction(function () use ($id, $data) {


            $findData = $this->find($id);
           
            if (!$findData) {
                return false;
            }
            
            $nameChanged = $findData['name'] != $data['name']; 

            // Check if exchange_rate is being updated
            if (isset($data['exchange_rate']) && $data['exchange_rate'] != $findData->exchange_rate) {
                $defaultCurrency = $this->getDefaultCurrency();
                
                // Store old exchange rate in history
                $this->exchangeRateHistoryModel->create([
                    'base_currency' => $defaultCurrency ? $defaultCurrency->id : null,
                    'target_currency' => $findData->id,
                    'rate' => $findData->exchange_rate,
                    'last_updated_at' => $findData->updated_at ?? $findData->created_at,
                    'created_by' => $data['updated_by'] ?? null,
                ]);

                // Update the exchange rate table
                if ($defaultCurrency) {
                    $this->exchangeRateModel->updateOrCreate(
                        [
                            'base_currency' => $defaultCurrency->id,
                            'target_currency' => $findData->id,
                        ],
                        [
                            'rate' => $data['exchange_rate'],
                            'last_updated_at' => now(),
                            'updated_by' => $data['updated_by'] ?? null,
                        ]
                    );
                }
            }

          $updated =   $findData->update($data);
            if($nameChanged){
                $newData = $findData->fresh();
                Log::info("Currency Translations Updated", [
                    'currency_id' => $newData->id,
                    'name' => $newData->name
                ]);
                $newData->dispatchTranslation(
                    defaultLanguageLocale: 'en',
                    targetLanguageIds: null
                );
            }
            
            return $updated ;
        });
    }

    public function delete(int $id, int $actionerId): bool
    {
        $findData = $this->find($id);

        if (!$findData) {
            return false;
        }
        $findData->update(['deleted_by' => $actionerId]);

        return $findData->delete();
    }

    public function forceDelete(int $id): bool
    {
        $findData = $this->findTrashed($id);

        if (!$findData) {
            return false;
        }

        return $findData->forceDelete();
    }

    public function restore(int $id, int $actionerId): bool
    {
        $findData = $this->findTrashed($id);

        if (!$findData) {
            return false;
        }
        $findData->update(['restored_by' => $actionerId, 'restored_at' => now()]);

        return $findData->restore();
    }

    public function bulkDelete(array $ids, int $actionerId): int
    {
        return DB::transaction(function () use ($ids, $actionerId) {
            $this->model->whereIn('id', $ids)->update(['deleted_by' => $actionerId]);
            return $this->model->whereIn('id', $ids)->delete();
        });
    }

    public function bulkUpdateStatus(array $ids, string $status, int $actionerId): int
    {
        return $this->model->withTrashed()->whereIn('id', $ids)->update(['status' => $status, 'updated_by' => $actionerId]);
    }
    
    public function bulkRestore(array $ids, int $actionerId): int
    {
        return DB::transaction(function () use ($ids, $actionerId) {
            $this->model->onlyTrashed()->whereIn('id', $ids)->update(['restored_by' => $actionerId, 'restored_at' => now()]);
            return $this->model->onlyTrashed()->whereIn('id', $ids)->restore();
        });
    }
    
    public function bulkForceDelete(array $ids): int
    {
        return $this->model->onlyTrashed()->whereIn('id', $ids)->forceDelete();
    }

    /* ================== ================== ==================
    *                  Accessor Methods (Optional)
    * ================== ================== ================== */

    public function getActive(string $sortField = 'created_at', $order = 'desc'): Collection
    {
        return $this->model->active()->orderBy($sortField, $order)->get();
    }

    public function getInactive(string $sortField = 'created_at', $order = 'desc'): Collection
    {
        return $this->model->inactive()->orderBy($sortField, $order)->get();
    }

    /**
     * Get the current default currency
     */
    public function getDefaultCurrency(): ?Currency
    {
        return $this->model->where('is_default', true)->first();
    }

    
    /**
     * Set a currency as default and remove default from others
     */
    public function setAsDefault(int $id, int $actionerId): bool
    {
        return DB::transaction(function () use ($id, $actionerId) {
            // Remove default from all currencies
            $this->model->where('is_default', true)->update([
                'is_default' => false,
                'updated_by' => $actionerId
            ]);
            
            // Find the currency to set as default
            $currency = $this->find($id);
            
            if (!$currency) {
                throw new \Exception('Currency not found');
            }
            
            // Set as default
            return $currency->update([
                'is_default' => true,
                'updated_by' => $actionerId
            ]);
        });
    }
}