<?php

namespace App\Services\Admin;

use App\Actions\Admin\BulkAction;
use App\Actions\Admin\CreateAction;
use App\Actions\Admin\DeleteAction;
use App\Actions\Admin\RestoreAction;
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
        protected RestoreAction $restoreAction,
        protected BulkAction $bulkAction,
    ) {}

    public function getAllDatas(): Collection
    {
        return $this->interface->all();
    }

    public function getAdminsPaginated(int $perPage = 15, array $filters = []): LengthAwarePaginator
    {
        return $this->interface->paginate($perPage, $filters);
    }

    public function getAdminById(int $id): ?Admin
    {
        return $this->interface->find($id);
    }

    public function getAdminByEmail(string $email): ?Admin
    {
        return $this->interface->findByEmail($email);
    }

    public function createAdmin(CreateAdminDTO $dto): Admin
    {
        return $this->createAdminAction->execute($dto);
    }

    public function updateAdmin(int $id, UpdateAdminDTO $dto): Admin
    {
        return $this->updateAdminAction->execute($id, $dto);
    }

    public function deleteAdmin(int $id, bool $forceDelete = false): bool
    {
        return $this->deleteAdminAction->execute($id, $forceDelete);
    }

    public function restoreAdmin(int $id): bool
    {
        return $this->restoreAction->execute($id, $actionerId);
    }

    public function getActiveAdmins(): Collection
    {
        return $this->interface->getActive();
    }

    public function getInactiveAdmins(): Collection
    {
        return $this->interface->getInactive();
    }

    public function searchAdmins(string $query): Collection
    {
        return $this->interface->search($query);
    }

    public function bulkDeleteDatas(array $ids , ?int $actionerId = null): int
    {
        if($actionerId == null){
          $actionerId = admin()->id; 
        }

        return $this->bulkAction->execute($ids, 'delete', null, $actionerId);
    }

    public function bulkUpdateStatus(array $ids, AdminStatus $status, ?int $actionerId = null): int
    {
        if ($actionerId == null) {
            $actionerId = admin()->id;
        }
        return $this->bulkAction->execute(ids: $ids, action: 'status', status: $status->value, actionerId: $actionerId);
    }

    public function getAdminsCount(array $filters = []): int
    {
        return $this->interface->count($filters);
    }

    public function adminExists(int $id): bool
    {
        return $this->interface->exists($id);
    }

    public function activateAdmin(int $id): bool
    {
        $admin = $this->getAdminById($id);

        if (!$admin) {
            return false;
        }

        $admin->activate();
        return true;
    }

    public function deactivateAdmin(int $id): bool
    {
        $admin = $this->getAdminById($id);

        if (!$admin) {
            return false;
        }

        $admin->deactivate();
        return true;
    }

    public function suspendAdmin(int $id): bool
    {
        $admin = $this->getAdminById($id);

        if (!$admin) {
            return false;
        }

        $admin->suspend();
        return true;
    }
    public function getTrashedAdminsPaginated(int $perPage = 15, array $filters = []): LengthAwarePaginator
    {
        return $this->interface->trashPaginate($perPage, $filters);
    }

    public function bulkRestoreAdmins(array $ids): int
    {
        return $this->bulkAction->execute($ids, 'restore', null, $actionerId);
    }

    public function bulkForceDeleteAdmins(array $ids): int
    {
        return $this->bulkAction->execute($ids, 'forceDelete', null, null);
    }
}
