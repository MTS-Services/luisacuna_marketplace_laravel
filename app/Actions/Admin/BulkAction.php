<?php

namespace App\Actions\Admin;

use App\Models\Admin;
use App\Models\Role;
use App\Repositories\Contracts\AdminRepositoryInterface;
use App\Support\SuperAdminGuard;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\DB;

class BulkAction
{
    public function __construct(public AdminRepositoryInterface $interface) {}

    public function execute(array $ids, string $action, ?string $status, ?int $actionerId)
    {
        if (in_array($action, ['delete', 'forceDelete', 'restore'], true)) {
            $admins = Admin::withTrashed()->whereIn('id', $ids)->get();
            $superAdminRoleId = Role::getSuperAdminRoleId();
            $touchesSuperAdmin = $admins->contains(
                fn (Admin $admin) => (int) $admin->role_id === $superAdminRoleId
            );
            if ($touchesSuperAdmin) {
                SuperAdminGuard::requireSuperAdmin();
            }
            if (in_array($action, ['delete'], true)) {
                $adminsToDelete = Admin::whereIn('id', $ids)->get();
                $superAdminCountInSet = $adminsToDelete->filter(fn (Admin $a) => (int) $a->role_id === $superAdminRoleId)->count();
                if ($superAdminCountInSet > 0 && Role::countAdminsWithSuperAdminRole() === $superAdminCountInSet) {
                    throw new AuthorizationException('Cannot delete the last Super Admin. Assign the Super Admin role to another admin first.');
                }
            }
        }

        return DB::transaction(function () use ($ids, $action, $status, $actionerId) {
            switch ($action) {
                case 'delete':
                    return $this->interface->bulkDelete($ids, $actionerId);
                case 'forceDelete':
                    return $this->interface->bulkForceDelete($ids);
                case 'restore':
                    return $this->interface->bulkRestore($ids, $actionerId);
                case 'status':
                    return $this->interface->bulkUpdateStatus($ids, $status, $actionerId);
            }
        });
    }
}
