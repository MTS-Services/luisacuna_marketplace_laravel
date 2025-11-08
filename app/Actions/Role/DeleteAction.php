<?php

namespace App\Actions\Role;

use App\Repositories\Contracts\RoleRepositoryInterface;
use Illuminate\Support\Facades\DB;


class DeleteAction
{
    public function __construct(
        protected RoleRepositoryInterface $interface
    ) {
    }

    public function execute(int $id, bool $forceDelete = false, $actionerId): bool
    {
        return DB::transaction(function () use ($id, $forceDelete, $actionerId) {
            $data = $this->interface->find($id, 'id', true);

            if (!$data) {
                throw new \Exception('Data not found');
            }

            if ($forceDelete) {
                return $this->interface->forceDelete($id);
            }

            return $this->interface->delete($id, $actionerId);
        });
    }

    public function restore(int $dataId, int $actionerId): bool
    {
        return $this->interface->restore($dataId, $actionerId);
    }
}
