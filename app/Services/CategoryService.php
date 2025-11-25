<?php

namespace App\Services;

use App\Actions\Game\Category\BulkAction;
use App\Actions\Game\Category\CreateAction;
use App\Actions\Game\Category\DeleteAction;
use App\Actions\Game\Category\RestoreAction;
use App\Actions\Game\Category\UpdateAction;
use App\Enums\CategoryStatus;
use App\Models\Category;
use App\Repositories\Contracts\CategoryRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class CategoryService
{
    public function __construct(
        protected CategoryRepositoryInterface $interface,
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

    public function findData($column_value, string $column_name = 'id'): ?Category
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

    public function createData(array $data): Category
    {
        return $this->createAction->execute($data);
    }

    public function updateData(int $id, array $data): Category
    {
        return $this->updateAction->execute($id, $data);
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

    public function updateStatusData(int $id, CategoryStatus $status, ?int $actionerId = null): Category
    {
        if ($actionerId == null) {
            $actionerId = admin()->id;
        }

        return $this->updateAction->execute($id, [
            'status' => $status->value,
            'updated_by' => $actionerId,
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
    public function bulkUpdateStatus(array $ids, CategoryStatus $status, ?int $actionerId = null): int
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
}
