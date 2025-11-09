<?php

namespace App\Actions\Admin;

use App\Repositories\Contracts\AdminRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DeleteAction
{
    public function __construct(
        protected AdminRepositoryInterface $interface
    ) {}

    public function execute(int $id, bool $forceDelete = false, $actionerId): bool
    {
        return DB::transaction(function () use ($id, $forceDelete, $actionerId) {
            $findData = $this->interface->find($id);

            if (!$findData) {
                throw new \Exception('Data not found');
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

    public function restore(int $adminId, int $actionerId): bool
    {
        return $this->interface->restore($adminId, $actionerId);
    }
}
