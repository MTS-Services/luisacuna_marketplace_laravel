<?php 

namespace App\Repositories\Eloquent;

use App\Enums\GameCategoryStatus;
use App\Models\GameCategory;
use App\Repositories\Contracts\GameCategoryRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class GameCategoryRepository implements GameCategoryRepositoryInterface
{
    public function __construct(protected GameCategory $model)    {
        
    }

    public function all(): Collection
    {
      return $this->model->all();
    }

    public function create(array $data): GameCategory 
    {
        return $this->model->create($data);
    }
    

    public function update( $id, array $data): bool
    {
        return $this->model->findOrFail($id)->update($data);
    }

    public function deleteCategory($id, bool $force = false): bool
    {
        if(!$force){
    
            return $this->model->findOrFail($id)->delete();


        }
       
        return $this->model->withTrashed()->findOrFail($id)->forceDelete();
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

    public function restoreDelete($id): bool
    {
        return $this->model->withTrashed()->findOrFail($id)->restore();
    }

    public function bulkDeleteCategories(array $ids, bool $forceDelete = false): bool
    {
       if(! $forceDelete)  return $this->model->whereIn('id', $ids)->delete();

       return $this->model->withTrashed()->whereIn('id', $ids)->forceDelete();
    }

    public function BulkCategoryRestore(array $ids): bool
    {
        return $this->model->withTrashed()->whereIn('id', $ids)->restore();
    }
    public function bulkUpdateStatus(array $ids, GameCategoryStatus $status):bool
    {
        return $this->model->whereIn('id', $ids)->update(['status' => $status]);
    }

    public function findOrFail($id): GameCategory
    {
        return $this->model->findOrFail($id);
    }
}