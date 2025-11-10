<?php

namespace App\Actions\Permission;

use App\Repositories\Contracts\PermissionRepositoryInterface;
use Illuminate\Support\Facades\DB;

class BulkAction
{

    public function __construct(public PermissionRepositoryInterface $interface)
    {

    }

    public function execute(array $ids, string $action, ?int $actionerId)
    {
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
