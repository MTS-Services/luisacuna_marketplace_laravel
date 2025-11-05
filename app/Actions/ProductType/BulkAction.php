<?php

namespace App\Actions\ProductType;

use Illuminate\Support\Facades\DB;
use App\Repositories\Contracts\ProductTypeRepositoryInterface;

class BulkAction
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        protected ProductTypeRepositoryInterface $interface
    )
    {}

    public function execute(array $ids, string $action, ?string $status = null, int $actionerId)
    {
        return DB::transaction(function () use ($ids, $action, $status, $actionerId) {
            switch ($action) {
                case 'delete':
                    return $this->interface->bulkDelete($ids, $actionerId);
                    break;
                case 'restore':
                    return $this->interface->bulkRestore($ids, $actionerId);
                    break;
                case 'forceDelete':
                    return $this->interface->bulkForceDelete($ids);
                    break;
                case 'status':
                    return $this->interface->bulkUpdateStatus($ids, $status, $actionerId);
                    break;
            }
        });
    }
}
