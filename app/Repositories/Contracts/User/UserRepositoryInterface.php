<?php

namespace App\Repositories\Contracts\User;

use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface UserRepositoryInterface
{
   public function all(): Collection;

    public function paginate(int $perPage = 15, array $filters = []): LengthAwarePaginator;

    public function find(int $id): ?User;

    public function create(array $data): User;

    public function update(int $id, array $data): User;

    public function delete(int $id): bool;

    public function search(string $query, int $perPage = 15): LengthAwarePaginator;

    public function findByEmail(string $email): ?User;

    public function getActiveUsers(): Collection;
}
