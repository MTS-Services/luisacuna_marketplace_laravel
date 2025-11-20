<?php

namespace App\Actions\AchievementType;

use Illuminate\Support\Facades\DB;
use App\Repositories\Contracts\AchievementTypeRepositoryInterface;

class RestoreAction
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        protected AchievementTypeRepositoryInterface $interface
    )
    {}


    public function execute(int $id, ?int $actionerId): bool
    {
        return DB::transaction(function () use ($id, $actionerId) {
            return $this->interface->restore($id, $actionerId);
        });
    }
}
