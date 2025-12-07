<?php

namespace App\Services;

use App\Enums\CategoryStatus;
use App\Enums\GameStatus;
use App\Models\Category;
use App\Models\Game;
use App\Models\GameCategory;
use App\Traits\FileManagementTrait;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class GameService
{
    use FileManagementTrait;
    public function __construct(
        protected Game $model,
        protected Category $category,
        protected GameCategory $gameCategory,
        protected ?int $adminId = null
    ) {
        $this->adminId ??= admin()?->id;
    }

    /* ================== Fetch Methods ================== */

    public function getAllDatas(array $filters = [], string $sortField = 'created_at', string $order = 'desc'): Collection
    {
        return $this->model->newQuery()
            ->filter($filters)
            ->orderBy($sortField, $order)
            ->get();
    }

    public function findData(mixed $value, string $column = 'id', bool $withTrashed = false): ?Game
    {
        $query = $this->model->newQuery();
        if ($withTrashed) {
            $query->withTrashed();
        }
        return $query->where($column, $value)->first();
    }

    public function paginateDatas(int $perPage = 15, array $filters = []): LengthAwarePaginator
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

    public function trashedPaginatedDatas(int $perPage = 15, array $filters = []): LengthAwarePaginator
    {
        $search = $filters['search'] ?? null;
        $sortField = $filters['sort_field'] ?? 'deleted_at';
        $sortDirection = $filters['sort_direction'] ?? 'desc';

        if ($search) {
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

    public function searchData(string $query, string $sortField = 'created_at', $order = 'desc'): Collection
    {
        return $this->model->search($query)->orderBy($sortField, $order)->get();
    }

    public function getGamesByCategory($fieldValue, $fieldName = 'slug'): Collection
    {
        return $this->model
            ->with(['categories', 'tags'])
            ->whereHas('categories', function ($query) use ($fieldValue, $fieldName) {
                $query->where($fieldName, $fieldValue);
            })
            ->get();
    }

    public function getGamesByCategoryAndTag($categorySlug, $tagSlug): Collection
    {
        return $this->model
            ->with(['categories', 'tags'])
            ->whereHas('categories', function ($query) use ($categorySlug) {
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
            ->with(['categories', 'tags'])
            ->whereHas('categories', function ($query) use ($categorySlug) {
                $query->where('slug', $categorySlug);
            })
            ->where(function ($query) use ($searchTerm) {
                $query->where('name', 'like', '%' . $searchTerm . '%')
                    ->orWhere('description', 'like', '%' . $searchTerm . '%');
            })
            ->get();
    }

    /* ================== CRUD Methods ================== */

    public function create(array $data): Game
    {
        $data['created_by'] = $this->adminId;
        if (isset($data['logo'])) {
            $data['logo'] = $this->handleSingleFileUpload(newFile: $data['logo'], folderName: 'games');
        }
        if (isset($data['banner'])) {
            $data['banner'] = $this->handleSingleFileUpload(newFile: $data['banner'], folderName: 'games');
        }

        if (!empty($data['meta_keywords']) && is_string($data['meta_keywords'])) {
            $keywords = array_filter(
                array_map('trim', explode(',', $data['meta_keywords'])),
                fn($item) => $item !== ''
            );

            $data['meta_keywords'] = json_encode(array_values($keywords));
        }
        return $this->model->create($data);
    }

    public function update(int $id, array $data): bool
    {
        $game = $this->findData($id);

        $logoPath = $game->logo;
        if (isset($data['logo'])) {
            $logoPath = $this->handleSingleFileUpload(newFile: $data['logo'], oldPath: $game->logo, removeKey: $data['remove_logo'] ?? false, folderName: 'games');
        }
        $data['logo'] = $logoPath;
        $bannerPath = $game->banner;
        if (isset($data['banner'])) {
            $bannerPath = $this->handleSingleFileUpload(newFile: $data['banner'], oldPath: $game->banner, removeKey: $data['remove_banner'] ?? false, folderName: 'games');
        }
        $data['banner'] = $bannerPath;

        // meta keywords 
        if (!empty($data['meta_keywords']) && is_string($data['meta_keywords'])) {
            $keywords = array_filter(
                array_map('trim', explode(',', $data['meta_keywords'])),
                fn($item) => $item !== ''
            );

            $data['meta_keywords'] = json_encode(array_values($keywords));
        }

        $data['updated_by'] = $this->adminId;
        return $game ? $game->update($data) : false;
    }

    public function delete(int $id, bool $force = false): bool
    {
        $game = $this->findData(value: $id, column: 'id', withTrashed: true);
        if (!$game) return false;

        if ($force) {
            return $game->forceDelete();
        }

        $game->update(['deleted_by' => $this->adminId]);
        return $game->delete();
    }

    public function restore(int $id): bool
    {
        $game = $this->findData(value: $id, column: 'id', withTrashed: true);
        if (!$game) return false;

        $game->update(['restored_by' => $this->adminId]);
        return $game->restore();
    }

    public function updateStatus(int $id, GameStatus $status): bool
    {
        $game = $this->findData($id);
        return $game ? $game->update(['status' => $status->value]) : false;
    }

    public function bulkUpdate(array $ids, array $changes): int
    {
        $changes['updated_by'] = $this->adminId;
        return $this->model->whereIn('id', $ids)->update($changes);
    }

    public function bulkDelete(array $ids, bool $force = false): int
    {
        if ($force) {
            return $this->model->whereIn('id', $ids)->forceDelete();
        }

        $this->model->whereIn('id', $ids)->update(['deleted_by' => $this->adminId]);
        return $this->model->whereIn('id', $ids)->delete();
    }

    public function bulkRestore(array $ids): int
    {
        $this->model->whereIn('id', $ids)->update(['restored_by' => $this->adminId]);
        return $this->model->whereIn('id', $ids)->restore();
    }


    /* ================== ================== ==================
     *                      RELATIONSHIPS
     * ================== ================== ================== */
    public function saveGameCategory(Game $game, Category $category): GameCategory
    {
        return DB::transaction(function () use ($game, $category) {
            $gameCategory = $this->gameCategory->updateOrCreate(
                [
                    'game_id' => $game->id,
                    'category_id' => $category->id,
                ]
            );

            return $gameCategory;
        });
    }

    /**
     * Delete game category with optimized query
     * Returns boolean indicating success
     */
    public function deleteGameCategory(Game $game, Category $category): bool
    {
        return DB::transaction(function () use ($game, $category) {
            $deleted = $this->gameCategory
                ->where('game_id', $game->id)
                ->where('category_id', $category->id)
                ->delete();

            return $deleted > 0;
        });
    }
}
