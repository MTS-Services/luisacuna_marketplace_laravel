<?php

namespace App\Actions\Admin;

use App\Events\Admin\AdminDeleted;
use App\Models\Admin;
use App\Repositories\Contracts\AdminRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DeleteAction
{
    public function __construct(
        protected AdminRepositoryInterface $interface
    ) {}

    public function execute(int $adminId, bool $forceDelete = false): bool
    {
        return DB::transaction(function () use ($adminId, $forceDelete) {
            $admin = $this->interface->find($adminId);

            if (!$admin) {
                throw new \Exception('Admin not found');
            }

            // Dispatch event before deletion
            event(new AdminDeleted($admin));

            if ($forceDelete) {
                // Delete avatar
                if ($admin->avatar) {
                    Storage::disk('public')->delete($admin->avatar);
                }

                return $this->interface->forceDelete($adminId);
            }

            return $this->interface->delete($adminId);
        });
    }

    public function restore(int $adminId, int $actionerId): bool
    {
        return $this->interface->restore($adminId, $actionerId);
    }
}
