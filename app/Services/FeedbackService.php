<?php

namespace App\Services;

use App\Models\Feedback;
use Illuminate\Support\Collection;

class FeedbackService
{
    /**
     * Create a new class instance.
     */
    public function __construct(protected Feedback $model) {}


    public function getAllDatas($sortField = 'created_at', $order = 'desc'): Collection
    {
        return $this->model->all($sortField, $order);
    }


    public function getByOrderAndUser(int $orderId, int $userId): ?Feedback
    {
        return Feedback::where('order_id', $orderId)
            ->where(function ($query) use ($userId) {
                $query->where('author_id', $userId)
                    ->orWhere('target_user_id', $userId);
            })
            ->first();
    }

    /* ================== ================== ==================
     *                   Action Executions
     * ================== ================== ================== */

    public function createData(array $data): Feedback
    {
        return $this->model->create($data);
    }
}
