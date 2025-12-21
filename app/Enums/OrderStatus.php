<?php

namespace App\Enums;

enum OrderStatus: string
{
    case ACTIVE = 'active';
    case PROCESSING = 'processing';
    case COMPLETED = 'completed';
    case PAID = 'paid';
    case CANCELLED = 'cancelled';
    case INITIALIZED = 'initialized';
    case FAILED = 'failed';

    public function label(): string
    {
        return match ($this) {
            self::ACTIVE => 'Active',
            self::PROCESSING => 'Processing',
            self::COMPLETED => 'Completed',
            self::PAID => 'Paid',
            self::CANCELLED => 'Cancelled',
            self::INITIALIZED => 'Initialized',
            self::FAILED => 'Failed',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::ACTIVE => 'badge-success',
            self::PROCESSING => 'badge-warning',
            self::COMPLETED => 'badge-info',
            self::PAID => 'badge-primary',
            self::CANCELLED => 'badge-danger',
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
