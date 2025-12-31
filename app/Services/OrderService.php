<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class OrderService
{
    public function __construct(protected Order $model) {}

    public function getAllDatas($sortField = 'created_at', $order = 'desc'): Collection
    {
        return $this->model->all($sortField, $order);
    }

    // public function findData($column_value, string $column_name = 'id'): ?Order
    // {
    //     $model = $this->model;

    //     return $model->where($column_name, $column_value)->first();
    // }
    public function findData($column_value, string $column_name = 'id'): ?Order
    {
        $model = $this->model;

        return $model->with(['source', 'user'])
            ->where($column_name, $column_value)
            ->first();
    }

    public function getPaginatedData(int $perPage = 15, array $filters = []): LengthAwarePaginator
    {
        $sortField = $filters['sort_field'] ?? 'created_at';
        $sortDirection = $filters['sort_direction'] ?? 'desc';

        $orders = $this->model->query()
            ->with(['source.user', 'user', 'source.game'])
            ->filter($filters)
            ->orderBy($sortField, $sortDirection)
            ->paginate($perPage);
        return $orders;
    }

    public function searchData(string $query, $sortField = 'created_at', $order = 'desc'): Collection
    {
        // return $this->model->search($query, $sortField, $order);
        return Collection::empty();
    }

    public function dataExists(int $id): bool
    {
        return $this->model->exists($id);
    }

    public function getDataCount(array $filters = []): int
    {
        return $this->model->count($filters);
    }

    /* ================== ================== ==================
     *                   Action Executions
     * ================== ================== ================== */

    public function createData(array $data): Order
    {
        return $this->model->create($data);
    }

    // Manage Function According to your need
    public function updateData(int $id, array $data): Order
    {
        //  return $this->updateAction->execute($id, $data);
        return new Order();
    }

    public function deleteData(int $id, bool $forceDelete = false, ?int $actionerId = null): bool
    {
        if ($actionerId == null) {
            $actionerId = admin()->id;
        }

        return true;
        // return $this->deleteAction->execute($id, $forceDelete, $actionerId);
    }

    public function restoreData(int $id, ?int $actionerId = null): bool
    {
        if ($actionerId == null) {
            $actionerId = admin()->id;
        }

        return true;
        //  return $this->restoreAction->execute($id, $actionerId);
    }
    public function bulkRestoreData(array $ids, ?int $actionerId = null): int
    {
        if ($actionerId == null) {
            $actionerId = admin()->id;
        }
        return 0;
        //  return $this->bulkAction->execute(ids: $ids, action: 'restore', status: null, actionerId: $actionerId);
    }

    public function bulkForceDeleteData(array $ids, ?int $actionerId = null): int
    {
        if ($actionerId == null) {
            $actionerId = admin()->id;
        }
        return 0;
        //  return $this->bulkAction->execute(ids: $ids, action: 'forceDelete', status: null, actionerId: $actionerId);
    }

    public function bulkDeleteData(array $ids, ?int $actionerId = null): int
    {
        if ($actionerId == null) {
            $actionerId = admin()->id;
        }
        return 0;
        //  return $this->bulkAction->execute(ids: $ids, action: 'delete', status: null, actionerId: $actionerId);
    }

    /* ================== ================== ==================
     *                   Accessors (optionals)
     * ================== ================== ================== */

    public function getActiveData($sortField = 'created_at', $order = 'desc'): Collection
    {
        return $this->model->getActive($sortField, $order);
    }

    public function getInactiveData($sortField = 'created_at', $order = 'desc'): Collection
    {
        return $this->model->getInactive($sortField, $order);
    }
}
