<?php 
namespace App\Actions\Game\GamePlatform;

use App\Repositories\Contracts\GamePlatformInterface;
use Illuminate\Support\Facades\DB;

class BulkAction {
    public function __construct(protected GamePlatformInterface $interface) {}



     public function execute(array $ids, string $action, ?string $status = null, ?int $actionerId = null) {
      return  DB::transaction(function () use ($ids, $action, $status, $actionerId) {
            switch ($action) {
                case 'delete': 
                    return $this->interface->bulkDelete($ids , $actionerId);
                    break;
                case 'forceDelete':
                    return $this->interface->bulkForceDelete($ids);
                    break;
                case 'restore':
                    return $this->interface->bulkRestore($ids, $actionerId);
                    break;
                case 'status':
                    return $this->interface->bulkUpdateStatus($ids, $status, $actionerId);
                    break;
                
            }  
        });
    }
}