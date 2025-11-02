<?php 


namespace App\Actions\Game\Category;

use App\Repositories\Contracts\GameCategoryRepositoryInterface;
use Illuminate\Support\Facades\DB;

class BulkAction {

    public function __construct(
        protected GameCategoryRepositoryInterface $interface
    ){}

    public function execute(array $ids, string $action,  $status = null, ?int $actionerId) {
        return DB::transaction(function () use ($ids, $action, $status, $actionerId){
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