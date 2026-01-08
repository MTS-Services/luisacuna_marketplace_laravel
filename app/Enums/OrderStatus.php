<?php

namespace App\Enums;

enum OrderStatus: string
{
    case INITIALIZED = 'initialized';
    case PENDING = 'pending';
    case PENDING_PAYMENT = 'pending_payment';
    case PARTIALLY_PAID = 'partially_paid';
    case PAID = 'paid';
    case PROCESSING = 'processing';
    case DELIVERED = 'delivered';
    case COMPLETED = 'completed';
    case CANCELLED = 'cancelled';
    case REFUNDED = 'refunded';
    case PARTIALLY_REFUNDED = 'partially_refunded';
    case FAILED = 'failed';

    public function label(): string
    {
        return match ($this) {
            self::INITIALIZED => 'Initialized',
            self::PENDING => 'Pending',
            self::PENDING_PAYMENT => 'Pending Payment',
            self::PARTIALLY_PAID => 'Partially Paid',
            self::PAID => 'Progress',
            self::PROCESSING => 'Processing',
            self::DELIVERED => 'Delivered',
            self::COMPLETED => 'Completed',
            self::CANCELLED => 'Cancelled',
            self::REFUNDED => 'Refunded',
            self::PARTIALLY_REFUNDED => 'Partially Refunded',
            self::FAILED => 'Failed',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::INITIALIZED => 'badge-neutral',
            self::PENDING => 'badge-warning',
            self::PENDING_PAYMENT => 'badge-warning',
            self::PARTIALLY_PAID => 'badge-info',
            self::PAID => 'badge-success',
            self::PROCESSING => 'badge-primary',
            self::DELIVERED => 'badge-success',
            self::COMPLETED => 'badge-success',
            self::CANCELLED => 'badge-neutral',
            self::REFUNDED => 'badge-secondary',
            self::PARTIALLY_REFUNDED => 'badge-secondary',
            self::FAILED => 'badge-error',
        };
    }

    public static function options(): array
    {
        return array_map(
            fn($case) => ['value' => $case->value, 'label' => $case->label()],
            self::cases()
        );
    }
}
