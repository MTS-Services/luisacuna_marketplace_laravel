<?php

namespace App\Actions\PageView;

use Illuminate\Support\Facades\DB;
use App\Repositories\Contracts\PageViewRepositoryInterface;

class BulkAction
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        protected PageViewRepositoryInterface $interface
    )
    {}

    public function execute(array $ids, string $action,  int $actionerId)
    {
        return DB::transaction(function () use ($ids, $action, $actionerId) {
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
            }
        });
    }
}
