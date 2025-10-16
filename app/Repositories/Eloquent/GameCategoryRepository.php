<?php 

namespace App\Repositories\Eloquent;

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
}