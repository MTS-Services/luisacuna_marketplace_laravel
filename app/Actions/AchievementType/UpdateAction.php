<?php

namespace App\Actions\AchievementType;

use App\Models\AchievementType;
use App\Repositories\Contracts\AchievementTypeRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UpdateAction
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        protected AchievementTypeRepositoryInterface $interface
    ) {}

    public function execute(int $id, array $data): AchievementType
    {
        return DB::transaction(function () use ($id, $data) {
            $findData = $this->interface->find($id);
            if (! $findData) {
                Log::error('Data not found', ['data_id' => $id]);
                throw new \Exception(__('Data not found'));
            }
            $updated = $this->interface->update($id, $data);
            if (! $updated) {
                Log::error('Failed to update data in repository', ['data_id' => $id]);
                throw new \Exception(__('Failed to update data'));
            }

            return $findData->fresh();
        });
    }
}
