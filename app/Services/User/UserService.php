<?php

namespace App\Services\User;

use App\Actions\User\CreateAction;
use App\Actions\User\DeleteAction;
use App\Actions\User\UpdateAction;
use App\Models\User;
use App\Enums\UserAccountStatus;
use Illuminate\Database\Eloquent\Collection;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class UserService
{
    public function __construct(
        protected UserRepositoryInterface $interface,
        protected CreateAction $createAction,
        protected UpdateAction $updateAction,
        protected DeleteAction $deleteAction,
    ) {}

    public function getAllUsers(): Collection
    {
        return $this->interface->all();
    }

    public function getPaginateDatas(int $perPage = 15, array $filters = []): LengthAwarePaginator
    {
        return $this->interface->paginate($perPage, $filters);
    }

    public function getTrashedPaginateDatas(int $perPage = 15, array $filters = []): LengthAwarePaginator
    {
        return $this->interface->trashPaginate($perPage, $filters);
    }

    public function getDataById(int $id): ?User
    {
        return $this->interface->find($id);
    }

    public function getDataByEmail(string $email): ?User
    {
        return $this->interface->findByEmail($email);
    }

    public function createData(array $data): User
    {
        return $this->createAction->execute($data);
    }

    public function updateData(int $id, array $data): User
    {
        return $this->updateAction->execute($id, $data);
    }

    public function deleteData(int $id, bool $forceDelete = false): bool
    {
        return $this->deleteAction->execute($id, $forceDelete);
    }

    public function restoreData(int $id, int $actioner_id): bool
    {
        return $this->deleteAction->restore($id, $actioner_id);
    }

    public function getActiveData(): Collection
    {
        return $this->interface->getActive();
    }

    public function getInactiveData(): Collection
    {
        return $this->interface->getInactive();
    }

    public function searchDatas(string $query): Collection
    {
        return $this->interface->search($query);
    }

    public function bulkDeleteDatas(array $ids): int
    {
        return $this->interface->bulkDelete($ids);
    }

    public function bulkUpdateStatus(array $ids, UserAccountStatus $status): int
    {
        return $this->interface->bulkUpdateStatus($ids, $status->value);
    }

    public function getDatasCount(array $filters = []): int
    {
        return $this->interface->count($filters);
    }

    public function dataExists(int $id): bool
    {
        return $this->interface->exists($id);
    }

    public function activateData(int $id): bool
    {
        $user = $this->getDataById($id);
        
        if (!$user) {
            return false;
        }

        $user->activate();
        return true;
    }

    public function deactivateData(int $id): bool
    {
        $user = $this->getDataById($id);
        
        if (!$user) {
            return false;
        }

        $user->deactivate();
        return true;
    }

    public function suspendData(int $id): bool
    {
        $user = $this->getDataById($id);
        
        if (!$user) {
            return false;
        }

        $user->suspend();
        return true;
    }
    public function bulkRestoreDatas(array $ids, int $actioner_id): int
    {
        return $this->interface->bulkRestore($ids, $actioner_id);
    }

    public function bulkForceDeleteDatas(array $ids): int
    {
        return $this->interface->bulkForceDelete($ids);
    }
}