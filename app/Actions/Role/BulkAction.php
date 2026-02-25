<?php

namespace App\Actions\Role;

use App\Models\Role;
use App\Repositories\Contracts\RoleRepositoryInterface;
use App\Support\SuperAdminGuard;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\DB;

class BulkAction
{
    public function __construct(public RoleRepositoryInterface $interface) {}

    public function execute(array $ids, string $action, ?int $actionerId)
    {
        if (in_array(Role::SUPER_ADMIN_ROLE_ID, $ids, true) && in_array($action, ['delete', 'forceDelete'], true)) {
            throw new AuthorizationException('The Super Admin role cannot be deleted.');
        }

        $roles = Role::withTrashed()->whereIn('id', $ids)->get();
        $touchesSuperAdmin = $roles->contains(fn (Role $role) => Role::isSuperAdminRole($role));
        if ($touchesSuperAdmin && $action === 'restore') {
            SuperAdminGuard::requireSuperAdmin();
        }

        return DB::transaction(function () use ($ids, $action, $actionerId) {
            switch ($action) {
                case 'delete':
                    return $this->interface->bulkDelete($ids, $actionerId);
                case 'forceDelete':
                    return $this->interface->bulkForceDelete($ids);
                case 'restore':
                    return $this->interface->bulkRestore($ids, $actionerId);
            }
        });
    }
}
