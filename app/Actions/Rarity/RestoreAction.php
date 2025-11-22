<?php

namespace App\Actions\Rarity;

use Illuminate\Support\Facades\DB;
use App\Repositories\Contracts\RarityRepositoryInterface;

class RestoreAction{

    public function __construct(protected RarityRepositoryInterface $interface){}



    public function execute(int $id, ?int $actionerId): bool
    {
        return DB::transaction(function () use ($id, $actionerId) {
            return $this->interface->restore($id, $actionerId);
        });
    }
}
