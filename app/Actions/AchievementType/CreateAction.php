<?php

namespace App\Actions\AchievementType;

use App\Models\AchievementType;
use Illuminate\Support\Facades\DB;
use App\Repositories\Contracts\AchievementTypeRepositoryInterface;

class CreateAction
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        protected AchievementTypeRepositoryInterface $interface
    ) {}


    public function execute(array $data): AchievementType
    {
        return DB::transaction(function () use ($data) {
            $newData = $this->interface->create($data);
            return $newData->fresh();
        });
    }
}
