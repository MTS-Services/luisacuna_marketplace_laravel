<?php

namespace App\Enums;

enum OrderStatus: string
{
    case ACTIVE = 'active';
    case PROCESSING = 'processing';
    case DELIVERED = 'delivered';
    case COMPLETED = 'completed';
    case CANCELLED = 'cancelled';
    case INITIALIZED = 'initialized';
    case FAILED = 'failed';

    public function label(): string
    {
        return match ($this) {
            self::ACTIVE => 'Active',
            self::PROCESSING => 'Processing',
            self::COMPLETED => 'Completed',
            self::DELIVERED => 'Delivered',
            self::CANCELLED => 'Cancelled',
            self::INITIALIZED => 'Initialized',
            self::FAILED => 'Failed',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::ACTIVE => 'badge-info',
            self::PROCESSING => 'badge-warning',
            self::COMPLETED => 'badge-accent',
            self::CANCELLED => 'badge-danger',
            self::DELIVERED => 'badge-success',
            self::INITIALIZED => 'badge-secondary',
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
