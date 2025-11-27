<?php

namespace App\Repositories\Contracts;

use App\Models\User;
use App\Models\UsersNotificationSetting;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface UserRepositoryInterface
{
    public function all(): Collection;

    public function getSellers(): Collection;

    public function getSellersByTrash(): Collection;

    public function getBuyers(): Collection;

    public function paginate(int $perPage = 15, array $filters = []): LengthAwarePaginator;
    public function findData($column_value, string $column_name = 'id', bool $trashed = false): ?User;
    public function find(int $id): ?User;

    public function findByEmail(string $email): ?User;

    public function create(array $data): User;

    public function update(int $id, array $data): bool;

    public function delete(int $id): bool;

    public function forceDelete(int $id): bool;

    public function restore(int $id, int $actioner_id): bool;

    public function exists(int $id): bool;

    public function count(array $filters = []): int;

    public function getActive(): Collection;

    public function getInactive(): Collection;

    public function search(string $query): Collection;

    public function bulkDelete(array $ids, $actioner_id): int;

    public function bulkUpdateStatus(array $ids, string $status, $actioner_id): int;

    public function trashPaginate(int $perPage = 15, array $filters = []): LengthAwarePaginator;

    public function bulkRestore(array $ids, int $actioner_id): int;

    public function bulkForceDelete(array $ids): int;



    // Notification setting methods
    public function updateNotificationSetting(int $userId, string $field, bool $value): bool;

    public function getNotificationSettings(int $userId): ?UsersNotificationSetting;
}
