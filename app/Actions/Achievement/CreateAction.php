<?php

namespace App\Actions\Achievement;

use App\Models\Achievement;
use Illuminate\Support\Facades\DB;
use App\Repositories\Contracts\AchievementRepositoryInterface;

class CreateAction
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        protected AchievementRepositoryInterface $interface
    ) {}


    public function execute(array $data): Achievement
    {
        return DB::transaction(function () use ($data) {
            $newData = $this->interface->create($data);
            return $newData->fresh();
        });
    }
}
