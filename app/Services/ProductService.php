<?php


namespace App\Services;

use App\Models\Game;
use App\Models\Product;
use App\Enums\ActiveInactiveEnum;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
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

    public function getPaginatedData(int $perPage = 15, array $filters = []): LengthAwarePaginator
    {

        $search = $filters['search'] ?? null;
        $sortField = $filters['sort_field'] ?? 'created_at';
        $sortDirection = $filters['sort_direction'] ?? 'desc';

        if ($search) {
            // Scout Search
            return Game::search($search)
                ->query(fn($query) => $query->filter($filters)->orderBy($sortField, $sortDirection))
                ->paginate($perPage);
        }
        return $this->model->query()
            ->filter($filters)
            ->orderBy($sortField, $sortDirection)
            ->with(['productTranslations' => function ($query) {
                $query->where('language_id', get_language_id());
            }])
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

    /* ================== ================== ==================
    *                   Action Executions
    * ================== ================== ================== */

    public function createData(array $data): Product
    {
        return DB::transaction(function () use ($data) {

            $dynamic_data = $data['fields'] ?? [];
            $delivery_method = $data['deliveryMethod'] ?? null;
            $data['delivery_method'] = $delivery_method;
            unset($data['fields']);
            unset($data['deliveryMethod']);
            





           

            $record = $this->model->create($data);

            

            if (!empty($dynamic_data)) {
                $configs = [];


                foreach ($dynamic_data as $index => $datas) {
                    $configs[] = [
                        'game_config_id' => $index,
                        'value' => $datas['value'],
                        'category_id' => $record->category_id,
                    ];
                }


                // $configs[] = [
                //     'game_config_id' => explode('|', $delivery_method)[0],
                //     'value' => explode('|', $delivery_method)[1],
                //     'category_id' => $record->category_id,
                // ];

                $record->product_configs()->createMany($configs);
            }

            if($record){
                $refresh = $record->fresh();

                Log::info("Product Translations Created", [
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
        if (!$product) return false;
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
