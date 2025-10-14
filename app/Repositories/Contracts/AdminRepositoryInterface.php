<?php

namespace App\Repositories\Contracts;

use App\Models\Admin;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;

interface AdminRepositoryInterface
{
    public function all(): Collection;

    public function deletedAdmins(): Collection;

    public function forceDelete(int $id): bool;
    
    public function getAdminWithTrash(int $id): ?Admin;

    public function paginate(int $perPage = 15, array $filters = [], ?array $queries = null): LengthAwarePaginator;

    public function paginateWithTrashed(int $perPage = 15, array $filters = [], ?array $queries = null): LengthAwarePaginator;

    public function paginateOnlyTrashed(int $perPage = 15, array $filters = [], ?array $queries = null): LengthAwarePaginator;

    public function find(int $id): ?Admin;

    public function findByEmail(string $email): ?Admin;

    public function create(array $data): Admin;

    public function update(int $id, array $data): bool;

    public function delete(int $id): bool;


    public function restore(int $id): bool;

    public function exists(int $id): bool;

    public function count(array $filters = []): int;

    public function getActive(): Collection;

    public function getInactive(): Collection;

    public function search(string $query): Collection;

    public function bulkDelete(array $ids): int;

    public function bulkUpdateStatus(array $ids, string $status): int;
}
