<?php

namespace App\Actions\GameServer;


use App\Models\GameServer;
use App\Repositories\Contracts\GameServerRepositoryInterface;
use Illuminate\Support\Facades\DB;

class CreateAction
{
    public function __construct(
        protected GameServerRepositoryInterface $interface
    ) {
    }


    public function execute(array $data): GameServer
    {
        return DB::transaction(function () use ($data) {
            $newData = $this->interface->create($data);
            return $newData->fresh();
        });
    }
}
