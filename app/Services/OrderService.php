<?php

namespace App\Services;

use App\Enums\OrderStatus;
use App\Models\DisputeOrder;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Validation\ValidationException;

class OrderService
{
    public function __construct(
        protected Order $model,
        protected DisputeOrder $disputedOrder,
        protected NotificationService $notificationService,
        protected ConversationService $conversationService
    ) {}

    public function getAllDatas($sortField = 'created_at', $order = 'desc'): Collection
    {
        return $this->model->all($sortField, $order);
    }

    // public function findData($column_value, string $column_name = 'id'): ?Order
    // {
    //     $model = $this->model;

    //     return $model->where($column_name, $column_value)->first();
    // }
    public function findData($column_value, string $column_name = 'id'): ?Order
    {
        $model = $this->model;

        return $model->with(['source', 'user'])
            ->where($column_name, $column_value)
            ->first();
    }

    public function getPaginatedData(int $perPage = 15, array $filters = []): LengthAwarePaginator
    {
        // dd($filters['order_date'] ?? 'order_date not set');
        $sortField = $filters['sort_field'] ?? 'created_at';
        $sortDirection = $filters['sort_direction'] ?? 'desc';

        $orders = $this->model->query()
            ->with(['source.user', 'user', 'source.game'])
            ->filter($filters)
            ->orderBy($sortField, $sortDirection)
            ->paginate($perPage);

        return $orders;
    }

    public function searchData(string $query, $sortField = 'created_at', $order = 'desc'): Collection
    {
        // return $this->model->search($query, $sortField, $order);
        return Collection::empty();
    }

    public function dataExists(int $id): bool
    {
        return $this->model->exists($id);
    }

    public function getDataCount(array $filters = []): int
    {
        return $this->model->count($filters);
    }

    // OrderService.
    public function getAllOrdersForSeller(array $filters)
    {
        return Order::query()
            ->with(['source.user', 'user', 'source.game'])
            ->whereHasMorph('source', ['App\Models\Product'], function ($q) use ($filters) {
                $q->where('user_id', $filters['seller_id']);
            })
            // Skip INITIALIZED orders
            ->where('status', '!=', OrderStatus::INITIALIZED->value)
            ->when(
                $filters['status'] ?? null,
                fn ($q, $status) => $q->where('status', $status)
            )
            ->when(
                $filters['search'] ?? null,
                fn ($q, $search) => $q->where('order_id', 'like', "%{$search}%")
            )
            ->when($filters['order_date'] ?? null, function ($q, $date) {
                match ($date) {
                    'today' => $q->whereDate('created_at', today()),
                    'week' => $q->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]),
                    'month' => $q->whereMonth('created_at', now()->month),
                };
            })
            ->latest()
            ->get();
    }

    public function getAllOrdersForBuyer(array $filters)
    {
        return Order::query()
            ->with(['source.user', 'user', 'source.game'])
            ->where('user_id', $filters['user_id'] ?? user()->id)
            ->where('status', '!=', OrderStatus::INITIALIZED->value)
            ->when(
                $filters['status'] ?? null,
                fn ($q, $status) => $q->where('status', $status)
            )
            ->when(
                $filters['search'] ?? null,
                fn ($q, $search) => $q->where('order_id', 'like', "%{$search}%")
            )
            ->when($filters['order_date'] ?? null, function ($q, $date) {
                match ($date) {
                    'today' => $q->whereDate('created_at', today()),
                    'week' => $q->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]),
                    'month' => $q->whereMonth('created_at', now()->month),
                };
            })
            ->latest()
            ->get();
    }

    /**
     * Transition an order using the state machine.
     * This is the primary method for all order state changes.
     */
    public function transitionOrder(Order $order, OrderStatus $targetStatus, ?User $actor = null, array $meta = []): Order
    {
        $stateMachine = app(OrderStateMachine::class);

        return $stateMachine->transition($order, $targetStatus, $actor, $meta);
    }

    /**
     * @deprecated Use OrderStateMachine::transition() with OrderStatus::DISPUTED instead.
     */
    public function disputeOrder(array $datas): Order
    {
        $order = Order::find($datas['order_id']);
        if (! $order) {
            abort(404, __('Order not found'));
        }

        return $this->transitionOrder($order, OrderStatus::DISPUTED);
    }

    /**
     * @deprecated Use ResolveOrderAction for admin resolutions instead.
     */
    public function disputeResolution($order_id, $disputeType, $reason): void
    {
        $order = Order::find($order_id);
        if (! $order) {
            abort(404, __('Order not found'));
        }

        $targetStatus = match ($disputeType) {
            'accept' => OrderStatus::CANCELLED,
            'reject' => OrderStatus::COMPLETED,
            default => throw new \InvalidArgumentException("Invalid dispute type: {$disputeType}"),
        };

        $this->transitionOrder($order, $targetStatus);
    }

    public function calculateMonthlyTotal(Collection $orders): float
    {
        return $orders->sum('grand_total');
    }

    public function countByStatus(OrderStatus $status): int
    {
        return $this->model->where('status', $status->value)->count();
    }

    /* ================== ================== ==================
     *                   Action Executions
     * ================== ================== ================== */

    // public function createData(array $data): Order
    // {
    //     return $this->model->create($data);
    // }

    // public function createData(array $data)
    // {
    //     $product = $this->model->create($data);
    //     $achievements = Achievement::whereNotNull('target_value')
    //         ->whereHas('achievementType', function ($query) {
    //             $query->where('name', 'Product Purchase');
    //         })
    //         ->get();

    //     foreach ($achievements as $achievement) {

    //         $progress = UserAchievementProgress::firstOrCreate(
    //             [
    //                 'user_id' => user()->id,
    //                 'achievement_id' => $achievement->id,

    //             ],
    //             [
    //                 'current_progress' => 0,
    //             ]
    //         );
    //         $progress->increment('current_progress');

    //         if ($progress->current_progress >= $achievement->target_value) {
    //             $userPoints = UserPoint::firstOrCreate(
    //                 ['user_id' => user()->id],
    //                 ['points' => 0]
    //             );

    //             $userPoints->increment('points', $achievement->point_reward);
    //         }
    //     }
    //     return $product;
    // }

    // public function createData(array $data)
    // {
    //     $product = $this->model->create($data);

    //     $achievements = Achievement::whereNotNull('target_value')
    //         ->whereHas('achievementType', function ($query) {
    //             $query->where('name', 'Product Purchase');
    //         })
    //         ->get();

    //     foreach ($achievements as $achievement) {
    //         $rankId = $achievement->rank_id ?? null;
    //         $progress = UserAchievementProgress::firstOrCreate(
    //             [
    //                 'user_id' => user()->id,
    //                 'achievement_id' => $achievement->id,
    //                 'rank_id' => $rankId,
    //                 'unlocked_at' => now(),
    //             ],
    //             [
    //                 'current_progress' => 0,
    //             ]
    //         );

    //         $progress->increment('current_progress');

    //         if ($progress->current_progress >= $achievement->target_value) {
    //             $userPoints = UserPoint::firstOrCreate(
    //                 ['user_id' => user()->id],
    //                 ['points' => 0],

    //             );

    //             $userPoints->increment('points', $achievement->point_reward);
    //         }
    //     }

    //     return $product;
    // }

    public function createData(array $data)
    {
        if (isset($data['source_type']) && $data['source_type'] === Product::class && isset($data['source_id'], $data['user_id'])) {
            $sourceProduct = Product::find($data['source_id']);
            if ($sourceProduct && (int) $sourceProduct->user_id === (int) $data['user_id']) {
                throw ValidationException::withMessages([
                    'order' => [__('You cannot purchase your own product.')],
                ]);
            }
        }

        $product = $this->model->create($data);

        // $achievements = Achievement::whereNotNull('target_value')
        //     ->whereHas('achievementType', function ($query) {
        //         $query->where('name', 'Product Purchase');
        //     })
        //     ->get();

        // foreach ($achievements as $achievement) {

        //     $rankId = $achievement->rank_id;
        //     $progress = UserAchievementProgress::where('user_id', user()->id)
        //         ->where('achievement_id', $achievement->id)
        //         ->whereNull('achieved_at')
        //         ->latest()
        //         ->first();
        //     if (!$progress || $progress->current_progress >= $achievement->target_value) {

        //         $progress = UserAchievementProgress::create([
        //             'user_id' => user()->id,
        //             'achievement_id' => $achievement->id,
        //             'rank_id' => $rankId,
        //             'current_progress' => 0,
        //             'unlocked_at' => now(),
        //         ]);
        //     }
        //     $progress->increment('current_progress');
        //     if ($progress->current_progress == $achievement->target_value) {
        //         $progress->update([
        //             'achieved_at' => now(),
        //         ]);
        //         $userPoints = UserPoint::firstOrCreate(
        //             ['user_id' => user()->id],
        //             ['points' => 0]
        //         );

        //         $userPoints->increment('points', $achievement->point_reward);
        //     }
        // }

        return $product;
    }

    // Manage Function According to your need
    public function updateData(int $id, array $data): Order
    {
        //  return $this->updateAction->execute($id, $data);
        return new Order;
    }

    public function deleteData(int $id, bool $forceDelete = false, ?int $actionerId = null): bool
    {
        if ($actionerId == null) {
            $actionerId = admin()->id;
        }

        return true;
        // return $this->deleteAction->execute($id, $forceDelete, $actionerId);
    }

    public function restoreData(int $id, ?int $actionerId = null): bool
    {
        if ($actionerId == null) {
            $actionerId = admin()->id;
        }

        return true;
        //  return $this->restoreAction->execute($id, $actionerId);
    }

    public function bulkRestoreData(array $ids, ?int $actionerId = null): int
    {
        if ($actionerId == null) {
            $actionerId = admin()->id;
        }

        return 0;
        //  return $this->bulkAction->execute(ids: $ids, action: 'restore', status: null, actionerId: $actionerId);
    }

    public function bulkForceDeleteData(array $ids, ?int $actionerId = null): int
    {
        if ($actionerId == null) {
            $actionerId = admin()->id;
        }

        return 0;
        //  return $this->bulkAction->execute(ids: $ids, action: 'forceDelete', status: null, actionerId: $actionerId);
    }

    public function bulkDeleteData(array $ids, ?int $actionerId = null): int
    {
        if ($actionerId == null) {
            $actionerId = admin()->id;
        }

        return 0;
        //  return $this->bulkAction->execute(ids: $ids, action: 'delete', status: null, actionerId: $actionerId);
    }

    /* ================== ================== ==================
     *                   Accessors (optionals)
     * ================== ================== ================== */

    public function getActiveData($sortField = 'created_at', $order = 'desc'): Collection
    {
        return $this->model->getActive($sortField, $order);
    }

    public function getInactiveData($sortField = 'created_at', $order = 'desc'): Collection
    {
        return $this->model->getInactive($sortField, $order);
    }
}
