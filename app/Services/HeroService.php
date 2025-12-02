<?php

namespace App\Services;

use App\Models\Hero;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class HeroService
{
    public function __construct(protected Hero $model) {}


    /* ================== ================== ==================
    *                          Find Methods
    * ================== ================== ================== */

    public function getAllDatas($sortField = 'created_at', $order = 'desc'): Collection
    {
        $query = $this->model->query();
        return $query->orderBy($sortField, $order)->get();
    }

    public function findData($column_value, string $column_name = 'id',  bool $trashed = false): ?Hero
    {
        $model = $this->model;
        if ($trashed) {
            $model = $model->withTrashed();
        }
        return $model->where($column_name, $column_value)->first();
    }

    public function getFristData(array $filters = [], $sortField = 'created_at', $order = 'desc'): ?Hero
    {
        $query = $this->model->query();

        if (!empty($filters)) {
            $query->filter($filters);
        }

        return $query->orderBy($sortField, $order)->first();
    }

    public function getPaginatedData(int $perPage = 15, array $filters = []): LengthAwarePaginator
    {

        $query = $this->model->query();

        if (!empty($filters)) {
            $query->filter($filters);
        }

        $sortField = $filters['sort_field'] ?? 'created_at';
        $sortDirection = $filters['sort_direction'] ?? 'desc';
        $query->orderBy($sortField, $sortDirection);

        return $query->paginate($perPage);
    }

    public function getTrashedPaginatedData(int $perPage = 15, array $filters = []): LengthAwarePaginator
    {
        $query = $this->model->onlyTrashed()->orderBy('deleted_at', 'desc');
        // Apply filters
        if (!empty($filters)) {
            $query->filter($filters);
        }

        // Apply sorting        
        $sortField = $filters['sort_field'] ?? 'deleted_at';
        $sortDirection = $filters['sort_direction'] ?? 'desc';
        $query->orderBy($sortField, $sortDirection);

        return $query->paginate($perPage);
    }

    public function searchData(string $query, $sortField = 'created_at', $order = 'desc'): Collection
    {
        return $this->model->search($query)->orderBy($sortField, $order)->get();
    }

    public function dataExists(int $id): bool
    {
        return $this->model->where('id', $id)->exists();
    }

    public function getDataCount(array $filters = []): int
    {
        $query = $this->model->query();

        if (!empty($filters)) {
            $query->filter($filters);
        }

        return $query->count();
    }


    /* ================== ================== ==================
    *                   Action Executions
    * ================== ================== ================== */

    public function createData(array $data): ?Hero
    {
        return DB::transaction(function () use ($data) {

            if ($data['avatar']) {
                $prefix = uniqid('IMX') . '-' . time() . '-' . uniqid();
                $fileName = $prefix . '-' . $data['avatar']->getClientOriginalName();
                $data['avatar'] = Storage::disk('public')->putFileAs('admins', $data['avatar'], $fileName);
            }

            if ($data['avatars']) {
                $data['avatars'] = array_map(function ($avatar) {
                    $prefix = uniqid('IMX') . '-' . time() . '-' . uniqid();
                    $fileName = $prefix . '-' . $avatar->getClientOriginalName();
                    return Storage::disk('public')->putFileAs('admins', $avatar, $fileName);
                }, $data['avatars']);

                if (!is_array($data['avatars'])) {
                    $data['avatars'] = [$data['avatars']];
                }
                $data['avatars'] = $data['avatars'] ?? [];
            }


            $created =  $this->model->create($data);
            return $created;
        });
    }

    public function updateData(int $id, array $data): ?Hero
    {
        return DB::transaction(function () use ($id, $data) {
            $findData = $this->findData($id);
            if (!$findData) {
                return false;
            }

            // --- Database Logic for Pivot Table (Multiple Images) ---

            // 1. Extract and unset multiple image specific keys
            $newAvatarPaths = Arr::get($data, 'banner_image');
            $removedFiles = Arr::get($data, 'removed_file');

            // unset($data['avatars']);
            // unset($data['removed_files']);
            // unset($data['role_id']); // Remove role_id if not a direct Admin attribute

            // 2. Update the primary Admin record
            $updated = $findData->update($data);

            if (!$updated) {
                // Throwing an exception here will roll back the transaction
                throw new \Exception("Banner record update failed.");
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

    public function deleteData(int $id, bool $forceDelete = false, ?int $actionerId = null): bool
    {
        if ($actionerId == null) {
            $actionerId = admin()->id;
        }
        return $this->deleteAction->execute($id, $forceDelete, $actionerId);
    }

    public function restoreData(int $id, ?int $actionerId = null): bool
    {
        if ($actionerId == null) {
            $actionerId = admin()->id;
        }
        return $this->restoreAction->execute($id, $actionerId);
    }

    public function updateStatusData(int $id, GameStatus $status, ?int $actionerId = null): ?Game
    {
        if ($actionerId == null) {
            $actionerId = admin()->id;
        }
        return $this->updateAction->execute($id, [
            'status' => $status->value,
            'updater_id' => $actionerId,
        ]);
    }
    public function bulkRestoreData(array $ids, ?int $actionerId = null): int
    {
        if ($actionerId == null) {
            $actionerId = admin()->id;
        }
        return $this->bulkAction->execute(ids: $ids, action: 'restore', status: null, actionerId: $actionerId);
    }

    public function bulkForceDeleteData(array $ids, ?int $actionerId = null): int
    {
        if ($actionerId == null) {
            $actionerId = admin()->id;
        }
        return $this->bulkAction->execute(ids: $ids, action: 'forceDelete', status: null, actionerId: $actionerId);
    }

    public function bulkDeleteData(array $ids, ?int $actionerId = null): int
    {
        if ($actionerId == null) {
            $actionerId = admin()->id;
        }
        return $this->bulkAction->execute(ids: $ids, action: 'delete', status: null, actionerId: $actionerId);
    }
    public function bulkUpdateStatus(array $ids, GameStatus $status, ?int $actionerId = null): int
    {
        if ($actionerId == null) {
            $actionerId = admin()->id;
        }
        return $this->bulkAction->execute(ids: $ids, action: 'status', status: $status->value, actionerId: $actionerId);
    }

    /* ================== ================== ==================
    *                   Accessors (optionals)
    * ================== ================== ================== */

    public function getActiveData($sortField = 'created_at', $order = 'desc'): Collection
    {
        return $this->interface->getActive($sortField, $order);
    }

    public function getInactiveData($sortField = 'created_at', $order = 'desc'): Collection
    {
        return $this->interface->getInactive($sortField, $order);
    }
}
