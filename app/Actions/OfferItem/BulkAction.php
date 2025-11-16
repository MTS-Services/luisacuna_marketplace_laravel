<?php

namespace App\Actions\OfferItem;

use Illuminate\Support\Facades\DB;
use App\Repositories\Contracts\OfferItemRepositoryInterface;

class BulkAction
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        protected OfferItemRepositoryInterface $interface
    )
    {}
    public function execute(array $ids, string $action, ?string $status = null, int $actionerId): bool
    {
        return DB::transaction(function () use ($ids, $action, $status, $actionerId) {
            switch ($action) {
                case 'delete':
                    return $this->interface->bulkDelete($ids, $actionerId);
                case 'restore':
                    return $this->interface->bulkRestore($ids, $actionerId);
                case 'forceDelete':
                    return $this->interface->bulkForceDelete($ids);
            }
        });
    }
}
