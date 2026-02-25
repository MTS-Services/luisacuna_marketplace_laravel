<?php

namespace App\Actions\Role;

use App\Models\Role;
use App\Repositories\Contracts\RoleRepositoryInterface;
use App\Support\SuperAdminGuard;
use Illuminate\Support\Facades\DB;

class CreateAction
{
    public function __construct(
        protected RoleRepositoryInterface $interface
    ) {}

    public function execute(array $data): Role
    {
        $creatingSuperAdminRole = (isset($data['id']) && (int) $data['id'] === Role::SUPER_ADMIN_ROLE_ID)
            || (isset($data['name']) && $data['name'] === Role::SUPER_ADMIN_NAME);
        if ($creatingSuperAdminRole) {
            SuperAdminGuard::requireSuperAdmin();
        }

        return DB::transaction(function () use ($data) {
            $data = $this->interface->create($data);

            return $data->fresh();
        });
    }
}
