<?php

namespace App\Actions\Achievement;

use App\Repositories\Contracts\AchievementRepositoryInterface;
use Illuminate\Support\Facades\DB;

class DeleteAction
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        protected AchievementRepositoryInterface $interface
    )
    {}

    public function execute(int $id, bool $forceDelete = false, int $actionerId): bool
    {
        return DB::transaction(function () use ($id, $forceDelete, $actionerId) {
            $findData = null;

            if ($forceDelete) {
                $findData = $this->interface->findTrashed($id);
            } else {
                $findData = $this->interface->find($id);
            }

            if (!$findData) {
                throw new \Exception('Data not found');
            }
            if ($forceDelete) {
                return $this->interface->forceDelete($id);
            }
            return $this->interface->delete($id, $actionerId);
        });
    }
}
