<?php

namespace App\Repositories\Eloquent;

use App\Enums\GameStatus;
use App\Repositories\Contracts\GameRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\Game;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Storage;

class GameRepository implements GameRepositoryInterface
{

    public function __construct(public Game $model)
    {

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

    public function OnlyTrashedPaginate(int $perPage = 15, array $filters = [], ?array $queries = null): LengthAwarePaginator
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
    public function deleteGame(array $ids, bool $forceDelete = false): bool
    {

        if ($forceDelete) {

            $games = $this->model->withTrashed()->whereIn('id', $ids)->get();

            foreach ($games as $game) {

                if ($game->logo) {

                    Storage::disk('public')->delete($game->logo);
                }

                if ($game->banner) {

                    Storage::disk('public')->delete($game->banner);
                }

                if ($game->thumbnail) {

                    Storage::disk('public')->delete($game->thumbnail);
                }

                $game->forceDelete();
            }
        }


        return $this->model->whereIn('id', $ids)->delete();
    }


    public function bulkDeleteGames($ids, bool $forceDelete = false): bool
    {
        if (! $forceDelete)  return $this->model->whereIn('id', $ids)->delete();

        $games = $this->model->whereIn('id', $ids)->get();

        foreach ($games as $game) {

            if ($game->logo) {

                Storage::disk('public')->delete($game->logo);
            }

            if ($game->banner) {

                Storage::disk('public')->delete($game->banner);
            }

            if ($game->thumbnail) {

                Storage::disk('public')->delete($game->thumbnail);
            }

            $game->forceDelete();
        }

        return true;
    }

    public function bulkRestoreGame($ids): bool
    {
        return $this->model->withTrashed()->whereIn('id', $ids)->restore();
    }

    public function restoreGame($id): bool
    {
        return $this->model->withTrashed()->findOrFail($id)->restore();
    }
    public function bulkUpdateStatus($ids, GameStatus $status): bool
    {
        return $this->model->whereIn('id', $ids)->update(['status' => $status]);
    }

    public function findOrFail($id): Game
    {
        return $this->model->findOrFail($id);
    }

    public function createGame(array $data): Game
    {

        return $this->model->create($data);
    }

    public function find($id): ?Game
    {
        return $this->model->find($id);
    }   

    public function updateGame($id, array $data): bool
    {
        $game = $this->findOrFail($id);
        
        return $game->update($data);
      
    }
}
