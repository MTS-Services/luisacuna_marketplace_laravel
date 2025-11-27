<?php

namespace App\Actions\GameFeature;

use App\Models\GameFeature;
use App\Repositories\Contracts\GameFeatureRepositoryInterface;
use Illuminate\Support\Facades\DB;

class RestoreAction
{
    public function __construct(
        protected GameFeatureRepositoryInterface $interface
    ) {}

    public function execute(int $id, ?int $actionerId): bool
    {
        return DB::transaction(function () use ($id, $actionerId) {
            return $this->interface->restore($id, $actionerId);
        });
    }
}
