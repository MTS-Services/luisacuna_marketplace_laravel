<?php

namespace App\Actions\AchievementType;

use Illuminate\Support\Facades\DB;
use App\Repositories\Contracts\AchievementTypeRepositoryInterface;

class BulkAction
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        protected AchievementTypeRepositoryInterface $interface
    )
    {}

    public function execute(array $ids, string $action, int $actionerId): bool
    {
        return DB::transaction(function () use ($ids, $action, $actionerId) {
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
