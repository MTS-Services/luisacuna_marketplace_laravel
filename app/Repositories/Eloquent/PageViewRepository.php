<?php

namespace App\Repositories\Eloquent;

use App\Models\PageView;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Repositories\Contracts\PageViewRepositoryInterface;

class PageViewRepository implements PageViewRepositoryInterface
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        protected PageView $model
    ) {}


    /* ================== ================== ==================
    *                      Find Methods 
    * ================== ================== ================== */
    public function all(string $sortField = 'created_at', $order = 'desc'): Collection
    {
        $query = $this->model->query();
        return $query->orderBy($sortField, $order)->get();
    }


    public function find($column_value, string $column_name = 'id',  bool $trashed = false): ?PageView
    {
        $model = $this->model;
        if ($trashed) {
            $model = $model->withTrashed();
        }
        return $model->where($column_name, $column_value)->first();
    }

    public function findTrashed($column_value, string $column_name = 'id'): ?PageView
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
            return PageView::search($search)
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
            return PageView::search($search)
                ->onlyTrashed()
                ->query(fn($query) => $query->filter($filters)->orderBy($sortField, $sortDirection))
                ->paginate($perPage);
        }

        return $this->model->onlyTrashed()
            ->filter($filters)
            ->orderBy($sortField, $sortDirection)
            ->paginate($perPage);
        return $query->paginate($perPage);
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


    /* ================== ================== ==================
    *                    Data Modification Methods 
    * ================== ================== ================== */


    public function delete(int $id, int $actionerId): bool
    {
        $currency = $this->find($id);

        if (!$currency) {
            return false;
        }
        $currency->update(['deleter_type' => $actionerId]);

        return $currency->delete();
    }

    public function forceDelete(int $id): bool
    {
        $currency = $this->findTrashed($id);

        if (!$currency) {
            return false;
        }

        return $currency->forceDelete();
    }

    public function restore(int $id, int $actionerId): bool
    {
        $currency = $this->findTrashed($id);

        if (!$currency) {
            return false;
        }
        $currency->update(['restorer_type' => $actionerId, 'restored_at' => now()]);

        return $currency->restore();
    }

    public function bulkDelete(array $ids, int $actionerId): int
    {
        return DB::transaction(function () use ($ids, $actionerId) {
            $this->model->whereIn('id', $ids)->update(['deleter_type' => $actionerId]);
            return $this->model->whereIn('id', $ids)->delete();
        });
    }

    public function bulkUpdateStatus(array $ids, string $status, int $actionerId): int
    {
        return $this->model->withTrashed()->whereIn('id', $ids)->update(['status' => $status, 'updated_by' => $actionerId]);
    }
    public function bulkRestore(array $ids, int $actionerId): int
    {
        return DB::transaction(function () use ($ids, $actionerId) {
            $this->model->onlyTrashed()->whereIn('id', $ids)->update(['restorer_type' => $actionerId, 'restored_at' => now()]);
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
}
