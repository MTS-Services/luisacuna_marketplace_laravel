<?php

namespace App\Services\Admin;

use App\Actions\Admin\CreateAction;
use App\Actions\Admin\DeleteAction;
use App\Actions\Admin\UpdateAction;

use App\Enums\AdminStatus;
use App\Models\Admin;
use App\Repositories\Contracts\AdminRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class AdminService
{
    public function __construct(
        protected AdminRepositoryInterface $interface,
        protected CreateAction $createAction,
        protected UpdateAction $updateAction,
        protected DeleteAction $deleteAction,
    ) {}

    public function getAll(): Collection
    {
        return $this->interface->all();
    }

    public function getPaginatedDatas(int $perPage = 15, array $filters = []): LengthAwarePaginator
    {
        return $this->interface->paginate($perPage, $filters);
    }

    public function findData(int $id): ?Admin
    {
        return $this->interface->find($id);
    }

    public function getDataByEmail(string $email): ?Admin
    {
        return $this->interface->findByEmail($email);
    }

    public function createData(array $data): Admin
    {
        return $this->createAction->execute($data);
    }

    public function updateData(int $id, array $data): Admin
    {
        return $this->updateAction->execute($id, $data);
    }

    public function deleteData(int $id, bool $forceDelete = false): bool
    {
        return $this->deleteAction->execute($id, $forceDelete);
    }

    public function restoreData(int $id, int $actionerId): bool
    {
        return $this->deleteAction->restore($id, $actionerId);
    }

    public function getActiveDatas(): Collection
    {
        return $this->interface->getActive();
    }

    public function getInactiveDatas(): Collection
    {
        return $this->interface->getInactive();
    }

    public function searchData(string $query): Collection
    {
        return $this->interface->search($query);
    }

    public function bulkDeleteDatas(array $ids): int
    {
        return $this->interface->bulkDelete($ids);
    }

    public function bulkUpdateStatus(array $ids, AdminStatus $status): int
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
        $admin = $this->findData($id);

        if (!$admin) {
            return false;
        }

        $admin->activate();
        return true;
    }

    public function deactivateData(int $id): bool
    {
        $admin = $this->findData($id);

        if (!$admin) {
            return false;
        }

        $admin->deactivate();
        return true;
    }

    public function suspendData(int $id): bool
    {
        $admin = $this->findData($id);

        if (!$admin) {
            return false;
        }

        $admin->suspend();
        return true;
    }
    public function getTrashedDatasPaginated(int $perPage = 15, array $filters = []): LengthAwarePaginator
    {
        return $this->interface->trashPaginate($perPage, $filters);
    }

    public function bulkRestoreDatas(array $ids, int $actionerId): int
    {
        return $this->interface->bulkRestore($ids, $actionerId );
    }

    public function bulkForceDeleteDatas(array $ids): int
    {
        return $this->interface->bulkForceDelete($ids);
    }
}
