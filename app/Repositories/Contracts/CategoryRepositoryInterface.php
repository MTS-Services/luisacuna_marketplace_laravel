<?php

namespace App\Repositories\Contracts;

use App\Models\Category;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface CategoryRepositoryInterface
{

    /* ================== ================== ==================
     *                      Find Methods
     * ================== ================== ================== */

    public function getData(string $sortField, $order, $status, $layout, $trashed, ?array $selects): Collection;
    public function findData($column_value, string $column_name, $status, $layout, $trashed): ?Category;
    public function getPaginatedData(int $perPage, array $filters, string $sortField, $order, $status, $layout, $trashed): LengthAwarePaginator;
    public function searchData(string $query, string $sortField, $order, $status, $layout, $trashed): Collection;
    public function dataExists(int $id, $status, $layout, $trashed): bool;
    public function getDataCount(array $filters, $status, $layout, $trashed): int;


    /* ================== ================== ==================
     *                    Data Modification Methods
     * ================== ================== ================== */

    public function create(array $data): Category;
    public function update(int $id, array $data): bool;
    public function delete(int $id, int $actionerId): bool;
    public function forceDelete(int $id): bool;
    public function restore(int $id, int $actionerId): bool;
    public function bulkDelete(array $ids, int $actionerId): int;
    public function bulkUpdateStatus(array $ids, string $status, int $actionerId): int;
    public function bulkUpdateLayout(array $ids, string $layout, int $actionerId): int;
    public function bulkRestore(array $ids, int $actionerId): int;
    public function bulkForceDelete(array $ids): int;
}
