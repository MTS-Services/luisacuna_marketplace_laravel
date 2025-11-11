<?php 
namespace App\Actions\Game\GamePlatform;

use App\Models\GamePlatform;
use App\Repositories\Contracts\GamePlatformInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UpdateAction {
    public function __construct(protected GamePlatformInterface $interface) {}

    public function execute(int $id, array $data): GamePlatform
    {
        return DB::transaction(function () use ($id, $data) {
            $findData = $this->interface->find($id);
            if (!$findData) {
                Log::error('Data not found', ['data_id' => $id]);
                throw new \Exception('Data not found');
            }
            $updated = $this->interface->update($id, $data);
            if (!$updated) {
                Log::error('Failed to update data in repository', ['data_id' => $id]);
                throw new \Exception('Failed to update data');
            }
            return $findData->fresh();
        });
    }
}