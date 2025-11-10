<?php

namespace App\Actions\Role;

use App\Models\Role;
use App\Repositories\Contracts\RoleRepositoryInterface;
use Illuminate\Support\Facades\DB;

class CreateAction
{
    public function __construct(
        protected RoleRepositoryInterface $interface
    ) {
    }


    public function execute(array $data): Role
    {
        return DB::transaction(function () use ($data) {
            $data = $this->interface->create($data);
            return $data->fresh();
        });
    }
}
