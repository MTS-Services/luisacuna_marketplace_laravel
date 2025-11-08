<?php

namespace App\Services;

use App\Actions\Game\Category\BulkAction;
use App\Actions\Game\Category\CreateAction;
use App\Actions\Game\Category\DeleteAction;
use App\Actions\Game\Category\RestoreAction;
use App\Actions\Game\Category\UpdateAction;
use App\Enums\GameCategoryStatus;
use App\Models\GameCategory;
use App\Repositories\Contracts\GameCategoryRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class GameCategoryService
{
    public function __construct(
        protected GameCategoryRepositoryInterface $interface,
        protected BulkAction $bulkAction,
        protected DeleteAction $deleteAction,
        protected RestoreAction $restoreAction,
        protected CreateAction $createAction,
        protected UpdateAction $updateAction,
    ) {}



    /* ================== ================== ==================
    *                          Find Methods 
    * ================== ================== ================== */

    public function getAllDatas($sortField = 'created_at', $order = 'desc'): Collection
    {
        return $this->interface->all($sortField, $order);
    }

    public function findData($column_value, string $column_name = 'id'): ?GameCategory
    {
        return $this->interface->find($column_value, $column_name);
    }

    public function getPaginatedData(int $perPage = 15, array $filters = []): LengthAwarePaginator
    {
        return $this->interface->paginate($perPage, $filters);
    }

    public function getTrashedPaginatedData(int $perPage = 15, array $filters = []): LengthAwarePaginator
    {
        return $this->interface->trashPaginate($perPage, $filters);
    }

    public function searchData(string $query, $sortField = 'created_at', $order = 'desc'): Collection
    {
        return $this->interface->search($query, $sortField, $order);
    }

    public function dataExists(int $id): bool
    {
        return $this->interface->exists($id);
    }

    public function getDataCount(array $filters = []): int
    {
        return $this->interface->count($filters);
    }


    /* ================== ================== ==================
    *                   Action Executions
    * ================== ================== ================== */

    public function createData(array $data): GameCategory
    {
        return $this->createAction->execute($data);
    }

    public function updateData(int $id, array $data): GameCategory
    {
        return $this->updateAction->execute($id, $data, admin()->id);
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

    public function updateStatusData(int $id, GameCategoryStatus $status, ?int $actionerId = null): GameCategory
    {
        if ($actionerId == null) {
            $actionerId = admin()->id;
        }

        return $this->updateAction->execute($id, [
            'status' => $status->value,
            'updated_by' => $actionerId,
        ], $actionerId);
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

    public function bulkUpdateStatus(array $ids, GameCategoryStatus $status, ?int $actionerId = null): int
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
    public function getSuspendedData($sortField = 'created_at', $order = 'desc'): Collection
    {
        return $this->interface->getSuspended($sortField, $order);
    }














    // public function getAllDatas()
    // {
    //     return $this->interface->all();
    // }

    // public function findData(int $id)
    // {

    //     return $this->interface->find($id);
    // }


    // public function getPaginateData(int $perPage = 15, array $filters = [], ?array $queries = null)
    // {
    //     return $this->interface->paginate($perPage, $filters, $queries ?? []);
    // }



    // public function createData(array $data): GameCategory
    // {
    //     return $this->createAction->execute($data);
    // }

    // public function updateData($id, array $data, ?int $actioner_id): bool
    // {
    //     return $this->updateAction->execute($id, $data, $actioner_id);
    // }

    // public function deleteData($id, ?int $actioner_id = null): bool
    // {
    //     if ($actioner_id == null) {

    //         $actioner_id = admin()->id;
    //     }
    //     return $this->deleteAction->execute($id,  false, $actioner_id);
    // }

    // public function forceDeleteData($id, $force_delete = true, ?int $actioner_id = null): bool
    // {
    //     return $this->deleteAction->execute($id, $force_delete, $actioner_id);
    // }


    // public function getTrashedPaginatedData(int $perPage = 15, array $filters = [], ?array $queries = null)
    // {
    //     return $this->interface->paginateOnlyTrashed($perPage, $filters, $queries ?? []);
    // }

    // public function restoreData($id, ?int $actioner_id): bool
    // {
    //     return $this->restoreAction->execute($id, $actioner_id);
    // }

    // public function bulkDeleteData(array $ids, int $actioner_id): int
    // {

    //     return $this->bulkAction->execute(ids: $ids, action: 'delete', status: null, actionerId: $actioner_id);
    // }

    // public function bulkForceDeleteData(array $ids): int
    // {

    //     return $this->bulkAction->execute(ids: $ids, action: 'forceDelete', status: null, actionerId: null);
    // }

    // public function bulkRestoreData(array $ids, int $actioner_id): int
    // {
    //     return $this->bulkAction->execute($ids, 'restore', null, $actioner_id);
    // }
    // public function bulkUpdateStatus(array $ids, GameCategoryStatus $status, ?int $actioner_id = null): int
    // {
    //     if ($actioner_id == null) {
    //         $actioner_id = admin()->id;
    //     }


    //     return $this->bulkAction->execute($ids, 'status', $status->value, $actioner_id);
    // }

    // public function findOrFail($id): GameCategory
    // {
    //     return $this->interface->findOrFail($id);
    // }
}
