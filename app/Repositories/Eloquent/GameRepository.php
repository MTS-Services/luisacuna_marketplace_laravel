<?php

namespace App\Repositories\Eloquent;

use App\Enums\GameStatus;
use App\Models\Game;
use App\Repositories\Contracts\GameRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;


class GameRepository implements GameRepositoryInterface
{
    public function __construct(public Game $model)
    {
    }

    /* -----------------------------------------------------------------
     |  Basic Fetch Operations
     |------------------------------------------------------------------ */

    public function all(): Collection
    {
        return $this->model->all();
    }

    public function find($id): ?Game
    {
        return $this->model->find($id);
    }

    public function findTrashed($id): Game
    {
        return $this->model->onlyTrashed()->find($id);
    }

    /* -----------------------------------------------------------------
     |  Pagination & Filtering
     |------------------------------------------------------------------ */

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

    public function trashPaginate(int $perPage = 15, array $filters = [], ?array $queries = null): LengthAwarePaginator
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

    /* -----------------------------------------------------------------
     |  Create & Update Operations
     |------------------------------------------------------------------ */

    public function create(array $data): Game
    {
        return $this->model->create($data);
    }

    public function update($id, array $data): bool
    {
        $game = $this->find($id);
        return $game->update($data);
    }

    public function bulkUpdateStatus($ids, GameStatus $status, $actioner_id): int
    {
        return $this->model
            ->whereIn('id', $ids)
            ->update([
                'status' => $status,
                'updater_id' => $actioner_id,
            ]);
    }

    /* -----------------------------------------------------------------
     |  Soft Delete & Restore Operations
     |------------------------------------------------------------------ */

    public function delete($id, $actioner_id): bool
    {
        $game = $this->find($id);
        $game->update(['deleter_id' => $actioner_id]);
        return $game->delete();
    }

    public function bulkDelete($ids, $actioner_id): int
    {
        $this->model->whereIn('id', $ids)->update(['deleter_id' => $actioner_id]);
        return $this->model->whereIn('id', $ids)->delete();
    }

    public function bulkForceDelete($ids): int
    {
        return $this->model->onlyTrashed()->whereIn('id', $ids)->forceDelete();
    }
    public function restore($id, $actioner_id): bool
    {
        $game = $this->model->findTrashed($id);
        $game->update(['restorer_id' => $actioner_id]);
        return $game->restore();
    }

    public function bulkRestore($ids, $actioner_id): int
    {
        $this->model->onlyTrashed()->whereIn('id', $ids)->update(['restorer_id' => $actioner_id]);
        return $this->model->onlyTrashed()->whereIn('id', $ids)->restore();
    }
}
