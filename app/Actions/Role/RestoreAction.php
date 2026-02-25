<?php

namespace App\Actions\Role;

use App\Models\Role;
use App\Repositories\Contracts\RoleRepositoryInterface;
use App\Support\SuperAdminGuard;
use Illuminate\Support\Facades\DB;

class RestoreAction
{
    public function __construct(public RoleRepositoryInterface $interface) {}

    public function execute(int $id, ?int $actionerId)
    {
        return DB::transaction(function () use ($id, $actionerId) {
            $role = Role::withTrashed()->find($id);
            if ($role && Role::isSuperAdminRole($role)) {
                SuperAdminGuard::requireSuperAdmin();
            }

            return $this->interface->restore($id, $actionerId);
        });
    }
}
