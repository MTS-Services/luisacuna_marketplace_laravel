<?php

namespace App\Actions\Admin;

use App\Models\Role;
use App\Repositories\Contracts\AdminRepositoryInterface;
use App\Support\SuperAdminGuard;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DeleteAction
{
    public function __construct(
        protected AdminRepositoryInterface $interface
    ) {}

    public function execute(int $id, bool $forceDelete, int $actionerId): bool
    {
        return DB::transaction(function () use ($id, $forceDelete, $actionerId) {
            $findData = null;

            if ($forceDelete) {
                $findData = $this->interface->findTrashed($id);
            } else {
                $findData = $this->interface->find($id);
            }

            if (! $findData) {
                throw new \Exception('Data not found');
            }

            $superAdminRoleId = Role::getSuperAdminRoleId();
            if ((int) $findData->role_id === $superAdminRoleId) {
                SuperAdminGuard::requireSuperAdmin();
                if (! $forceDelete && Role::countAdminsWithSuperAdminRole() === 1) {
                    throw new AuthorizationException('Cannot delete the last Super Admin. Assign the Super Admin role to another admin first.');
                }
            }

            if ($forceDelete) {
                // Delete avatar
                if ($findData->avatar) {
                    Storage::disk('public')->delete($findData->avatar);
                }

                return $this->interface->forceDelete($id);
            }

            return $this->interface->delete($id, $actionerId);
        });
    }
}
