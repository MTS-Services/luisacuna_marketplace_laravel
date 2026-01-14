<?php

namespace App\Services;

use App\Enums\FeedbackType;
use App\Models\Order;
use App\Models\Product;
use App\Models\Feedback;
use Illuminate\Support\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;

class FeedbackService
{
    /**
     * Create a new class instance.
     */
    public function __construct(protected Feedback $model) {}


    public function getAllDatas(): Collection
    {
        return $this->model->all();
    }

    public function getPaginatedData(int $perPage = 15, array $filters = []): LengthAwarePaginator
    {
        // dd($filters['order_date'] ?? 'order_date not set');
        $sortField = $filters['sort_field'] ?? 'created_at';
        $sortDirection = $filters['sort_direction'] ?? 'desc';

        $feedbacks = $this->model->query()
            ->with('order.source')
            ->filter($filters)
            ->orderBy($sortField, $sortDirection)
            ->paginate($perPage);
        return $feedbacks;
    }

    public function getUserPaginatedData($userId, int $perPage = 15, array $filters = []): LengthAwarePaginator
    {
        // dd($filters['order_date'] ?? 'order_date not set');
        $search = $filters['search'] ?? null;
        $sortField = $filters['sort_field'] ?? 'created_at';
        $sortDirection = $filters['sort_direction'] ?? 'desc';
        $sortDirection = $filters['sort_direction'] ?? 'desc';
        if ($search) {
            // Scout Search
            return Feedback::search($search)
                ->query(fn($query) => $query->filter($filters)->orderBy($sortField, $sortDirection))
                ->paginate($perPage);
        }

        $userfeedbacks = $this->model->query()
            ->with('order.source')
            ->where('target_user_id', $userId)
            ->filter($filters)
            ->orderBy($sortField, $sortDirection)
            ->paginate($perPage);
        return $userfeedbacks;
    }


    public function getFeedbackByOrder(int $orderId, bool $isVisitSeller)
    {
        $user = user();

        return $isVisitSeller
            ? $user->feedbacksReceived()->where('order_id', $orderId)->first()
            : $user->feedbacks()->where('order_id', $orderId)->first();
    }


    /* ================== ================== ==================
     *                   Action Executions
     * ================== ================== ================== */

    public function createData(array $data): Feedback
    {

        $data = $this->model->create($data);

        if (!empty($data)) {
            $freshData = $data->fresh();
            Log::info(
                "Feedback Translations Created",
                [
                    'feedback_id' => $freshData->id,
                    'content' => $freshData->message
                ]
            );
            $freshData->dispatchTranslation(
                defaultLanguageLocale: app()->getLocale() ?? 'en',
                forceTranslation: true,
                targetLanguageIds: null
            );
        }

        return $data;
    }

    public function countByType(FeedbackType $type): int
    {
        return $this->model->where('target_user_id', user()->id)
            ->where('type', $type->value)->count();
    }
}
