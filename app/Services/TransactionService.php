<?php

namespace App\Services;

use App\Enums\TransactionStatus;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class TransactionService
{
    /**
     * Create a new class instance.
     */
    public function __construct(protected Transaction $model) {}


    public function getAllDatas($sortField = 'created_at', $order = 'desc', $filters = []): Collection
    {
        $baseQuery = $this->model->query();
        if (!empty($filters)) {
            $baseQuery->filter($filters);
        }
        return $baseQuery->orderBy($sortField, $order)->get();
    }


    public function paginateDatas(int $perPage = 15, array $filters = []): LengthAwarePaginator
    {
        $search = $filters['search'] ?? null;
        $sortField = $filters['sort_field'] ?? 'created_at';
        $sortDirection = $filters['sort_direction'] ?? 'desc';


        if ($search) {
            // Scout Search

            return $this->model::search($search)
                ->valided()
                ->query(fn($query) => $query->filter($filters)->orderBy($sortField, $sortDirection))
                ->paginate($perPage);
        }

        // // Normal Eloquent Query
        return $this->model->query()
            ->valided()
            ->filter($filters)
            ->orderBy($sortField, $sortDirection)
            ->paginate($perPage);
    }

    public function findData($column_value, string $column_name = 'id'): ?Transaction
    {
        $model = $this->model;

        return $model->with(['source', 'user'])
            ->where($column_name, $column_value)
            ->first();
    }
}
