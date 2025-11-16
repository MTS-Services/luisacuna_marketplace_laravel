<?php

namespace App\Repositories\Eloquent;

use App\Models\Admin;
use App\Models\TestMultiImage;
use App\Repositories\Contracts\AdminRepositoryInterface;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Arr;

class AdminRepository implements AdminRepositoryInterface
{
    public function __construct(
        protected Admin $model
    ) {}



    /* ================== ================== ==================
     *                      Find Methods
     * ================== ================== ================== */

    public function all(string $sortField = 'created_at', $order = 'desc'): Collection
    {

        $query = $this->model->query();

        return $query->orderBy($sortField, $order)->get();
    }

    public function find($column_value, string $column_name = 'id', bool $trashed = false): ?Admin
    {
        $model = $this->model;
        if ($trashed) {
            $model = $model->withTrashed();
        }
        return $model->where($column_name, $column_value)->first();
    }


    public function findTrashed($column_value, string $column_name = 'id'): ?Admin
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
            return Admin::search($search)
                ->query(fn($query) => $query->filter($filters)->orderBy($sortField, $sortDirection))
                ->paginate($perPage);
        }

        // Normal Eloquent Query
        return $this->model->query()
            ->filter($filters)
            ->orderBy($sortField, $sortDirection)
            ->paginate($perPage);
    }


    public function trashPaginate(int $perPage = 15, array $filters = []): LengthAwarePaginator
    {
        $search = $filters['search'] ?? null;
        $sortField = $filters['sort_field'] ?? 'deleted_at';
        $sortDirection = $filters['sort_direction'] ?? 'desc';

        if ($search) {
            // 👇 Manually filter trashed + search
            return Admin::search($search)
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


    /* ================== ================== ==================
     *                    Data Modification Methods
     * ================== ================== ================== */



    public function create(array $data): Admin
    {
        return DB::transaction(function () use ($data) {
            $created =  $this->model->create($data);
            if (!empty($data['avatars'])) {
                foreach ($data['avatars'] as $avatar) {
                    TestMultiImage::create([
                        'admin_id' => $created->id,
                        'image' => $avatar
                    ]);
                }
            }
            if (isset($data['role_id'])) {
                $this->model->assignRole($created->role->name);
            }
            return $created;
        });
    }

    public function update(int $id, array $data): bool
    {
        return DB::transaction(function () use ($id, $data) {
            $findData = $this->find($id);
            if (!$findData) {
                return false;
            }

            // --- Database Logic for Pivot Table (Multiple Images) ---

            // 1. Extract and unset multiple image specific keys
            $newAvatarPaths = Arr::get($data, 'avatars', []);
            $removedFiles = Arr::get($data, 'removed_files', []);

            // unset($data['avatars']);
            // unset($data['removed_files']);
            // unset($data['role_id']); // Remove role_id if not a direct Admin attribute

            // 2. Update the primary Admin record
            $updated = $findData->update($data);

            if (!$updated) {
                // Throwing an exception here will roll back the transaction
                throw new \Exception("Admin record update failed.");
            }

            // 3. Handle deletion of pivot records
            if (!empty($removedFiles)) {
                // The Action deleted the files from disk; we delete the DB records
                TestMultiImage::where('admin_id', $findData->id)
                    ->whereIn('image', $removedFiles)
                    ->forceDelete();
            }

            // 4. Handle creation of new pivot records
            if (!empty($newAvatarPaths)) {
                $multiImageInserts = array_map(function ($path) use ($findData) {
                    return [
                        'admin_id' => $findData->id,
                        'image' => $path,
                        'created_at' => now(), // Add timestamps if required
                        'updated_at' => now(),
                    ];
                }, $newAvatarPaths);

                // Use insert for efficiency
                TestMultiImage::insert($multiImageInserts);
            }

            // 5. Role synchronization (based on your original code)
            if (isset($data['role_id'])) {
                $findData->syncRoles(Arr::get($data, 'role_id'));
            }
            return $updated;
        });
    }



    public function delete(int $id, $actionerId): bool
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
            $this->model->whereIn('id', $ids)->update(['deleted_by' => $actionerId]);
            return $this->model->whereIn('id', $ids)->delete();
        });
    }


    public function bulkUpdateStatus(array $ids, string $status, $actionerId): int
    {

        return $this->model->withTrashed()->whereIn('id', $ids)->update(['status' => $status, 'updated_by' => $actionerId]);
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
        return $this->model->withTrashed()->whereIn('id', $ids)->forceDelete();
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


    public function getPending(string $sortField = 'created_at', $order = 'desc'): Collection
    {
        return $this->model->pending()->orderBy($sortField, $order)->get();
    }

    public function getSuspended(string $sortField = 'created_at', $order = 'desc'): Collection
    {
        return $this->model->suspended()->orderBy($sortField, $order)->get();
    }
}
