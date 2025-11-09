<?php

namespace App\Actions\Permission;

use App\Repositories\Contracts\PermissionRepositoryInterface;
use Illuminate\Support\Facades\DB;

class DeleteAction
{
    public function __construct(
        protected PermissionRepositoryInterface $interface
    ) {}


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
}
