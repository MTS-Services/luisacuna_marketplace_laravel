<?php

namespace App\Services;

use App\Models\Feedback;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

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

        $data = $this->model->create($data);

        if(!empty($data)){
            $freshData = $data->fresh();
            Log::info("Feedback Translations Created", [
                'feedback_id' => $freshData->id,
                'content' => $freshData->message]
            );
            $freshData->dispatchTranslation(
                defaultLanguageLocale: app()->getLocale() ?? 'en',
                forceTranslation: true,
                targetLanguageIds: null
            );
        }

        return $data; 
    }
}
