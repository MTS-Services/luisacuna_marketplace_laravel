<?php

namespace App\Services;

use App\Models\GameConfig;
use App\Models\Product;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProductService
{
    public function __construct(protected Product $model) {}

    public function getAllDatas($sortField = 'created_at', $order = 'desc'): Collection
    {
        return $this->model->all($sortField, $order);
    }

    public function findData($column_value, string $column_name = 'id')
    {
        return $this->model->where($column_name, $column_value)->first();
    }

    // public function getPaginatedData(int $perPage = 15, array $filters = []): LengthAwarePaginator
    // {

    //     $search = $filters['search'] ?? null;
    //     $sortField = $filters['sort_field'] ?? 'created_at';
    //     $sortDirection = $filters['sort_direction'] ?? 'desc';

    //     if ($search) {
    //         // Scout Search
    //         return Product::search($search)
    //             ->query(
    //                 fn($query) => $query
    //                     ->with(['game', 'platform', 'product_configs'])
    //                     ->filter($filters)
    //                     ->orderBy($sortField, $sortDirection)
    //             )
    //             ->paginate($perPage);
    //     }
    //     return $this->model->query()
    //         ->filter($filters)
    //         ->orderBy($sortField, $sortDirection)
    //         ->paginate($perPage);
    // }

    public function getPaginatedData(int $perPage = 15, array $filters = []): LengthAwarePaginator
    {
        $search = $filters['search'] ?? null;
        $sortField = $filters['sort_field'] ?? 'created_at';
        $sortDirection = $filters['sort_direction'] ?? 'desc';

        if ($search) {
            // Scout Search with online filter
            return Product::search($search)
                ->query(
                    fn ($query) => $query
                        ->with(['game', 'platform', 'product_configs', 'user'])
                        ->filter($filters)
                        ->when(isset($filters['online_only']) && $filters['online_only'], function ($q) {
                            $q->whereHas('user', function ($query) {
                                $query->where('last_seen_at', '>=', now()->subMinutes(1));
                            });
                        })
                        ->orderBy($sortField, $sortDirection)
                )
                ->paginate($perPage);
        }

        // Normal query with online filter
        return $this->model->query()
            ->with(['game', 'platform', 'product_configs', 'user'])
            ->filter($filters)
            ->when(isset($filters['online_only']) && $filters['online_only'], function ($q) {
                $q->whereHas('user', function ($query) {
                    $query->where('last_seen_at', '>=', now()->subMinutes(5));
                });
            })
            ->orderBy($sortField, $sortDirection)
            ->paginate($perPage);
    }

    public function getTrashedPaginatedData(int $perPage = 15, array $filters = []): LengthAwarePaginator
    {
        return $this->model->trashPaginate($perPage, $filters);
    }

    public function searchData(string $query, $sortField = 'created_at', $order = 'desc'): Collection
    {
        return Collection::empty();
    }

    public function dataExists(int $id): bool
    {
        return $this->model->exists($id);
    }

    public function getDataCount(array $filters = []): int
    {
        return $this->model->count($filters);
    }

    // public function getSellers(int $perPage = 15, array $filters = [])
    // {
    //     return $this->model->query()
    //         ->with(['user', 'game', 'platform'])

    //         // Unique Seller Logic: Compatibility with MySQL Strict Mode
    //         ->whereIn('products.id', function ($sub) {
    //             $sub->selectRaw('MAX(id)')
    //                 ->from('products')
    //                 ->groupBy('user_id');
    //         })

    //         // Apply our scopeFilter
    //         ->filter($filters)

    //         // Default Sort (only if not sorting by positive reviews)
    //         ->when(!isset($filters['positive_reviews']), function ($q) use ($filters) {
    //             $q->orderBy($filters['sort_field'] ?? 'created_at', $filters['sort_direction'] ?? 'desc');
    //         })

    //         ->paginate($perPage);
    // }

    public function getSellers(int $perPage = 15, $filters = [])
    {
        $filters = is_array($filters) ? $filters : [];

        return $this->model->query()
            ->with(['user', 'game', 'platform'])
            ->whereIn('products.id', function ($sub) {
                $sub->selectRaw('MAX(id)')
                    ->from('products')
                    ->groupBy('user_id');
            })
            // Online filter
            ->when(isset($filters['online_only']) && $filters['online_only'], function ($q) {
                $q->whereHas('user', function ($query) {
                    $query->where('last_seen_at', '>=', now()->subMinutes(1));
                });
            })
            ->filter($filters)
            ->when(! isset($filters['positive_reviews']), function ($q) use ($filters) {
                $q->orderBy(
                    $filters['sort_field'] ?? 'created_at',
                    $filters['sort_direction'] ?? 'desc'
                );
            })
            ->paginate($perPage);
    }

    /* ================== ================== ==================
    *                   Action Executions
    * ================== ================== ================== */

    public function createData(array $data): Product
    {
        return DB::transaction(function () use ($data) {
            $dynamic_data = $data['fields'] ?? [];
            $delivery_method = $data['deliveryMethod'] ?? null;
            $data['delivery_method'] = $delivery_method;
            unset($data['fields'], $data['deliveryMethod']);
            $record = $this->model->create($data);

            $this->storeProductConfigs($record, $dynamic_data);

            if ($record) {
                $refresh = $record->fresh();

                Log::info('Product Translations Created', [
                    'product_id' => $refresh->id,
                    'description' => $refresh->description,
                    'name' => $refresh->name,
                    'quantity' => $refresh->quantity,
                ]);

                $refresh->dispatchTranslation(
                    defaultLanguageLocale: app()->getLocale() ?? 'en',
                    forceTranslation: true,
                    targetLanguageIds: null
                );
            }

            return $record;
        });
    }

    /**
     * Store product config values in product_configs for the given product.
     * Only stores configs that are valid field configs (not delivery) for the product's game+category.
     */
    protected function storeProductConfigs(Product $product, array $fields): void
    {
        if (empty($fields) || $product->game_id === null || $product->category_id === null) {
            return;
        }

        $gameConfigIds = array_keys($fields);
        $gameConfigs = GameConfig::forGame($product->game_id)
            ->forCategory($product->category_id)
            ->fieldsOnly()
            ->whereIn('id', $gameConfigIds)
            ->ordered()
            ->get()
            ->keyBy('id');

        $configs = [];
        foreach ($gameConfigs as $gameConfigId => $gameConfig) {
            $raw = $fields[$gameConfigId]['value'] ?? null;
            $value = $raw === null ? null : (is_scalar($raw) ? (string) $raw : json_encode($raw));
            $configs[] = [
                'game_config_id' => $gameConfigId,
                'category_id' => $product->category_id,
                'sort_order' => $gameConfig->sort_order ?? 0,
                'value' => $value,
            ];
        }

        if (! empty($configs)) {
            $product->product_configs()->createMany($configs);
        }
    }

    public function updateData(int $id, array $data): Product
    {
        return DB::transaction(function () use ($id, $data) {
            $product = $this->model->findOrFail($id);
            $product->update($data);

            return $product->fresh();
        });
    }

    public function updateStatus(int $id, string $status): Product
    {
        return DB::transaction(function () use ($id, $status) {
            $product = $this->model->findOrFail($id);
            $product->update(['status' => $status]);

            return $product->fresh();
        });
    }

    public function deleteProduct(int $id)
    {
        $product = Product::find($id);
        if (! $product) {
            return false;
        }
        $product->delete();

        return true;
    }

    public function restoreData(int $id, ?int $actionerId = null): bool
    {
        if ($actionerId == null) {
            $actionerId = admin()->id;
        }

        return true;
        //  return $this->restoreAction->execute($id, $actionerId);
    }

    public function bulkRestoreData(array $ids, ?int $actionerId = null): int
    {
        if ($actionerId == null) {
            $actionerId = admin()->id;
        }

        return 0;
        //  return $this->bulkAction->execute(ids: $ids, action: 'restore', status: null, actionerId: $actionerId);
    }

    public function bulkForceDeleteData(array $ids, ?int $actionerId = null): int
    {
        if ($actionerId == null) {
            $actionerId = admin()->id;
        }

        return 0;
        //  return $this->bulkAction->execute(ids: $ids, action: 'forceDelete', status: null, actionerId: $actionerId);
    }

    public function bulkDeleteData(array $ids, ?int $actionerId = null): int
    {
        if ($actionerId == null) {
            $actionerId = admin()->id;
        }

        return 0;
        //  return $this->bulkAction->execute(ids: $ids, action: 'delete', status: null, actionerId: $actionerId);
    }

    /* ================== ================== ==================
    *                   Accessors (optionals)
    * ================== ================== ================== */

    public function getActiveData($sortField = 'created_at', $order = 'desc'): Collection
    {
        return $this->model->getActive($sortField, $order);
    }

    public function getInactiveData($sortField = 'created_at', $order = 'desc'): Collection
    {
        return $this->model->getInactive($sortField, $order);
    }
}
