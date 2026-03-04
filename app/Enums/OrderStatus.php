<?php

namespace App\Enums;

enum OrderStatus: string
{
    case INITIALIZED = 'initialized';
    case PENDING = 'pending';
    case PAID = 'paid';
    case PROCESSING = 'processing';
    case DELIVERED = 'delivered';
    case COMPLETED = 'completed';
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
            self::PAID => __('Progress'),
            self::PENDING_PAYMENT => __('Pending Payment'),
            self::PARTIALLY_PAID => __('Partially Paid'),
            self::PROCESSING => __('Processing'),
            self::DELIVERED => __('Delivered'),
            self::COMPLETED => __('Completed'),
            self::CANCELLED => __('Cancelled'),
            self::REFUNDED => __('Refunded'),
            self::PARTIALLY_REFUNDED => __('Partially Refunded'),
            self::FAILED => __('Failed'),
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::INITIALIZED => 'badge-neutral',
            self::PENDING => 'badge-warning',
            self::PENDING_PAYMENT => 'badge-warning',
            self::PARTIALLY_PAID => 'badge-warning',
            self::PAID => 'badge-success',
            self::PROCESSING => 'badge-primary',
            self::DELIVERED => 'badge-info',
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
            fn ($case) => ['value' => $case->value, 'label' => $case->label()],
            self::cases()
        );
    }
}
