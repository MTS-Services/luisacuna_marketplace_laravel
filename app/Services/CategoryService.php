<?php

namespace App\Services;

use App\Actions\Game\Category\BulkAction;
use App\Actions\Game\Category\CreateAction;
use App\Actions\Game\Category\DeleteAction;
use App\Actions\Game\Category\RestoreAction;
use App\Actions\Game\Category\UpdateAction;
use App\Enums\CategoryStatus;
use App\Enums\CategoryLayout;
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

    public function getDatas($sortField = 'created_at', $order = 'desc', $status = 'active', $layout = false, $trashed = false, ?array $selects = null): Collection
    {
        return $this->interface->getData($sortField, $order, $status, $layout, $trashed, $selects);
    }

    public function findData($column_value, string $column_name = 'id', $status = false, $layout = false, $trashed = false): ?Category
    {
        return $this->interface->findData($column_value, $column_name, $status, $layout, $trashed);
    }

    public function getPaginatedData(int $perPage = 15, array $filters = [], $sortField = 'created_at', $order = 'desc', $status = false, $layout = false, $trashed = false): LengthAwarePaginator
    {
        return $this->interface->getPaginatedData($perPage, $filters, $sortField, $order, $status, $layout, $trashed);
    }

    public function searchData(string $query, $sortField = 'created_at', $order = 'desc', $status = false, $layout = false, $trashed = false): Collection
    {
        return $this->interface->searchData($query, $sortField, $order, $status, $layout, $trashed);
    }

    public function dataExists(int $id, $status = false, $layout = false, $trashed = false): bool
    {
        return $this->interface->dataExists($id, $status, $layout, $trashed);
    }

    public function getDataCount(array $filters = [], $status = false, $layout = false, $trashed = false): int
    {
        return $this->interface->getDataCount($filters, $status, $layout, $trashed);
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
    public function updateLayoutData(int $id, CategoryLayout $layout, ?int $actionerId = null): Category
    {
        if ($actionerId == null) {
            $actionerId = admin()->id;
        }

        return $this->updateAction->execute($id, [
            'layout' => $layout->value,
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
    public function bulkUpdateLayout(array $ids, CategoryLayout $layout, ?int $actionerId = null): int
    {
        if ($actionerId == null) {
            $actionerId = admin()->id;
        }

        return $this->bulkAction->execute(ids: $ids, action: 'layout', status: $layout->value, actionerId: $actionerId);
    }
}
