<?php 
namespace App\Actions\Game\GamePlatform;

use App\Models\GamePlatform;
use App\Repositories\Contracts\GamePlatformRepositoryInterface;
use Illuminate\Support\Facades\DB;

class CreateAction {
    public function __construct(protected GamePlatformRepositoryInterface $interface) {}
     public function execute(array $data): GamePlatform
    {
        return DB::transaction(function () use ($data) {
            $newData = $this->interface->create($data);
            return $newData->fresh();
        });
    }
}