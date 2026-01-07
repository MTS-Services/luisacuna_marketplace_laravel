<?php

namespace App\Services;


use App\Enums\GameStatus;
use App\Models\Category;
use App\Models\Game;
use App\Models\GameCategory;
use App\Services\Cloudinary\CloudinaryService;
use App\Traits\FileManagementTrait;
use Cloudinary\Cloudinary;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class GameService
{
    use FileManagementTrait;
    public function __construct(
        protected Game $model,
        protected Category $category,
        protected GameCategory $gameCategory,
        protected CloudinaryService $cloudinaryService,
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
            ->with(['categories', 'gameTranslations' => function ($query) {
                $query->where('language_id', get_language_id());
            }])
            ->get();
    }


    public function latestData(int $limit = 10, $filters = []): Collection
    {

        return $this->model->query()->filter($filters)->limit($limit)->get();
    }

    public function randomData(int $limit = 100, $filters = []): Collection
    {

        return $this->model->query()->filter($filters)->inRandomOrder()->limit($limit)->get();
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

        // // Normal Eloquent Query
        return $this->model->query()
            ->filter($filters)
            ->with(['categories', 'gameTranslations' => function ($query) {
                $query->where('language_id', get_language_id());
            }])
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
            ->whereRelation('categories', $fieldName, $fieldValue)
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
            $uploaded = $this->cloudinaryService->upload($data['logo'], ['folder' => 'games']);
            $data['logo'] = $uploaded->publicId;
        }
        if (isset($data['banner'])) {
            $uploaded = $this->cloudinaryService->upload($data['banner'], ['folder' => 'games']);
            $data['banner'] = $uploaded->publicId;
        }

        if (!empty($data['meta_keywords']) && is_string($data['meta_keywords'])) {
            $keywords = array_filter(
                array_map('trim', explode(',', $data['meta_keywords'])),
                fn($item) => $item !== ''
            );

            $data['meta_keywords'] = json_encode(array_values($keywords));
        }
        $result = $this->model->create($data);
        $freshData = $result->fresh();

        Log::info('New game created', [
            'game_id' => $freshData->id,
            'game_name' => $freshData->name
        ]);

        $freshData->dispatchTranslation(
            defaultLanguageLocale: 'en',
            targetLanguageIds: null
        );
        return $freshData;
    }

    public function update(int $id, array $data): bool
    {
        $game = $this->findData($id);
        if (!$game) return false;

        $oldData = $game;
        $nameChanged = isset($data['name']) && $data['name'] !== $oldData['name'];
        $DescriptionChanged = isset($data['description']) && $data['description'] !== $oldData['description'];

        $logoPath = $game->logo;
        if (isset($data['logo'])) {
            $uploaded = $this->cloudinaryService->upload($data['logo'], ['folder' => 'games']);
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
        $newData = $game->update($data);

        $newData = $game->fresh();

        if ($nameChanged || $DescriptionChanged) {
            Log::info('Category name changed, dispatching translation job', [
                'category_id' => $id,
                'old_name' => $oldData['name'],
                'new_name' => $newData['name']
            ]);

            $newData->dispatchTranslation(
                defaultLanguageLocale: 'en',
                targetLanguageIds: null
            );
        }

        return true;
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
