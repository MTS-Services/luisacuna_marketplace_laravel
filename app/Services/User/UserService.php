<?php

namespace App\Services\User;

use App\Models\User;
use App\Enums\UserStatus;
use App\DTOs\User\CreateUserDTO;
use App\DTOs\User\UpdateUserDTO;
use App\Enums\UserAccountStatus;
use App\Actions\User\CreateUserAction;
use App\Actions\User\DeleteUserAction;
use App\Actions\User\UpdateUserAction;
use Illuminate\Database\Eloquent\Collection;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class UserService
{
    public function __construct(
        protected UserRepositoryInterface $interface,
        protected CreateUserAction $createUserAction,
        protected UpdateUserAction $updateUserAction,
        protected DeleteUserAction $deleteUserAction,
    ) {}

    public function getAllUsers(): Collection
    {
        return $this->interface->all();
    }

    public function getAllSellersData(): Collection
    {
        return $this->interface->getSellers();
    }

    public function getAllBuyersData(): Collection
    {
        return $this->interface->getBuyers();
    }

    public function getPaginateDatas(int $perPage = 15, array $filters = []): LengthAwarePaginator
    {
        return $this->interface->paginate($perPage, $filters);
    }

    public function getTrashedUsersPaginated(int $perPage = 15, array $filters = []): LengthAwarePaginator
    {
        return $this->interface->trashPaginate($perPage, $filters);
    }

    public function getUserById(int $id): ?User
    {
        return $this->interface->find($id);
    }

    public function getUserByEmail(string $email): ?User
    {
        return $this->interface->findByEmail($email);
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
        return $this->interface->getActive();
    }

    public function getInactiveUsers(): Collection
    {
        return $this->interface->getInactive();
    }

    public function searchUsers(string $query): Collection
    {
        return $this->interface->search($query);
    }

    public function bulkDeleteUsers(array $ids): int
    {
        return $this->interface->bulkDelete($ids);
    }

    public function bulkUpdateStatus(array $ids, UserAccountStatus $status): int
    {
        return $this->interface->bulkUpdateStatus($ids, $status->value);
    }

    public function getUsersCount(array $filters = []): int
    {
        return $this->interface->count($filters);
    }

    public function userExists(int $id): bool
    {
        return $this->interface->exists($id);
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
    public function bulkRestoreUsers(array $ids): int
    {
        return $this->interface->bulkRestore($ids);
    }

    public function bulkForceDeleteUsers(array $ids): int
    {
        return $this->interface->bulkForceDelete($ids);
    }
}
