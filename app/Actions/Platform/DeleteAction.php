<?php 
namespace App\Actions\Platform;

use App\Repositories\Contracts\PlatformRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DeleteAction {
    public function __construct(protected PlatformRepositoryInterface $interface) {}
     public function execute(int $id, bool $forceDelete = false, int $actionerId): bool
    {
        return DB::transaction(function () use ($id, $forceDelete, $actionerId) {
            $findData = null;
            $icon_path = null;
            if ($forceDelete) {
                $findData = $this->interface->findTrashed($id);
                if($findData){
                    $icon_path = $findData->icon;
                }
            } else {
                $findData = $this->interface->find($id);
            }

            if (!$findData) {
                throw new \Exception('Data not found');
            }
            if ($forceDelete) {
                $delete =  $this->interface->forceDelete($id);
                if($delete){
                    if($icon_path != null && Storage::disk('public')->exists($icon_path)){
                        
                        Storage::disk('public')->delete($icon_path);
                    }
                }
            }
            return $this->interface->delete($id, $actionerId);
        });
    }
}