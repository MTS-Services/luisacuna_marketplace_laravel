<?php

namespace App\Actions\Tag;

use Illuminate\Support\Facades\DB;
use App\Repositories\Contracts\TagRepositoryInterface;

class RestoreAction{

    public function __construct(protected TagRepositoryInterface $interface){}



    public function execute(int $id, ?int $actionerId): bool
    {
        return DB::transaction(function () use ($id, $actionerId) {
            return $this->interface->restore($id, $actionerId);
        });
    }
}
