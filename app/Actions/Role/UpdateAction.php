<?php

namespace App\Actions\Role;

use App\Models\Role;
use App\Repositories\Contracts\RoleRepositoryInterface;
use App\Support\SuperAdminGuard;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UpdateAction
{
    public function __construct(
        protected RoleRepositoryInterface $interface
    ) {}

    public function execute(int $id, array $data): Role
    {
        return DB::transaction(function () use ($id, $data) {
            $findData = $this->interface->find($id);
            if (! $findData) {
                Log::error('Data not found', ['data_id' => $id]);
                throw new \Exception(__('Data not found'));
            }
            if (Role::isSuperAdminRole($findData)) {
                SuperAdminGuard::requireSuperAdmin();
            }
            $updated = $this->interface->update($id, $data);
            if (! $updated) {
                Log::error('Failed to update data in repository', ['data_id' => $id]);
                throw new \Exception(__('Failed to update data'));
            }

            return $findData->fresh();
        });
    }
}
