<?php

namespace App\Livewire\Backend\User\Orders;

use App\Enums\FeedbackType;
use App\Enums\OrderStatus;
use App\Models\Order;
use App\Models\OrderDelivery;
use App\Services\OrderService;
use App\Services\OrderStateMachine;
use App\Traits\Livewire\WithNotification;
use Livewire\Component;
use Livewire\WithFileUploads;

class Details extends Component
{
    use WithFileUploads, WithNotification;

    public Order $data;

    public bool $isSeller = false;

    public bool $isBuyer = false;

    public int $positiveFeedbacksCount = 0;

    public int $negativeFeedbacksCount = 0;

    /** @var string[] */
    public array $availableActions = [];

    public ?string $autoCompletesIn = null;

    public string $deliveryMessage = '';

    /** @var array<int, \Livewire\Features\SupportFileUploads\TemporaryUploadedFile> */
    public array $deliveryFiles = [];

    public string $disputeReason = '';

    protected OrderService $orderService;

    protected OrderStateMachine $stateMachine;

    public function boot(OrderService $orderService, OrderStateMachine $stateMachine): void
    {
        $this->orderService = $orderService;
        $this->stateMachine = $stateMachine;
    }

    public function mount($orderId): void
    {
        $this->data = $this->orderService->findData($orderId, 'order_id');

        if (! $this->data) {
            abort(404);
        }

        $this->data->load(['source.user', 'source.game', 'user', 'conversation']);

        $userId = (int) user()->id;
        $this->isBuyer = (int) $this->data->user_id === $userId;
        $this->isSeller = (int) ($this->data->source?->user_id ?? 0) === $userId;

        if (! $this->isBuyer && ! $this->isSeller) {
            abort(403);
        }

        // $this->refreshActions();

        $sellerUser = $this->isSeller ? $this->data->user : $this->data->source?->user;
        $this->positiveFeedbacksCount = $sellerUser?->feedbacksReceived()
            ->where('type', FeedbackType::POSITIVE->value)->count() ?? 0;
        $this->negativeFeedbacksCount = $sellerUser?->feedbacksReceived()
            ->where('type', FeedbackType::NEGATIVE->value)->count() ?? 0;
    }

    protected function refreshActions(): void
    {
        $status = $this->data->status;

        $this->availableActions = $this->isBuyer
            ? $status->buyerActions()
            : $status->sellerActions();

        $this->autoCompletesIn = null;
        if ($this->data->auto_completes_at && $this->data->status === OrderStatus::DELIVERED) {
            $this->autoCompletesIn = $this->data->auto_completes_at->diffForHumans();
        }
    }

    public function cancelOrder(): void
    {
        // $this->executeTransition(OrderStatus::CANCEL_REQ_BY_BUYER);
        // $this->executeTransition(OrderStatus::CANCEL_REQ_BY_SELLER);
    }

    public function markDelivered(): void
    {
        $this->validate([
            'deliveryMessage' => 'required|string|min:10|max:5000',
        ]);

        if (($this->data->delivery_attempts ?? 0) >= 3) {
            $this->error(__('Maximum delivery attempts reached. This order has been escalated to support.'));
            $this->executeTransition(OrderStatus::ESCALATED);

            return;
        }

        $filePaths = [];
        foreach ($this->deliveryFiles as $file) {
            $filePaths[] = $file->store('order-deliveries', 'public');
        }

        OrderDelivery::query()->create([
            'order_id' => $this->data->id,
            'seller_id' => user()->id,
            'delivery_message' => $this->deliveryMessage,
            'files' => ! empty($filePaths) ? $filePaths : null,
        ]);

        $this->executeTransition(OrderStatus::DELIVERED);

        $this->reset('deliveryMessage', 'deliveryFiles');
    }

    public function confirmDelivery(): void
    {
        $this->executeTransition(OrderStatus::COMPLETED);
    }

    public function openDispute(): void
    {
        $this->validate([
            'disputeReason' => 'required|string|min:10|max:5000',
        ]);

        $this->executeTransition(OrderStatus::DISPUTED, [
            'dispute_reason' => $this->disputeReason,
        ]);

        $this->reset('disputeReason');
    }

    public function escalateToSupport(): void
    {
        $this->executeTransition(OrderStatus::ESCALATED);
    }

    public function cancelDispute(): void
    {
        $this->executeTransition(OrderStatus::PAID);
    }

    public function acceptCancel(): void
    {
        $this->executeTransition(OrderStatus::CANCELLED);
    }

    public function rejectCancel(): void
    {
        $this->executeTransition(OrderStatus::PAID);
    }

    protected function executeTransition(OrderStatus $targetStatus, array $meta = []): void
    {
        try {
            $this->data = $this->stateMachine->transition(
                order: $this->data,
                targetStatus: $targetStatus,
                actor: user(),
                meta: $meta,
            );

            $this->refreshActions();
            $this->success(__('Order updated successfully.'));
        } catch (\InvalidArgumentException $e) {
            $this->error($e->getMessage());
        } catch (\Throwable $e) {
            $this->error(__('Something went wrong. Please try again.'));
        }
    }

    public function render()
    {
        return view('livewire.backend.user.orders.details');
    }
}
