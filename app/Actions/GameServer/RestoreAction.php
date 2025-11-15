<?php

namespace App\Actions\GameServer;

use App\Models\GameServer;
use App\Repositories\Contracts\GameServerRepositoryInterface;
use Illuminate\Support\Facades\DB;

class RestoreAction
{
    public function __construct(
        protected GameServerRepositoryInterface $interface
    ) {}

    public function execute(int $id, ?int $actionerId): bool
    {
        return DB::transaction(function () use ($id, $actionerId) {
            return $this->interface->restore($id, $actionerId);
        });
    }
}
