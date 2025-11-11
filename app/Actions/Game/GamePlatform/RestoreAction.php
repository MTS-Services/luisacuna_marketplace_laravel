<?php 
namespace App\Actions\Game\GamePlatform;

use App\Repositories\Contracts\GamePlatformInterface;
use Illuminate\Support\Facades\DB;

class RestoreAction {
    public function __construct(protected GamePlatformInterface $interface) {}
      public function execute(int $id, ?int $actionerId): bool
    {
        return DB::transaction(function () use ($id, $actionerId) {
            return $this->interface->restore($id, $actionerId);
        });
    }
}