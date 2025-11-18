<?php

namespace App\Actions\Server;


use App\Models\Server;
use App\Repositories\Contracts\ServerRepositoryInterface;
use Illuminate\Support\Facades\DB;

class CreateAction
{
    public function __construct(
        protected ServerRepositoryInterface $interface
    ) {
    }


    public function execute(array $data): Server
    {
        return DB::transaction(function () use ($data) {
            $newData = $this->interface->create($data);
            return $newData->fresh();
        });
    }
}
