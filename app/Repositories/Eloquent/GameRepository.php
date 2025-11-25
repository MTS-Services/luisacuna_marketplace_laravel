<?php

namespace App\Repositories\Eloquent;

use App\Models\Game;
use App\Repositories\Contracts\GameRepositoryInterface;
use App\Repositories\Contracts\PlatformRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use App\Models\GamePlatform;

class GameRepository implements GameRepositoryInterface
{
    public function __construct(
        protected Game $model,
        protected PlatformRepositoryInterface $platformInterface,
        protected GamePlatform $gamePlatforms,
    ) {}


    /* ================== ================== ==================
     *                      Find Methods
     * ================== ================== ================== */

    public function all(string $sortField = 'created_at', $order = 'desc'): Collection
    {
        $query = $this->model->query();
        return $query->orderBy($sortField, $order)->get();
    }

    public function find($column_value, string $column_name = 'id', bool $trashed = false): ?Game
    {
        $model = $this->model;
        if ($trashed) {
            $model = $model->withTrashed();
        }
        return $model->where($column_name, $column_value)->first();
    }

    public function findTrashed($column_value, string $column_name = 'id'): ?Game
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
            return Game::search($search)
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
            return Game::search($search)
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



    public function getGamesByCategory($fieldValue, $fieldName = 'slug'): Collection
    {
        return $this->model->with('categories')->whereHas('categories', function ($query) use ($fieldValue, $fieldName) {
            $query->where($fieldName, $fieldValue);
        })->get();
    }

    public function getGamesByCategoryAndTag($categorySlug, $tagSlug): Collection
    {
        return $this->model
            ->whereHas('category', function ($query) use ($categorySlug) {
                $query->where('slug', $categorySlug);
            })
            ->whereHas('tags', function ($query) use ($tagSlug) {
                $query->where('slug', $tagSlug);
            })
            ->get();
    }
    // Repository
    public function searchGamesByCategory($categorySlug, $searchTerm): Collection
    {
        return $this->model
            ->with('categories')
            ->whereHas('categories', function ($query) use ($categorySlug) {
                $query->where('slug', $categorySlug);
            })
            ->where(function ($query) use ($searchTerm) {
                $query->where('name', 'like', '%' . $searchTerm . '%')
                    ->orWhere('description', 'like', '%' . $searchTerm . '%');
            })
            ->get();
    }

    /* ================== ================== ==================
     *                    Data Modification Methods
     * ================== ================== ================== */

    public function create(array $data): Game
    {
        $game = $this->model->create($data);
        $game->platforms()->sync($data['platforms']);
        $game->servers()->sync($data['servers']);
        $game->categories()->sync($data['categories']);
        $game->tags()->sync($data['tags']);
        $game->types()->sync($data['types']);
        $game->rarities()->sync($data['rarities']);

        return $game;
    }

    public function update(int $id, array $data): bool
    {
        $findData = $this->find($id);

        if (!$findData) {
            return false;
        }

        return $findData->update($data);
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
            $this->model->whereIn('id', $ids)->update(['deleter_id' => $actionerId]);
            return $this->model->whereIn('id', $ids)->delete();
        });
    }

    public function bulkUpdateStatus(array $ids, string $status, int $actionerId): int
    {
        return $this->model->withTrashed()->whereIn('id', $ids)->update(['status' => $status, 'updater_id' => $actionerId]);
    }

    public function bulkRestore(array $ids, int $actionerId): int
    {
        return DB::transaction(function () use ($ids, $actionerId) {
            $this->model->onlyTrashed()->whereIn('id', $ids)->update(['restorer_id' => $actionerId, 'restored_at' => now()]);
            return $this->model->onlyTrashed()->whereIn('id', $ids)->restore();
        });
    }
    public function bulkForceDelete(array $ids): int //
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

    public function getUpcoming(string $sortField = 'created_at', $order = 'desc'): Collection
    {
        return $this->model->upcoming()->orderBy($sortField, $order)->get();
    }
}
