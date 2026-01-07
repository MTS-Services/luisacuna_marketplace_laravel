<?php

namespace App\Services;

use App\Models\Rank;
use App\Models\User;
use App\Models\UserRank;
use App\Enums\RankStatus;
use App\Actions\Rank\BulkAction;
use App\Actions\Rank\CreateAction;
use App\Actions\Rank\DeleteAction;
use App\Actions\Rank\UpdateAction;
use Illuminate\Support\Facades\DB;
use App\Actions\Rank\RestoreAction;
use App\Actions\Rank\AssignRankAction;
use App\Models\Achievement;
use Illuminate\Database\Eloquent\Collection;
use App\Repositories\Contracts\RankRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;


class RankService
{
    public function __construct(
        protected RankRepositoryInterface $interface,
        protected CreateAction $createAction,
        protected UpdateAction $updateAction,
        protected DeleteAction $deleteAction,
        protected RestoreAction $restoreAction,
        protected BulkAction $bulkAction,
        protected AssignRankAction $assignRankAction,
    ) {
    }

    /* ================== ================== ==================
     *                          Find Methods
     * ================== ================== ================== */

    public function getAllDatas($sortField = 'created_at', $order = 'desc'): Collection
    {
        return $this->interface->all($sortField, $order);
    }

    public function findData($column_value, string $column_name = 'id'): ?Rank
    {
        return $this->interface->find($column_value, $column_name);
    }

    public function getPaginatedData(int $perPage = 15, array $filters = []): LengthAwarePaginator
    {
        return $this->interface->paginate($perPage, $filters);
    }

    public function getTrashedPaginatedData(int $perPage = 15, array $filters = []): LengthAwarePaginator
    {
        return $this->interface->trashPaginate($perPage, $filters);
    }

    public function searchData(string $query, $sortField = 'created_at', $order = 'desc'): Collection
    {
        return $this->interface->search($query, $sortField, $order);
    }

    public function dataExists(int $id): bool
    {
        return $this->interface->exists($id);
    }

    public function getDataCount(array $filters = []): int
    {
        return $this->interface->count($filters);
    }




    // get next available rank
    public function getNextRank($currentRankId)
    {
        return $this->interface->getNextRank($currentRankId);
    }

    public function calculatePointsNeeded($userPoints, $nextRank)
    {
        if (!$nextRank) {
            return 0;
        }

        return max(0, $nextRank->minimum_points - $userPoints);
    }



    // public function getRankByPoints(int $points): ?Rank
    // {
    //     return Rank::where('minimum_points', '<=', $points)
    //         ->where('maximum_points', '>=', $points)
    //         ->with('achievements.progress')
    //         ->first();
    // }

    public function getUserRank($userId = null)
    {
        $userId = $userId ?? user()->id;
        $rank = User::findOrfail($userId)?->activeRank?->first();
        return $rank;
    }

    public function getUserAchievements($userId = null, $rankId = null)
    {
        $userId = $userId ?? user()->id;
        $rankId = $rankId ?? $this->getUserRank($userId)->id;

        $achievements = Achievement::where('rank_id', $rankId)
                        ->with([
                            'progress' => function ($q) use ($userId) {
                                $q->where('user_id', $userId)->whereNotNull('unlocked_at');
                            }
                        ])->whereHas('progress', function ($q) use ($userId) {
                            $q->where('user_id', $userId)
                                ->whereNotNull('unlocked_at');
                                // ->whereNull('achieved_at');
                        })->get();
        return $achievements;
    }



    // REDEEM
    public function redeemUserPoints($user, $points = 10000): bool
    {
        if (($user->userPoint->points ?? 0) < $points) {
            return false;
        }

        DB::transaction(function () use ($user, $points) {
            $user->userPoint->points -= $points;
            $user->userPoint->save();


            $wallet = $user->wallet;

            if (!$wallet) {
                $wallet = $user->wallet()->create([
                    'balance' => 0,
                ]);
            }
            $wallet->balance += 1;
            $wallet->save();
        });

        return true;
    }


    /* ================== ================== ==================
     *                   Action Executions
     * ================== ================== ================== */

    public function createData(array $data): Rank
    {
        return $this->createAction->execute($data);
    }

    public function assignRankToUser(int $userId, int $rankId): UserRank
    {
        return $this->assignRankAction->execute($userId, $rankId);
    }
    public function updateData(int $id, array $data): Rank
    {
        return $this->updateAction->execute($id, $data);
    }

    public function deleteData(int $id, bool $forceDelete = false, ?int $actionerId = null): bool
    {
        if ($actionerId == null) {
            $actionerId = admin()->id;
        }
        return $this->deleteAction->execute($id, $forceDelete, $actionerId);
    }

    public function restoreData(int $id, ?int $actionerId = null): bool
    {
        if ($actionerId == null) {
            $actionerId = admin()->id;
        }
        return $this->restoreAction->execute($id, $actionerId);
    }

    public function updateStatusData(int $id, RankStatus $status, ?int $actionerId = null): Rank
    {
        if ($actionerId == null) {
            $actionerId = admin()->id;
        }

        return $this->updateAction->execute($id, [
            'status' => $status->value,
            'updated_by' => $actionerId,
        ]);
    }
    public function bulkRestoreData(array $ids, ?int $actionerId = null): int
    {
        if ($actionerId == null) {
            $actionerId = admin()->id;
        }
        return $this->bulkAction->execute(ids: $ids, action: 'restore', status: null, actionerId: $actionerId);
    }

    public function bulkForceDeleteData(array $ids, ?int $actionerId = null): int
    {
        if ($actionerId == null) {
            $actionerId = admin()->id;
        }
        return $this->bulkAction->execute(ids: $ids, action: 'forceDelete', status: null, actionerId: $actionerId);
    }

    public function bulkDeleteData(array $ids, ?int $actionerId = null): int
    {
        if ($actionerId == null) {
            $actionerId = admin()->id;
        }
        return $this->bulkAction->execute(ids: $ids, action: 'delete', status: null, actionerId: $actionerId);
    }
    public function bulkUpdateStatus(array $ids, RankStatus $status, ?int $actionerId = null): int
    {
        if ($actionerId == null) {
            $actionerId = admin()->id;
        }
        return $this->bulkAction->execute(ids: $ids, action: 'status', status: $status->value, actionerId: $actionerId);
    }

    /* ================== ================== ==================
     *                   Accessors (optionals)
     * ================== ================== ================== */

    public function getActiveData($sortField = 'created_at', $order = 'desc'): Collection
    {
        return $this->interface->getActive($sortField, $order);
    }

    public function getInactiveData($sortField = 'created_at', $order = 'desc'): Collection
    {
        return $this->interface->getInactive($sortField, $order);
    }
}
