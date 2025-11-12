<?php 
namespace App\Actions\Game\GamePlatform;

use App\Models\GamePlatform;
use App\Repositories\Contracts\GamePlatformRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class UpdateAction {
    public function __construct(protected GamePlatformRepositoryInterface $interface) {}

    public function execute(int $id, array $data): GamePlatform
    {
        return DB::transaction(function () use ($id, $data) {

            $findData = $this->interface->find($id);
            if (!$findData) {
                Log::error('Data not found', ['data_id' => $id]);
                throw new \Exception('Data not found');
            }
            $existing_icon = null;
            $new_icon = null;
            if(isset($data['icon'])){

                $data['icon'] = Storage::disk('public')->putFile('icons', $data['icon']);

                $existing_icon = $findData->icon;
                $new_icon = $data['icon'];

            }
            $updated = $this->interface->update($id, $data);
            if (!$updated) {
                Log::error('Failed to update data in repository', ['data_id' => $id]);
                throw new \Exception('Failed to update data');

                 if($new_icon && $new_icon != null){

                    Storage::disk('public')->delete($new_icon);

                }
                
            }else{
                if($existing_icon && $existing_icon != null){

                    Storage::disk('public')->delete($existing_icon);

                }
            }
            return $findData->fresh();
        });
    }
}