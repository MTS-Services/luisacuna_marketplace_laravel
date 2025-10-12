<?php

namespace App\Services\User;

use App\Actions\User\CreateUserAction;
use App\Actions\User\DeleteUserAction;
use App\Actions\User\UpdateUserAction;
use App\DTOs\User\CreateUserDTO;
use App\DTOs\User\UpdateUserDTO;
use App\Enums\UserStatus;
use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class UserService 
{
    public function __construct(
        protected UserRepositoryInterface $userRepository,
        protected CreateUserAction $createUserAction,
        protected UpdateUserAction $updateUserAction,
        protected DeleteUserAction $deleteUserAction,
    ) {}

    public function getAllUsers(): Collection
    {
        return $this->userRepository->all();
    }

    public function getUsersPaginated(int $perPage = 15, array $filters = []): LengthAwarePaginator
    {
        return $this->userRepository->paginate($perPage, $filters);
    }

    public function getUserById(int $id): ?User
    {
        return $this->userRepository->find($id);
    }

    public function getUserByEmail(string $email): ?User
    {
        return $this->userRepository->findByEmail($email);
    }

    public function createUser(CreateUserDTO $dto): User
    {
        return $this->createUserAction->execute($dto);
    }

    public function updateUser(int $id, UpdateUserDTO $dto): User
    {
        return $this->updateUserAction->execute($id, $dto);
    }

    public function deleteUser(int $id, bool $forceDelete = false): bool
    {
        return $this->deleteUserAction->execute($id, $forceDelete);
    }

    public function restoreUser(int $id): bool
    {
        return $this->deleteUserAction->restore($id);
    }

    public function getActiveUsers(): Collection
    {
        return $this->userRepository->getActive();
    }

    public function getInactiveUsers(): Collection
    {
        return $this->userRepository->getInactive();
    }

    public function searchUsers(string $query): Collection
    {
        return $this->userRepository->search($query);
    }

    public function bulkDeleteUsers(array $ids): int
    {
        return $this->userRepository->bulkDelete($ids);
    }

    public function bulkUpdateStatus(array $ids, UserStatus $status): int
    {
        return $this->userRepository->bulkUpdateStatus($ids, $status->value);
    }

    public function getUsersCount(array $filters = []): int
    {
        return $this->userRepository->count($filters);
    }

    public function userExists(int $id): bool
    {
        return $this->userRepository->exists($id);
    }

    public function activateUser(int $id): bool
    {
        $user = $this->getUserById($id);
        
        if (!$user) {
            return false;
        }

        $user->activate();
        return true;
    }

    public function deactivateUser(int $id): bool
    {
        $user = $this->getUserById($id);
        
        if (!$user) {
            return false;
        }

        $user->deactivate();
        return true;
    }

    public function suspendUser(int $id): bool
    {
        $user = $this->getUserById($id);
        
        if (!$user) {
            return false;
        }

        $user->suspend();
        return true;
    }
}