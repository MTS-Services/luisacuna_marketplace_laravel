<?php

namespace App\Services;

use App\Actions\Currency\BulkAction;
use App\Actions\Currency\CreateAction;
use App\Actions\Currency\DeleteAction;
use App\Actions\Currency\RestoreAction;
use App\Actions\Currency\UpdateAction;
use App\Enums\CurrencyStatus;
use App\Models\Currency;
use App\Repositories\Contracts\CurrencyRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class CurrencyService
{
    public function __construct(
        protected CurrencyRepositoryInterface $interface,
        protected CreateAction $createAction,
        protected UpdateAction $updateAction,
        protected DeleteAction $deleteAction,
        protected RestoreAction $restoreAction,
        protected BulkAction $bulkAction
    ) {}

    /* ================== ================== ==================
    *                          Find Methods 
    * ================== ================== ================== */

    public function getAll($sortField = 'created_at', $order = 'desc'): Collection
    {
        return $this->interface->all($sortField, $order);
    }

    public function findData($column_value, string $column_name = 'id'): ?Currency
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

    public function createData(array $data): Currency
    {
        return $this->createAction->execute($data);
    }

    public function updateData(int $id, array $data): Currency
    {
        return $this->updateAction->execute($id, $data);
    }

    public function deleteData(int $id, bool $forceDelete = false): bool
    {
        return $this->deleteAction->execute($id, $forceDelete);
    }

    public function restoreData(int $id): bool
    {
        return $this->restoreAction->execute($id);
    }

    public function bulkRestoreData(array $ids): int
    {
        return $this->bulkAction->execute($ids, 'restore');
    }

    public function bulkForceDeleteData(array $ids): int
    {
        return $this->bulkAction->execute($ids, 'forceDelete');
    }

    public function bulkDeleteData(array $ids): int
    {
        return $this->bulkAction->execute($ids, 'delete');
    }

    public function bulkUpdateStatus(array $ids, CurrencyStatus $status): int
    {
        return $this->bulkAction->execute($ids, 'status', $status->value);
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
