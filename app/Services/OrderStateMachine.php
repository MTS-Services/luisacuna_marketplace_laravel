<?php

namespace App\Services;

use App\Enums\CustomNotificationType;
use App\Enums\DisputeStatus;
use App\Enums\MessageType;
use App\Enums\OrderStatus;
use App\Enums\ResolutionType;
use App\Models\Admin;
use App\Models\Dispute;
use App\Models\Order;
use App\Models\OrderStatusHistory;
use App\Models\User;
use App\Models\UserDisputeStats;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrderStateMachine
{
    public function __construct(
        protected EscrowService $escrowService,
        protected NotificationService $notificationService,
        protected ConversationService $conversationService,
    ) {}

    /**
     * Transition an order to a new status with full validation and side-effects.
     *
     * @throws \InvalidArgumentException
     * @throws \RuntimeException
     */
    public function transition(Order $order, OrderStatus $targetStatus, ?User $actor = null, array $meta = []): Order
    {
        return DB::transaction(function () use ($order, $targetStatus, $actor, $meta) {
            $order = Order::query()
                ->whereKey($order->getKey())
                ->lockForUpdate()
                ->firstOrFail();

            $currentStatus = $order->status;

            if (! $currentStatus->canTransitionTo($targetStatus)) {
                throw new \InvalidArgumentException(
                    "Invalid transition from [{$currentStatus->value}] to [{$targetStatus->value}] for order #{$order->order_id}."
                );
            }

            $previousStatus = $currentStatus;
            $order->status = $targetStatus;

            $this->applyTransitionSideEffects($order, $previousStatus, $targetStatus, $actor, $meta);

            $order->save();

            $this->logStatusHistory($order, $previousStatus, $targetStatus, $actor, $meta);

            $this->sendTransitionNotifications($order, $previousStatus, $targetStatus, $actor);

            $this->sendSystemConversationMessage($order, $previousStatus, $targetStatus, $actor);

            Log::info('Order state transition', [
                'order_id' => $order->order_id,
                'from' => $previousStatus->value,
                'to' => $targetStatus->value,
                'actor' => $actor?->id,
            ]);

            return $order->fresh();
        });
    }

    /**
     * Apply side-effects for each specific transition.
     */
    protected function applyTransitionSideEffects(
        Order $order,
        OrderStatus $from,
        OrderStatus $to,
        ?User $actor,
        array $meta,
    ): void {
        match (true) {
            $to === OrderStatus::CANCEL_REQ_BY_BUYER => $this->onCancelRequested($order, $actor),
            $to === OrderStatus::CANCEL_REQ_BY_SELLER => $this->onCancelRequested($order, $actor),
            $to === OrderStatus::DELIVERED && $from === OrderStatus::PAID => $this->onDelivered($order),
            $to === OrderStatus::DELIVERED && $from === OrderStatus::DISPUTED => $this->onReDelivered($order),
            $to === OrderStatus::COMPLETED => $this->onCompleted($order),
            $to === OrderStatus::DISPUTED => $this->onDisputed($order, $actor, $meta),
            $to === OrderStatus::ESCALATED => $this->onEscalated($order),
            $to === OrderStatus::CANCELLED && $from === OrderStatus::CANCEL_REQ_BY_BUYER => $this->onCancelledFromRequest($order),
            $to === OrderStatus::CANCELLED && $from === OrderStatus::CANCEL_REQ_BY_SELLER => $this->onCancelledFromRequest($order),
            $to === OrderStatus::CANCELLED && $from === OrderStatus::DELIVERED => $this->onCancelledBySellerAfterDelivery($order),
            $to === OrderStatus::CANCELLED && $from === OrderStatus::DISPUTED => $this->onCancelledBySellerAfterDelivery($order),
            $to === OrderStatus::PAID && $from === OrderStatus::DISPUTED => $this->onDisputeCancelled($order),
            $to === OrderStatus::PAID && $from === OrderStatus::CANCEL_REQ_BY_BUYER => $this->onCancelRejected($order, $actor),
            $to === OrderStatus::PAID && $from === OrderStatus::CANCEL_REQ_BY_SELLER => $this->onCancelRejected($order, $actor),
            $to === OrderStatus::RESOLVED => $this->onResolved($order, $meta),

            $to === OrderStatus::CANCELLED_BY_BUYER => $this->onCancelledByBuyer($order, $actor),
            $to === OrderStatus::CANCELLED_BY_SELLER => $this->onCancelledBySeller($order, $actor),
            $to === OrderStatus::CANCELLED_BY_ADMIN => $this->onCancelledByAdmin($order, $actor),
            default => null,
        };
    }

    protected function onCancelRequested(Order $order, ?User $actor): void
    {
        $order->cancel_attempts = ($order->cancel_attempts ?? 0) + 1;
        $order->auto_cancels_at = now()->addHours(72);
        $order->auto_completes_at = null;

        $buyerId = (int) $order->user_id;
        $order->cancel_requested_by = ($actor && $actor->id === $buyerId) ? 'buyer' : 'seller';
    }

    protected function onDelivered(Order $order): void
    {
        $order->delivered_at = now();
        $order->delivery_attempts = ($order->delivery_attempts ?? 0) + 1;
        $order->auto_completes_at = now()->addHours(72);
        $order->auto_cancels_at = null;
        $order->is_disputed = false;

        $this->escrowService->freezeFunds($order);
    }

    protected function onReDelivered(Order $order): void
    {
        $order->delivered_at = now();
        $order->delivery_attempts = ($order->delivery_attempts ?? 0) + 1;
        $order->auto_completes_at = now()->addHours(72);
        $order->is_disputed = false;
        $this->escrowService->freezeFunds($order);
    }

    protected function onCompleted(Order $order): void
    {
        $order->completed_at = now();
        $order->auto_completes_at = null;
        $order->auto_cancels_at = null;
        $order->is_disputed = false;

        $this->escrowService->releaseFundsToSeller($order);
        $this->incrementOrderStats($order);
    }

    protected function onDisputed(Order $order, ?User $actor, array $meta): void
    {
        $order->is_disputed = true;
        $order->auto_completes_at = null;

        $this->createDisputeRecord($order, $actor, $meta);
    }

    protected function onEscalated(Order $order): void
    {
        $order->escalated_at = now();
        $order->is_disputed = true;
        $order->is_escalated = true;
        $order->auto_completes_at = null;
        $order->auto_cancels_at = null;

        $this->escalateDisputeRecord($order);
        $this->sendEscalatedAutoReply($order);
    }

    protected function onCancelledFromRequest(Order $order): void
    {
        $order->is_disputed = false;
        $order->auto_completes_at = null;
        $order->auto_cancels_at = null;
        $order->cancel_requested_by = null;

        $this->escrowService->refundBuyer($order);
    }

    protected function onCancelledBySellerAfterDelivery(Order $order): void
    {
        $order->is_disputed = false;
        $order->auto_completes_at = null;
        $order->auto_cancels_at = null;

        $this->escrowService->refundBuyer($order);
    }

    protected function onDisputeCancelled(Order $order): void
    {
        $order->is_disputed = false;
        $order->auto_completes_at = now()->addHours(72);
    }

    protected function onCancelRejected(Order $order, ?User $actor): void
    {
        $order->auto_cancels_at = null;
        $order->cancel_requested_by = null;

        if ($order->cancel_attempts >= 2) {
            $order->status = OrderStatus::ESCALATED;
            $this->onEscalated($order);
        }
    }

    protected function onResolved(Order $order, array $meta): void
    {
        $resolutionType = $meta['resolution_type'] ?? null;
        $buyerAmount = $meta['buyer_amount'] ?? null;
        $sellerAmount = $meta['seller_amount'] ?? null;
        $resolvedBy = $meta['resolved_by'] ?? null;
        $notes = $meta['notes'] ?? null;

        $order->resolved_at = now();
        $order->is_disputed = false;
        $order->auto_completes_at = null;
        $order->auto_cancels_at = null;

        if ($resolutionType) {
            $order->resolution_type = $resolutionType;
        }

        if ($buyerAmount !== null) {
            $order->resolution_buyer_amount = $buyerAmount;
        }

        if ($sellerAmount !== null) {
            $order->resolution_seller_amount = $sellerAmount;
        }

        if ($resolvedBy) {
            $order->resolved_by = $resolvedBy;
        }

        if ($notes) {
            $order->resolution_notes = $notes;
        }

        $resolution = $resolutionType instanceof ResolutionType
            ? $resolutionType
            : (is_string($resolutionType) ? ResolutionType::tryFrom($resolutionType) : null);

        if ($resolution) {
            $this->escrowService->applyResolution($order, $resolution);
            $this->updateDisputeStatsOnResolution($order, $resolution);
        }
    }

    /**
     * Create a Dispute record when buyer opens a dispute.
     */
    protected function createDisputeRecord(Order $order, ?User $actor, array $meta): void
    {
        try {
            $order->loadMissing(['source.user']);

            Dispute::query()->create([
                'order_id' => $order->id,
                'buyer_id' => $order->user_id,
                'vendor_id' => $order->source?->user_id,
                'status' => DisputeStatus::PENDING_VENDOR,
                'reason_category' => $meta['reason_category'] ?? null,
                'description' => $meta['dispute_reason'] ?? null,
            ]);
        } catch (\Throwable $e) {
            Log::error('Failed to create dispute record', [
                'order_id' => $order->order_id,
                'error' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Escalate the open dispute record when order reaches ESCALATED.
     */
    protected function escalateDisputeRecord(Order $order): void
    {
        try {
            $dispute = Dispute::query()
                ->where('order_id', $order->id)
                ->whereIn('status', [
                    DisputeStatus::PENDING_VENDOR->value,
                    DisputeStatus::PENDING_REVIEW->value,
                ])
                ->latest('id')
                ->first();

            if ($dispute) {
                $dispute->update(['status' => DisputeStatus::ESCALATED]);
            }
        } catch (\Throwable $e) {
            Log::error('Failed to escalate dispute record', [
                'order_id' => $order->order_id,
                'error' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Increment total_orders in dispute stats when an order completes.
     */
    protected function incrementOrderStats(Order $order): void
    {
        try {
            $order->loadMissing(['source.user']);

            foreach ([$order->user_id, $order->source?->user_id] as $userId) {
                if (! $userId) {
                    continue;
                }

                $stats = UserDisputeStats::query()->firstOrCreate(
                    ['user_id' => $userId],
                    ['total_orders' => 0, 'total_disputes' => 0, 'won_disputes' => 0, 'lost_disputes' => 0],
                );

                $stats->increment('total_orders');
                $stats->recalculateRates();
                $stats->save();
            }
        } catch (\Throwable $e) {
            Log::error('Failed to update dispute stats on completion', [
                'order_id' => $order->order_id,
                'error' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Update buyer and seller dispute stats after admin resolution.
     */
    protected function updateDisputeStatsOnResolution(Order $order, ResolutionType $resolution): void
    {
        try {
            $order->loadMissing(['source.user']);
            $buyerId = $order->user_id;
            $sellerId = $order->source?->user_id;

            $buyerStats = UserDisputeStats::query()->firstOrCreate(
                ['user_id' => $buyerId],
                ['total_orders' => 0, 'total_disputes' => 0, 'won_disputes' => 0, 'lost_disputes' => 0],
            );

            $buyerStats->increment('total_disputes');

            if ($sellerId) {
                $sellerStats = UserDisputeStats::query()->firstOrCreate(
                    ['user_id' => $sellerId],
                    ['total_orders' => 0, 'total_disputes' => 0, 'won_disputes' => 0, 'lost_disputes' => 0],
                );
                $sellerStats->increment('total_disputes');
            }

            match ($resolution) {
                ResolutionType::BuyerWins => (function () use ($buyerStats, $sellerId) {
                    $buyerStats->increment('won_disputes');
                    if ($sellerId) {
                        UserDisputeStats::query()->where('user_id', $sellerId)->increment('lost_disputes');
                    }
                })(),
                ResolutionType::SellerWins => (function () use ($buyerStats, $sellerId) {
                    $buyerStats->increment('lost_disputes');
                    if ($sellerId) {
                        UserDisputeStats::query()->where('user_id', $sellerId)->increment('won_disputes');
                    }
                })(),
                default => null,
            };

            $buyerStats->refresh();
            $buyerStats->recalculateRates();
            $buyerStats->save();

            if ($sellerId) {
                $sellerStats = UserDisputeStats::query()->where('user_id', $sellerId)->first();
                $sellerStats?->recalculateRates();
                $sellerStats?->save();
            }
        } catch (\Throwable $e) {
            Log::error('Failed to update dispute stats on resolution', [
                'order_id' => $order->order_id,
                'error' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Send a system message to the order conversation for each transition.
     */
    protected function sendSystemConversationMessage(
        Order $order,
        OrderStatus $from,
        OrderStatus $to,
        ?User $actor,
    ): void {
        try {
            $conversation = $order->conversation;

            if (! $conversation) {
                return;
            }

            $message = $this->getTransitionMessage($order, $from, $to, $actor);

            if (! $message) {
                return;
            }

            $this->conversationService->sendMessage(
                conversation: $conversation,
                messageBody: $message,
                sender: null,
                messageType: MessageType::SYSTEM ?? MessageType::TEXT,
            );
        } catch (\Throwable $e) {
            Log::error('Failed to send system conversation message', [
                'order_id' => $order->order_id,
                'from' => $from->value,
                'to' => $to->value,
                'error' => $e->getMessage(),
            ]);
        }
    }

    /**
     * @return string|null Human-readable system message for the transition.
     */
    protected function getTransitionMessage(Order $order, OrderStatus $from, OrderStatus $to, ?User $actor): ?string
    {
        $actorName = $actor?->full_name ?? __('System');

        return match (true) {
            $to === OrderStatus::CANCEL_REQ_BY_BUYER => __('Buyer requested to cancel this order.', ['actor' => $actorName]),
            $to === OrderStatus::CANCEL_REQ_BY_SELLER => __('Seller requested to cancel this order.', ['actor' => $actorName]),
            $to === OrderStatus::PAID && $from === OrderStatus::CANCEL_REQ_BY_BUYER => __('Cancellation request was rejected.'),
            $to === OrderStatus::PAID && $from === OrderStatus::CANCEL_REQ_BY_SELLER => __('Cancellation request was rejected.'),
            $to === OrderStatus::CANCELLED && $from === OrderStatus::CANCEL_REQ_BY_BUYER => __('Cancellation accepted. Buyer has been refunded.'),
            $to === OrderStatus::CANCELLED && $from === OrderStatus::CANCEL_REQ_BY_SELLER => __('Cancellation accepted. Seller has been refunded.'),
            $to === OrderStatus::CANCELLED => __('Order has been cancelled. Buyer has been refunded.'),
            $to === OrderStatus::DELIVERED => __(':actor marked the order as delivered.', ['actor' => $actorName]),
            $to === OrderStatus::COMPLETED => $actor ? __(':actor confirmed the delivery. Order completed.', ['actor' => $actorName]) : __('Order auto-completed after 72 hours. Funds released to seller.'),
            $to === OrderStatus::DISPUTED => __(':actor opened a dispute on this order.', ['actor' => $actorName]),
            $to === OrderStatus::PAID && $from === OrderStatus::DISPUTED => __(':actor cancelled the dispute.', ['actor' => $actorName]),
            $to === OrderStatus::ESCALATED => null,
            $to === OrderStatus::RESOLVED => __('This order has been resolved by an administrator.'),
            default => null,
        };
    }

    /**
     * Send an automated support welcome message when escalated.
     */
    protected function sendEscalatedAutoReply(Order $order): void
    {
        try {
            $conversation = $order->conversation;

            if (! $conversation) {
                return;
            }

            $systemMessage = __(
                'Your case is now under review by our support team. An administrator will provide an update or resolution as soon as possible. Thank you for your patience.'
            );

            // $admin = Admin::query()->first();

            // if (! $admin) {
            //     return;
            // }

            $this->conversationService->sendMessage(
                conversation: $conversation,
                messageBody: $systemMessage,
                sender: null,
                messageType: MessageType::SYSTEM,
                metadata: [
                    'order_id' => $order->id,
                    'order_uid' => $order->order_id,
                    'buyer_id' => $order->user_id,
                    'seller_id' => $order->source?->user_id,
                    'order_status' => $order->status->value,
                ]
            );
        } catch (\Throwable $e) {
            Log::error('Failed to send escalated auto-reply', [
                'order_id' => $order->order_id,
                'error' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Log every state change to the order_status_histories table.
     */
    protected function logStatusHistory(
        Order $order,
        OrderStatus $from,
        OrderStatus $to,
        ?User $actor,
        array $meta = [],
    ): void {
        $actorType = 'system';
        $actorId = null;

        if ($actor) {
            $actorId = $actor->id;
            $buyerId = (int) $order->user_id;
            $sellerId = (int) ($order->source?->user_id ?? 0);

            if ($actor->id === $buyerId) {
                $actorType = 'buyer';
            } elseif ($actor->id === $sellerId) {
                $actorType = 'seller';
            }
        }

        if (isset($meta['resolved_by'])) {
            $actorType = 'admin';
            $actorId = $meta['resolved_by'];
        }

        OrderStatusHistory::create([
            'order_id' => $order->id,
            'from_status' => $from->value,
            'to_status' => $to->value,
            'actor_type' => $actorType,
            'actor_id' => $actorId,
            'metadata' => ! empty($meta) ? $meta : null,
        ]);
    }

    /**
     * Send notifications to buyer, seller, and admin on state transitions.
     */
    protected function sendTransitionNotifications(
        Order $order,
        OrderStatus $from,
        OrderStatus $to,
        ?User $actor,
    ): void {
        try {
            $order->loadMissing(['user', 'source.user']);
            $buyer = $order->user;
            $seller = $order->source?->user;

            $title = __('Order #:order updated', ['order' => $order->order_id]);
            $message = __('Order #:order status changed from :from to :to.', [
                'order' => $order->order_id,
                'from' => $from->label(),
                'to' => $to->label(),
            ]);

            $notifyUsers = collect([$buyer, $seller])
                ->filter()
                ->filter(fn(User $u) => ! $actor || $u->id !== $actor->id);

            foreach ($notifyUsers as $user) {
                $this->notificationService->create([
                    'type' => CustomNotificationType::USER,
                    'sender_id' => null,
                    'sender_type' => null,
                    'receiver_id' => $user->id,
                    'receiver_type' => User::class,
                    'is_announced' => false,
                    'action' => route('user.order.detail', $order->order_id),
                    'title' => $title,
                    'message' => $message,
                    'icon' => 'check-circle',
                    'additional' => ['order_id' => $order->order_id],
                ]);
            }

            if ($to === OrderStatus::ESCALATED) {
                $this->notificationService->create([
                    'type' => CustomNotificationType::ADMIN,
                    'sender_id' => null,
                    'sender_type' => null,
                    'receiver_id' => null,
                    'receiver_type' => Admin::class,
                    'is_announced' => false,
                    'action' => route('admin.orders.deep-view', $order->id),
                    'title' => __('Order #:order escalated to support', ['order' => $order->order_id]),
                    'message' => __('Order #:order has been escalated and requires admin attention.', ['order' => $order->order_id]),
                    'icon' => 'exclamation-triangle',
                    'additional' => ['order_id' => $order->order_id],
                ]);
            } else {
                $this->notificationService->create([
                    'type' => CustomNotificationType::ADMIN,
                    'sender_id' => null,
                    'sender_type' => null,
                    'receiver_id' => null,
                    'receiver_type' => Admin::class,
                    'is_announced' => false,
                    'action' => route('admin.orders.show', $order->id),
                    'title' => $title,
                    'message' => $message,
                    'icon' => 'check-circle',
                    'additional' => ['order_id' => $order->order_id],
                ]);
            }
        } catch (\Throwable $e) {
            Log::error('Failed to send order transition notifications', [
                'order_id' => $order->order_id,
                'error' => $e->getMessage(),
            ]);
        }
    }

    protected function onCancelledByBuyer(Order $order, ?User $actor): void
    {
        $order->status = OrderStatus::CANCELLED_BY_BUYER;
        $order->save();
        $this->onCancelRejected($order, $actor);
        $this->escrowService->releaseFundsToSeller($order);
    }

    protected function onCancelledBySeller(Order $order, ?User $actor): void
    {
        $order->status = OrderStatus::CANCELLED_BY_SELLER;
        $order->save();
        $this->onCancelRejected($order, $actor);
        $this->escrowService->refundBuyer($order);
    }

    protected function onCancelledByAdmin(Order $order): void
    {
        $order->status = OrderStatus::CANCELLED_BY_ADMIN;
        $order->save();
    }
}
