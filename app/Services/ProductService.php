<?php 


namespace App\Services;

use App\Models\Game;
use App\Models\Product;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class ProductService
{
    public function __construct(protected Product $model)
    {
        
    }

    
    public function getAllDatas($sortField = 'created_at', $order = 'desc'): Collection
    {
        return $this->model->all($sortField, $order);
    }

    public function findData($column_value, string $column_name = 'id'): ?Product
    {

       $model = $this->model;

      return $model->where($column_name, $column_value)->first();
    }

    public function getPaginatedData(int $perPage = 15, array $filters = []): LengthAwarePaginator
    {

        $search = $filters['search'] ?? null;
        $sortField = $filters['sort_field'] ?? 'created_at';
        $sortDirection = $filters['sort_direction'] ?? 'desc';

        if($search) {
            // Scout Search
            return Game::search($search)
                ->query(fn($query) => $query->filter($filters)->orderBy($sortField, $sortDirection))
                ->paginate($perPage);
        }
        return $this->model->query()
            ->filter($filters)
            ->orderBy($sortField, $sortDirection)        
            ->paginate($perPage);
    }

    public function getTrashedPaginatedData(int $perPage = 15, array $filters = []): LengthAwarePaginator
    {
        return $this->model->trashPaginate($perPage, $filters);
    }

    public function searchData(string $query, $sortField = 'created_at', $order = 'desc'): Collection
    {
       // return $this->model->search($query, $sortField, $order);
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
        unset($data['fields']);
        unset($data['deliveryMethod']);

        $record = $this->model->create($data);

        if (!empty($dynamic_data)) {
            $configs = [];

          
            foreach ($dynamic_data as $index => $datas) {
               
                //Not need to assing product id because CreateMany automatically assign this according relations
               $configs[] = [
                   'game_config_id' => $index,
                   'value' => $datas['value'],
                   'category_id' => $record->category_id,
               ];
            }
            
            
            $configs[] = [
                'game_config_id' =>explode('|', $delivery_method)[0],
                'value' => explode('|', $delivery_method)[1],
                'category_id' => $record->category_id,
            ];

            $record->product_configs()->createMany($configs);
        }

        return $record;
    });
}

    public function updateData(int $id, array $data): Product
    {
      //  return $this->updateAction->execute($id, $data);
       return new Product();
    }

    public function deleteData(int $id, bool $forceDelete = false, ?int $actionerId = null): bool
    {
        if ($actionerId == null) {
            $actionerId = admin()->id;
        }

        return true;
       // return $this->deleteAction->execute($id, $forceDelete, $actionerId);
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