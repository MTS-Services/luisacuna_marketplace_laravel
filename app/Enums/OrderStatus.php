<?php

namespace App\Enums;

enum OrderStatus: string
{
    case INITIALIZED = 'initialized';
    case PENDING = 'pending';
    case PAID = 'paid';
    case PROCESSING = 'processing';
    case CANCEL_REQ_BY_BUYER = 'cancel_req_by_buyer';
    case CANCEL_REQ_BY_SELLER = 'cancel_req_by_seller';
    case DELIVERED = 'delivered';
    case DISPUTED = 'disputed';
    case ESCALATED = 'escalated';
    case CANCELLED_BY_BUYER = 'cancelled_by_buyer';
    case CANCELLED_BY_SELLER = 'cancelled_by_seller';
    case CANCELLED_BY_ADMIN = 'cancelled_by_admin';
    case COMPLETED = 'completed';
    case RESOLVED = 'resolved';
    case CANCELLED = 'cancelled';
    case REFUNDED = 'refunded';
    case PENDING_PAYMENT = 'pending_payment';
    case PARTIALLY_PAID = 'partially_paid';
    case PARTIALLY_REFUNDED = 'partially_refunded';
    case FAILED = 'failed';

    public function label(): string
    {
        return match ($this) {
            self::INITIALIZED => __('Initialized'),
            self::PENDING => __('Pending'),
            self::PAID => __('In Progress'),
            self::PENDING_PAYMENT => __('Pending Payment'),
            self::PARTIALLY_PAID => __('Partially Paid'),
            self::PROCESSING => __('Processing'),
            self::CANCEL_REQ_BY_BUYER => __('Cancellation Requested by Buyer'),
            self::CANCEL_REQ_BY_SELLER => __('Cancellation Requested by Seller'),
            self::DELIVERED => __('Delivered'),
            self::DISPUTED => __('Disputed'),
            self::ESCALATED => __('Escalated'),
            self::CANCELLED_BY_BUYER => __('Cancelled by Buyer'),
            self::CANCELLED_BY_SELLER => __('Cancelled by Seller'),
            self::CANCELLED_BY_ADMIN => __('Cancelled by Admin'),
            self::COMPLETED => __('Completed'),
            self::RESOLVED => __('Resolved'),
            self::CANCELLED => __('Cancelled'),
            self::REFUNDED => __('Refunded'),
            self::PARTIALLY_REFUNDED => __('Partially Refunded'),
            self::FAILED => __('Failed'),
        };
    }

    public function color(): string
    {
        return match ($this) {
            // Basic States
            self::INITIALIZED => 'bg-slate-100 text-slate-800', // Cool Gray

            // Payments
            self::PENDING => 'bg-amber-100 text-amber-800', // Warm Yellow
            self::PENDING_PAYMENT => 'bg-lime-100 text-lime-800',   // High-vis Lime
            self::PARTIALLY_PAID => 'bg-emerald-100 text-emerald-800', // Success-tint Teal
            self::PAID => 'bg-blue-100 text-blue-800',   // Classic Blue

            // Workflow
            self::PROCESSING => 'bg-indigo-100 text-indigo-800', // Deep Indigo
            self::DELIVERED => 'bg-cyan-100 text-cyan-800',   // Bright Cyan
            self::COMPLETED => 'bg-green-100 text-green-800', // Pure Green

            // Requests
            self::CANCEL_REQ_BY_BUYER => 'bg-yellow-100 text-yellow-800', // Soft Gold
            self::CANCEL_REQ_BY_SELLER => 'bg-fuchsia-100 text-fuchsia-800', // Bright Pink

            // The "Alert" Section (Fixed for Contrast)
            self::DISPUTED => 'bg-red-100 text-red-800',     // Standard Alert Red
            self::ESCALATED => 'bg-orange-200 text-orange-900', // Deep Orange/Gold (Distinct from Red)
            self::FAILED => 'bg-stone-200 text-stone-800', // Dead Grey/Brown

            // Cancellations
            self::CANCELLED => 'bg-gray-200 text-gray-800',   // Flat Neutral
            self::CANCELLED_BY_BUYER => 'bg-violet-100 text-violet-800', // Light Violet
            self::CANCELLED_BY_SELLER => 'bg-purple-100 text-purple-800', // Medium Purple
            self::CANCELLED_BY_ADMIN => 'bg-zinc-800 text-zinc-100',   // Inverse (Dark background, light text)

            // Post-Process
            self::RESOLVED => 'bg-teal-100 text-teal-800',   // Seafoam Green
            self::REFUNDED => 'bg-pink-100 text-pink-800',   // Soft Pink
            self::PARTIALLY_REFUNDED => 'bg-sky-100 text-sky-800',     // Light Sky Blue

        };
    }

    public static function options(): array
    {
        return array_map(
            fn ($case) => ['value' => $case->value, 'label' => $case->label()],
            self::cases()
        );
    }

    /**
     * Valid transitions: current status => [allowed next statuses].
     *
     * @return array<string, OrderStatus[]>
     */
    public static function transitionMap(): array
    {
        return [
            self::PAID->value => [
                self::CANCEL_REQ_BY_BUYER,
                self::CANCEL_REQ_BY_SELLER,
                self::DELIVERED,
                self::ESCALATED,
            ],
            self::CANCEL_REQ_BY_BUYER->value => [
                self::PAID,
                self::CANCELLED_BY_BUYER,
                self::ESCALATED,
                self::CANCELLED_BY_BUYER,
                self::CANCELLED,
            ],
            self::CANCEL_REQ_BY_SELLER->value => [
                self::PAID,
                self::CANCELLED_BY_SELLER,
                self::ESCALATED,
                self::CANCELLED_BY_SELLER,
                self::CANCELLED,
            ],
            self::DELIVERED->value => [
                self::COMPLETED,
                self::DISPUTED,
                self::CANCELLED,
                self::CANCELLED_BY_BUYER,
                self::CANCELLED_BY_SELLER,
                self::CANCELLED_BY_ADMIN,
                self::CANCEL_REQ_BY_SELLER,
                self::CANCEL_REQ_BY_BUYER,
                self::ESCALATED,
            ],
            self::DISPUTED->value => [
                self::DELIVERED,
                self::ESCALATED,
                self::PAID,
                self::CANCEL_REQ_BY_BUYER,
                self::CANCEL_REQ_BY_SELLER,
                self::CANCELLED_BY_BUYER,
                self::CANCELLED_BY_SELLER,
                self::CANCELLED_BY_ADMIN,
                self::CANCEL_REQ_BY_SELLER,
                self::CANCEL_REQ_BY_BUYER,
            ],
            self::ESCALATED->value => [
                self::RESOLVED,
                self::CANCEL_REQ_BY_BUYER,
                self::CANCEL_REQ_BY_SELLER,
                self::CANCELLED_BY_BUYER,
                self::CANCELLED_BY_SELLER,
                self::CANCELLED_BY_ADMIN,
                self::CANCEL_REQ_BY_SELLER,
                self::CANCEL_REQ_BY_BUYER,
            ],
            self::COMPLETED->value => [],
            self::RESOLVED->value => [],
            self::CANCELLED->value => [],
            self::CANCELLED_BY_BUYER->value => [
                self::PAID,
                self::DELIVERED,
                self::DISPUTED,
                self::ESCALATED,
                self::COMPLETED,
                self::RESOLVED,
                self::CANCELLED,
            ],
            self::CANCELLED_BY_SELLER->value => [
                self::PAID,
                self::DELIVERED,
                self::DISPUTED,
                self::ESCALATED,
                self::COMPLETED,
                self::RESOLVED,
                self::CANCELLED,
                self::CANCELLED_BY_BUYER,
                self::CANCELLED_BY_SELLER,
                self::CANCELLED_BY_ADMIN,
                self::CANCEL_REQ_BY_SELLER,
                self::CANCEL_REQ_BY_BUYER,
            ],
            self::CANCELLED_BY_ADMIN->value => [
                self::PAID,
                self::DELIVERED,
                self::DISPUTED,
                self::ESCALATED,
                self::COMPLETED,
                self::RESOLVED,
                self::CANCELLED,
            ],
            self::CANCEL_REQ_BY_SELLER->value => [
                self::PAID,
                self::DELIVERED,
                self::DISPUTED,
                self::ESCALATED,
                self::COMPLETED,
                self::RESOLVED,
                self::CANCELLED,
            ],
            self::CANCEL_REQ_BY_BUYER->value => [
                self::PAID,
                self::DELIVERED,
                self::DISPUTED,
                self::ESCALATED,
                self::COMPLETED,
                self::RESOLVED,
                self::CANCELLED,
            ],
        ];
    }

    /**
     * @return OrderStatus[]
     */
    public function allowedTransitions(): array
    {
        return self::transitionMap()[$this->value] ?? [];
    }

    public function canTransitionTo(self $target): bool
    {
        return in_array($target, $this->allowedTransitions(), true);
    }

    /**
     * Actions a BUYER can perform given the current order status.
     *
     * @return string[]
     */
    public function buyerActions(): array
    {
        return match ($this) {
            self::PAID => ['cancel_order'],
            self::CANCEL_REQ_BY_BUYER => ['escalate_to_support'],
            self::CANCEL_REQ_BY_SELLER => ['escalate_to_support'],
            self::DELIVERED => ['confirm_delivery', 'open_dispute'],
            self::DISPUTED => ['escalate_to_support', 'cancel_dispute'],
            self::COMPLETED, self::RESOLVED => ['leave_review'],
            self::CANCELLED_BY_BUYER => ['accept_cancel', 'reject_cancel'],
            self::CANCELLED_BY_SELLER => ['accept_cancel', 'reject_cancel'],
            self::CANCELLED_BY_ADMIN => ['accept_cancel', 'reject_cancel'],
            default => [],
        };
    }

    /**
     * Actions a SELLER can perform given the current order status.
     *
     * @return string[]
     */
    public function sellerActions(): array
    {
        return match ($this) {
            self::PAID => ['mark_delivered', 'cancel_order'],
            self::CANCEL_REQ_BY_BUYER => ['accept_cancel', 'reject_cancel'],
            self::CANCEL_REQ_BY_SELLER => ['accept_cancel', 'reject_cancel'],
            self::DELIVERED => ['cancel_order'],
            self::DISPUTED => ['cancel_order', 'mark_delivered', 'escalate_to_support'],
            self::ESCALATED => ['cancel_order'],
            self::CANCELLED_BY_BUYER => ['accept_cancel', 'reject_cancel'],
            self::CANCELLED_BY_SELLER => ['accept_cancel', 'reject_cancel'],
            self::CANCELLED_BY_ADMIN => ['accept_cancel', 'reject_cancel'],
            default => [],
        };
    }

    public function isTerminal(): bool
    {
        return in_array($this, [
            self::COMPLETED,
            self::RESOLVED,
            self::CANCELLED,
            self::REFUNDED,
            self::CANCELLED_BY_BUYER,
            self::CANCELLED_BY_SELLER,
            self::CANCELLED_BY_ADMIN,
        ], true);
    }

    public function isActive(): bool
    {
        return in_array($this, [
            self::PAID,
            self::CANCEL_REQ_BY_BUYER,
            self::CANCEL_REQ_BY_SELLER,
            self::DELIVERED,
            self::DISPUTED,
            self::ESCALATED,
            self::CANCELLED_BY_BUYER,
            self::CANCELLED_BY_SELLER,
            self::CANCELLED_BY_ADMIN,
        ], true);
    }

    public function isEscalated(): bool
    {
        return in_array($this, [
            self::ESCALATED,
        ], true);
    }

    public function isChatLocked(): bool
    {
        return in_array($this, [
            self::ESCALATED,
            self::COMPLETED,
            self::RESOLVED,
            self::CANCELLED,
            self::CANCELLED_BY_BUYER,
            self::CANCELLED_BY_SELLER,
            self::CANCELLED_BY_ADMIN,
        ], true);
    }
}
