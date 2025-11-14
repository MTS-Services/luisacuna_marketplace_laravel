<?php

namespace App\Actions\Achievement;

use Illuminate\Support\Facades\DB;
use App\Repositories\Contracts\AchievementRepositoryInterface;

class RestoreAction
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        protected AchievementRepositoryInterface $interface
    )
    {}

    public function execute(int $id, ?int $actionerId): bool
    {
        return DB::transaction(function () use ($id, $actionerId) {
            return $this->interface->restore($id, $actionerId);
        });
    }
}
