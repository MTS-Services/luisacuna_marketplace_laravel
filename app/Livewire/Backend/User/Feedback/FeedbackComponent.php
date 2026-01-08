<?php

namespace App\Livewire\Backend\User\Feedback;

use Livewire\Component;
use App\Enums\OrderStatus;
use App\Enums\FeedbackType;
use Livewire\Attributes\Url;
use App\Services\OrderService;
use App\Services\FeedbackService;
use App\Traits\WithPaginationData;

class FeedbackComponent extends Component
{
    use WithPaginationData;


    #[Url(keep: true)]
    public string $type = 'all';
    public $reviewItem = null;

    protected FeedbackService $service;
    protected OrderService $orderService;

    public function boot(FeedbackService $service, OrderService $orderService)
    {
        $this->service = $service;
        $this->orderService = $orderService;
    }

    public function switchReviewItem($type)
    {
        $this->type = $type;
    }


    public function render()
    {

        $positive = $this->service->countByType(FeedbackType::POSITIVE);
        $negative = $this->service->countByType(FeedbackType::NEGATIVE);
        $order = $this->orderService->countByStatus(OrderStatus::COMPLETED);

        $total = $positive + $negative;

        $feedbackScore = $total > 0
            ? round(($positive / $total) * 100, 2)
            : 0;



        $feedbacks = $this->service->getPaginatedData(
            perPage: 10,
            filters: $this->getFilters()
        );
        $this->paginationData($feedbacks);
        return view('livewire.backend.user.feedback.feedback-component', [
            'feedbacks' => $feedbacks,
            'positiveFeedback' => $positive,
            'negativeFeedback' => $negative,
            'completedOrder' => $order,
            'feedbackScore' => $feedbackScore
        ]);
    }

    protected function getFilters(): array
    {
        return [
            'target_user_id' => user()->id,
            'type' => $this->typeMatch($this->type),
        ];
    }

    protected function typeMatch($type)
    {
        return match ($type) {
            'all' => null,
            'positive' => FeedbackType::POSITIVE,
            'negative' => FeedbackType::NEGATIVE,
        };
    }
}
