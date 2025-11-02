<?php 

namespace App\Repositories\Eloquent;

use App\Enums\GameCategoryStatus;
use App\Models\GameCategory;
use App\Repositories\Contracts\GameCategoryRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class GameCategoryRepository implements GameCategoryRepositoryInterface
{
    public function __construct(protected GameCategory $model)    {
        
    }

    

    public function all(): Collection
    {
      return $this->model->all();
    }

    public function find(int $id): ?GameCategory
    {
        return $this->model->find($id);
    }

    public function findTrashed($id): ?GameCategory
    {
        return $this->model->onlyTrashed()->find($id);
    }

    public function create(array $data): GameCategory 
    {
        return $this->model->create($data);
    }
    

    public function update( $id, array $data): bool
    {
        return $this->model->findOrFail($id)->update($data);
    }

    public function delete($id, int $actionerId): bool
    {

        $this->find($id)->update(['deleter_id' => $actionerId]);

        return $this->find($id)->delete();
    }

    public function forceDelete($id): bool
    {
        return $this->model->onlyTrashed()->findOrFail($id)->forceDelete();
    }
    public function paginate(int $perPage = 15, array $filters = [], ?array $queries = null): LengthAwarePaginator
    {
     $query = $this->model->query();

        // Apply filters
        if (!empty($filters)) {
            $query->filter($filters);
        }

        // Apply sorting
        $sortField = $filters['sort_field'] ?? 'created_at';
        $sortDirection = $filters['sort_direction'] ?? 'desc';
        $query->orderBy($sortField, $sortDirection);

        return $query->paginate($perPage);
    }

    public function paginateOnlyTrashed(int $perPage = 15, array $filters = [], ?array $queries = null): LengthAwarePaginator
    {
        $query = $this->model->onlyTrashed();

        // Apply filters
        if (!empty($filters)) {
            $query->filter($filters);
        }

        // Apply sorting
        $sortField = $filters['sort_field'] ?? 'created_at';
        $sortDirection = $filters['sort_direction'] ?? 'desc';
        $query->orderBy($sortField, $sortDirection);

        return $query->paginate($perPage);
    }

    public function restore($id, $actionerId): bool
    {
        $this->findTrashed($id)->update(['restorer_id' => $actionerId, 'deleter_id' => null]);
        return $this->findTrashed($id)->restore();
    }

    public function bulkDelete(array $ids , int $actionerId): int
    {

       
        $this->model->whereIn('id', $ids)->update(['deleter_id' => $actionerId]);

        return $this->model->whereIn('id', $ids)->delete();     
    }
    public function bulkForceDelete(array $ids): int
    {
        return $this->model->onlyTrashed()->whereIn('id', $ids)->forceDelete();
    }
    public function bulkRestore(array $ids, int $actionerId): int
    {

          return DB::transaction(function () use ($ids, $actionerId) {
              $this->model->onlyTrashed()->whereIn('id', $ids)->update(['restorer_id' => $actionerId, 'deleter_id' => null]);

              return $this->model->onlyTrashed()->whereIn('id', $ids)->restore();
        });

      
    }
    public function bulkUpdateStatus(array $ids, ?string $status, int $actionerId):int
    {
        return $this->model->whereIn('id', $ids)->update(['status' => $status]);
    }



    public function findOrFail($id): GameCategory
    {
        return $this->model->findOrFail($id);
    }
}