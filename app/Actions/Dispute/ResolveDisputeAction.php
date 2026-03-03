<?php

namespace App\Actions\Dispute;

use App\Enums\CustomNotificationType;
use App\Enums\DisputeStatus;
use App\Enums\EmailTemplateEnum;
use App\Enums\MessageType;
use App\Enums\OrderStatus;
use App\Models\Admin;
use App\Models\Dispute;
use App\Models\User;
use App\Services\NotificationService;
use App\Jobs\Order\DisputeResolutionEmailJob;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ResolveDisputeAction
{
    public function __construct(
        protected NotificationService $notificationService,
    ) {}

    public function execute(Dispute $dispute, DisputeStatus $status, ?string $adminNote = null): Dispute
    {
        return DB::transaction(function () use ($dispute, $status, $adminNote) {
            $dispute = Dispute::query()
                ->whereKey($dispute->getKey())
                ->lockForUpdate()
                ->firstOrFail();

            $order = $dispute->order()
                ->with(['user', 'source.user'])
                ->lockForUpdate()
                ->first();

            if (! $order) {
                throw new \RuntimeException('Order not found for dispute.');
            }

            if ($dispute->status instanceof DisputeStatus && $dispute->status->isResolved()) {
                return $dispute;
            }

            $dispute->status = $status;

            if ($status->isResolved() && $dispute->resolved_at === null) {
                $dispute->resolved_at = now();
            }

            if ($status === DisputeStatus::RESOLVED_REFUND) {
                $order->status = OrderStatus::CANCELLED;
                $order->is_disputed = false;
            } elseif ($status === DisputeStatus::RESOLVED_CLOSED) {
                $order->status = OrderStatus::COMPLETED;
                $order->is_disputed = false;
            } elseif ($status === DisputeStatus::ESCALATED) {
                $order->is_disputed = true;
            }

            $order->save();

            if ($adminNote !== null && function_exists('admin') && admin()) {
                $dispute->messages()->create([
                    'sender_id' => admin()->id,
                    'sender_role' => 'admin',
                    'message' => $adminNote,
                    'meta' => [
                        'status' => $status->value,
                        'system' => true,
                    ],
                ]);
            }

            $dispute->save();

            $this->notifyParties($dispute, $order->order_id, $status);

            $this->dispatchEmails($dispute, $order->id);

            return $dispute->fresh(['order', 'buyer', 'vendor']);
        });
    }

    protected function notifyParties(Dispute $dispute, string $orderNumber, DisputeStatus $status): void
    {
        $buyer = $dispute->buyer;
        $vendor = $dispute->vendor;

        $title = __('Your dispute has been updated');
        $message = match ($status) {
            DisputeStatus::RESOLVED_REFUND => __("Your dispute for order #:order has been resolved with a refund.", ['order' => $orderNumber]),
            DisputeStatus::RESOLVED_CLOSED => __("Your dispute for order #:order has been closed and payment released.", ['order' => $orderNumber]),
            DisputeStatus::ESCALATED => __("Your dispute for order #:order has been escalated to an administrator.", ['order' => $orderNumber]),
            DisputeStatus::PENDING_VENDOR => __("A new dispute has been opened for order #:order.", ['order' => $orderNumber]),
        };

        try {
            if ($buyer instanceof User) {
                $this->notificationService->create([
                    'type' => CustomNotificationType::USER,
                    'sender_id' => null,
                    'sender_type' => null,
                    'receiver_id' => $buyer->id,
                    'receiver_type' => User::class,
                    'is_announced' => false,
                    'action' => route('user.order.detail', $orderNumber),
                    'title' => $title,
                    'message' => $message,
                    'icon' => 'check-circle',
                    'additional' => [
                        'order_id' => $orderNumber,
                    ],
                ]);
            }

            if ($vendor instanceof User) {
                $this->notificationService->create([
                    'type' => CustomNotificationType::USER,
                    'sender_id' => null,
                    'sender_type' => null,
                    'receiver_id' => $vendor->id,
                    'receiver_type' => User::class,
                    'is_announced' => false,
                    'action' => route('user.order.detail', $orderNumber),
                    'title' => $title,
                    'message' => $message,
                    'icon' => 'check-circle',
                    'additional' => [
                        'order_id' => $orderNumber,
                    ],
                ]);
            }

            $this->notificationService->create([
                'type' => CustomNotificationType::ADMIN,
                'sender_id' => null,
                'sender_type' => null,
                'receiver_id' => null,
                'receiver_type' => Admin::class,
                'is_announced' => false,
                'action' => route('user.order.detail', $orderNumber),
                'title' => __('A dispute has been resolved'),
                'message' => __("Dispute for order #:order has been updated to :status.", [
                    'order' => $orderNumber,
                    'status' => $status->label(),
                ]),
                'icon' => 'check-circle',
                'additional' => [
                    'order_id' => $orderNumber,
                ],
            ]);
        } catch (\Throwable $e) {
            Log::error('Failed to send dispute notifications', [
                'dispute_id' => $dispute->id,
                'error' => $e->getMessage(),
            ]);
        }
    }

    protected function dispatchEmails(Dispute $dispute, int $orderId): void
    {
        try {
            $vendor = $dispute->vendor;

            if ($vendor instanceof User && $vendor->email) {
                DisputeResolutionEmailJob::dispatch(
                    $orderId,
                    $vendor->email,
                    $vendor->full_name,
                    EmailTemplateEnum::ORDER_DISPUTE_RESOLVED_SELLER->value,
                );
            }
        } catch (\Throwable $e) {
            Log::error('Failed to dispatch dispute resolution email', [
                'dispute_id' => $dispute->id,
                'error' => $e->getMessage(),
            ]);
        }
    }
}

