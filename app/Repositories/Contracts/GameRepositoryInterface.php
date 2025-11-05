<?php

namespace App\Repositories\Contracts;

use App\Enums\GameStatus;
use App\Models\Game;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface GameRepositoryInterface
{
    public function all(): Collection;

    public function paginate(int $perPage = 15, array $filters = [], ?array $queries = null): LengthAwarePaginator;

    public function trashPaginate(int $perPage = 15, array $filters = [], ?array $queries = null): LengthAwarePaginator;

    public function delete(int $id, ?int $actioner_id): bool;

    public function forceDelete($id): bool;

    public function bulkRestore(array $ids, ?int $actioner_id): int;

    public function restore($id, $actioner_id): bool;

    public function bulkUpdateStatus($ids, string $status, ?int $actioner_id): int;

    public function bulkDelete(array $ids, ?int $actioner_id): int;

    public function bulkForceDelete(array $ids): int;

    public function findTrashed($id): ?Game;

    public function create(array $data): Game;

    public function find(int $id): ?Game;

    public function update($id, array $data): bool;
}
