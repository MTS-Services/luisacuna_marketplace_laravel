<?php

namespace App\Actions\Rank;

use App\Models\UserRank;
use App\Repositories\Contracts\RankRepositoryInterface;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AssignRankAction
{
    public function __construct(protected RankRepositoryInterface $interface, protected UserRepositoryInterface $userInterface) {}

    public function execute(int $userId, int $rankId): UserRank
    {
        if ($this->userInterface->exists($userId) !== true) {
            Log::error('User not found', ['user_id' => $userId]);
            throw new \Exception(__('User not found.'));
        }
        if ($this->interface->exists($rankId) !== true) {
            Log::error('Rank not found', ['rank_id' => $rankId]);
            throw new \Exception(__('Rank not found'));
        }

        return DB::transaction(function () use ($userId, $rankId) {
            return $this->interface->assignRankToUser($userId, $rankId);
        });
    }
}
