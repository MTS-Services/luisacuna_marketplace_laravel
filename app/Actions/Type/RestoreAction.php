<?php

namespace App\Actions\Type;

use Illuminate\Support\Facades\DB;
use App\Repositories\Contracts\TypeRepositoryInterface;

class RestoreAction{

    public function __construct(protected TypeRepositoryInterface $interface){}



    public function execute(int $id, ?int $actionerId): bool
    {
        return DB::transaction(function () use ($id, $actionerId) {
            return $this->interface->restore($id, $actionerId);
        });
    }
}
