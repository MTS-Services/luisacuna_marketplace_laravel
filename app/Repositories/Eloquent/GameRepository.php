<?php 

namespace App\Repositories\Eloquent;

use App\Repositories\Contracts\GameRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\Game;

class GameRepository implements GameRepositoryInterface {

    public function __construct(public Game $model) {
        $this->model = $model;
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