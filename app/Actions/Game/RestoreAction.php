<?php

namespace App\Actions\Game;

use App\Repositories\Contracts\GameRepositoryInterface;
use Illuminate\Support\Facades\DB;

class RestoreAction
{
    public function __construct(
        protected GameRepositoryInterface $interface
    ) {}

    public function execute(int $id, ?int $actionerId): bool
    {
        return DB::transaction(function () use ($id, $actionerId) {

            return $this->interface->restore($id, $actionerId);

        });
    }
}
