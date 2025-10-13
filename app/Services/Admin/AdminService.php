<?php

namespace App\Services\Admin;

use App\Actions\Admin\CreateAdminAction;
use App\Actions\Admin\DeleteAdminAction;
use App\Actions\Admin\UpdateAdminAction;
use App\DTOs\Admin\CreateAdminDTO;
use App\DTOs\Admin\UpdateAdminDTO;
use App\Enums\AdminStatus;
use App\Models\Admin;
use App\Repositories\Contracts\AdminRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class AdminService
{
    public function __construct(
        protected AdminRepositoryInterface $adminRepository,
        protected CreateAdminAction $createAdminAction,
        protected UpdateAdminAction $updateAdminAction,
        protected DeleteAdminAction $deleteAdminAction,
    ) {}

/*************  ✨ Windsurf Command ⭐  *************/
/**
 * Get all admins.
 *
 * @return \Illuminate\Support\Collection
 */
/*******  b112efcc-2204-4830-835a-0e7c6fee632c  *******/
    public function getAllAdmins(): Collection
    {
        return $this->adminRepository->all();
    }

    public function getDeletedAdmins(): Collection
    {
        return $this->adminRepository->deletedAdmins();
    }

    public function forceDelete($id){
        return $this->adminRepository->forceDelete($id);
    }
    public function getAdminsPaginated(int $perPage = 15, array $filters = [], ?array $queries = []): LengthAwarePaginator
    {
        return $this->adminRepository->paginate($perPage, $filters, $queries);
    }

    public function getAdminsPaginatedWithTrashed(int $perPage = 15, array $filters = [], ?array $queries = []): LengthAwarePaginator
    {
        return $this->adminRepository->paginateWithTrashed($perPage, $filters, $queries);
    }

    public function getAdminsPaginatedOnlyTrashed(int $perPage = 15, array $filters = [], ?array $queries = []): LengthAwarePaginator
    {
        return $this->adminRepository->paginateOnlyTrashed($perPage, $filters, $queries);
    }

    public function getAdminById(int $id): ?Admin
    {
        return $this->adminRepository->find($id);
    }

    public function getAdminByEmail(string $email): ?Admin
    {
        return $this->adminRepository->findByEmail($email);
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
        return $this->deleteAdminAction->restore($id);
    }

    public function getActiveAdmins(): Collection
    {
        return $this->adminRepository->getActive();
    }

    public function getInactiveAdmins(): Collection
    {
        return $this->adminRepository->getInactive();
    }

    public function searchAdmins(string $query): Collection
    {
        return $this->adminRepository->search($query);
    }

    public function bulkDeleteAdmins(array $ids): int
    {
        return $this->adminRepository->bulkDelete($ids);
    }

    public function bulkUpdateStatus(array $ids, AdminStatus $status): int
    {
        return $this->adminRepository->bulkUpdateStatus($ids, $status->value);
    }

    public function getAdminsCount(array $filters = []): int
    {
        return $this->adminRepository->count($filters);
    }

    public function adminExists(int $id): bool
    {
        return $this->adminRepository->exists($id);
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
}
