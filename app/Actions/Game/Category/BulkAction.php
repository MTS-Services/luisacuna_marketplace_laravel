<?php 


namespace App\Actions\Game\Category;

use App\Repositories\Contracts\CategoryRepositoryInterface;
use Illuminate\Support\Facades\DB;

class BulkAction {

    public function __construct(
        protected CategoryRepositoryInterface $interface
    ){}

    public function execute(array $ids, string $action,  $status = null, ?int $actionerId) {
        return DB::transaction(function () use ($ids, $action, $status, $actionerId){
            switch ($action) {
                case 'delete':
                    return $this->interface->bulkDelete($ids, $actionerId);
                case 'restore':
                    return $this->interface->bulkRestore($ids, $actionerId);
                case 'forceDelete':
                    return $this->interface->bulkForceDelete($ids);
                case 'status':
                    return $this->interface->bulkUpdateStatus($ids, $status, $actionerId);

            }
        });
    }
}