<?php

namespace App\Repositories\Eloquent;

use App\Models\Category;
use App\Repositories\Contracts\CategoryRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class CategoryRepository implements CategoryRepositoryInterface
{


    public function __construct(protected Category $model) {}


    /* ================== ================== ==================
     *                      Find Methods
     * ================== ================== ================== */
    protected function commonQuery($query, $status, $layout, $trashed, ?array $selects = null)
    {
        if ($status) {
            $query->where('status', $status);
        }
        if ($layout) {
            $query->where('layout', $layout);
        }
        if ($trashed) {
            $query->withTrashed();
        }
        if ($selects) {
            $query->select($selects);
        }
        return $query;
    }

    public function getData(string $sortField, $order, $status, $layout, $trashed, ?array $selects): Collection
    {

        $query = $this->model->query();
        $this->commonQuery($query, $status, $layout, $trashed, $selects);
        $query->with([
            'products',
            'categoryTranslations' => function ($query) {
                $query->where('language_id', get_language_id());
            }
        ]);
        return $query->orderBy($sortField, $order)->get();
    }
    public function findData($column_value, string $column_name, $status, $layout, $trashed): ?Category
    {
        $query = $this->model->query();
        $this->commonQuery($query, $status, $layout, $trashed);
        $query->with([
            'categoryTranslations' => function ($query) {
                $query->where('language_id', get_language_id());
            }
        ]);
        return $query->where($column_name, $column_value)->first();
    }
    public function getPaginatedData(int $perPage, array $filters, string $sortField, $order, $status, $layout, $trashed): LengthAwarePaginator
    {
        $search = $filters['search'] ?? null;
        $sortField = $filters['sort_field'] ?? $sortField;
        $sortDirection = $filters['sort_direction'] ?? $order;
        $query = $this->model;
        $this->commonQuery($query, $status, $layout, $trashed);
        if ($search) {
            return $query->search($search)
                // ->filter($filters)
                ->orderBy($sortField, $sortDirection)
                ->paginate($perPage);
        }

        // Normal Eloquent Query
        return $query->filter($filters)
            ->orderBy($sortField, $sortDirection)
            ->paginate($perPage);
    }

    public function trashPaginate(int $perPage = 15, array $filters = []): LengthAwarePaginator
    {
        $query = $this->model->query();

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

    public function searchData(string $query, string $sortField, $order, $status, $layout, $trashed): Collection
    {
        $query = $this->model->query();
        $this->commonQuery($query, $status, $layout, $trashed);
        return $query->search($query)->orderBy($sortField, $order)->get();
    }


    public function dataExists(int $id, $status, $layout, $trashed): bool
    {
        $query = $this->model->query();
        $this->commonQuery($query, $status, $layout, $trashed);
        return $query->where('id', $id)->exists();
    }

    public function getDataCount(array $filters, $status, $layout, $trashed): int
    {
        $query = $this->model->query();
        $this->commonQuery($query, $status, $layout, $trashed);
        if (!empty($filters)) {
            $query->filter($filters);
        }
        return $query->count();
    }
    /* ================== ================== ==================
     *                    Data Modification Methods
     * ================== ================== ================== */

    public function create(array $data): Category
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data): bool
    {
        $findData = $this->findData($id, 'id', false, false, false);
        if (!$findData) {
            return false;
        }
        return $findData->update($data);
    }

    public function delete(int $id, int $actionerId): bool
    {
        $findData = $this->findData($id, 'id', false, false, false);
        if (!$findData) {
            return false;
        }
        $findData->update(['deleted_by' => $actionerId]);

        return $findData->delete();
    }

    public function forceDelete(int $id): bool
    {
        $findData = $this->findData($id, 'id', false, false, true);
        if (!$findData) {
            return false;
        }
        return $findData->forceDelete();
    }

    public function restore(int $id, int $actionerId): bool
    {
        $findData = $this->findData($id, 'id', false, false, true);
        if (!$findData) {
            return false;
        }
        $findData->update(['restored_by' => $actionerId, 'restored_at' => now()]);

        return $findData->restore();
    }

    public function bulkDelete(array $ids, int $actionerId): int
    {
        return DB::transaction(function () use ($ids, $actionerId) {
            $this->model->whereIn('id', $ids)->update(['deleted_by' => $actionerId]);
            return $this->model->whereIn('id', $ids)->delete();
        });
    }

    public function bulkUpdateStatus(array $ids, string $status, int $actionerId): int
    {
        return $this->model->withTrashed()->whereIn('id', $ids)->update(['status' => $status, 'updated_by' => $actionerId]);
    }
    public function bulkUpdateLayout(array $ids, string $layout, int $actionerId): int
    {
        return $this->model->withTrashed()->whereIn('id', $ids)->update(['layout' => $layout, 'updated_by' => $actionerId]);
    }
    public function bulkRestore(array $ids, int $actionerId): int
    {
        return DB::transaction(function () use ($ids, $actionerId) {
            $this->model->onlyTrashed()->whereIn('id', $ids)->update(['restored_by' => $actionerId, 'restored_at' => now()]);
            return $this->model->onlyTrashed()->whereIn('id', $ids)->restore();
        });
    }
    public function bulkForceDelete(array $ids): int //
    {
        return $this->model->onlyTrashed()->whereIn('id', $ids)->forceDelete();
    }
}
