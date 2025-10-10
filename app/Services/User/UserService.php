<?php

namespace App\Services\User;

use App\DTOs\User\CreateUserDTO;
use App\DTOs\User\UpdateUserDTO;
use App\Events\User\UserCreated;
use App\Models\User;
use App\Repositories\Contracts\User\UserRepositoryInterface;
use App\Services\Contracts\User\UserServiceInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UserService
{
    public function __construct(protected UserRepositoryInterface $userRepository) {}

    public function all()
    {
        return $this->userRepository->all();
    }

    public function find($id)
    {
        return $this->userRepository->find($id);
    }

    public function getPaginatedUsers(int $perPage = 15)
    {
        return $this->userRepository->paginate($perPage);
    }

    public function createUser(CreateUserDTO $dto): User
    {
        try {
            return DB::transaction(function () use ($dto) {
                // Create user
                $user = $this->userRepository->create($dto->toArray());

                // Fire event for side effects
                event(new UserCreated($user));

                Log::info('User created successfully', ['user_id' => $user->id]);

                return $user;
            });
        } catch (\Exception $e) {
            Log::error('Failed to create user', [
                'error' => $e->getMessage(),
                'data' => $dto->toArray()
            ]);
            throw $e;
        }
    }

    public function updateUser(int $id, UpdateUserDTO $dto): User
    {
        try {
            return DB::transaction(function () use ($id, $dto) {
                $user = $this->userRepository->update($id, $dto->toArray());

                Log::info('User updated successfully', ['user_id' => $user->id]);

                return $user;
            });
        } catch (\Exception $e) {
            Log::error('Failed to update user', [
                'user_id' => $id,
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }

    public function deleteUser(int $id): bool
    {
        try {
            $result = $this->userRepository->delete($id);

            Log::info('User deleted successfully', ['user_id' => $id]);

            return $result;
        } catch (\Exception $e) {
            Log::error('Failed to delete user', [
                'user_id' => $id,
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }

    public function searchUsers(string $query, int $perPage = 15): LengthAwarePaginator
    {
        return $this->userRepository->search($query, $perPage);
    }

    public function getActiveUsers(): Collection
    {
        return $this->userRepository->getActiveUsers();
    }
}
