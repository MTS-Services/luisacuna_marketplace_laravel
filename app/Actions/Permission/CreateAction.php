<?php

namespace App\Actions\Permission;

use App\Models\Permission;
use App\Repositories\Contracts\PermissionRepositoryInterface;
use Illuminate\Support\Facades\DB;

class CreateAction
{
    public function __construct(
        protected PermissionRepositoryInterface $interface
    ) {}


    public function execute(array $data): Permission
    {
        return DB::transaction(function () use ($data) {
            $data = $this->interface->create($data);
            return $data->fresh();
        });
    }
}
