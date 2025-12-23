<?php

namespace App\Enums;

enum TransactionStatus: string
{
    case PENDING = 'pending';
    case PROCESSING = 'processing';
    case COMPLETED = 'completed';
    case FAILED = 'failed';
    case CANCELLED = 'cancelled';
    case REVERSED = 'reversed';

    public function label(): string
    {
        return match ($this) {
            self::PENDING => 'Pending',
            self::PROCESSING => 'Processing',
            self::COMPLETED => 'Completed',
            self::FAILED => 'Failed',
            self::CANCELLED => 'Cancelled',
            self::REVERSED => 'Reversed',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::PENDING => 'badge-warning',
            self::PROCESSING => 'badge-info',
            self::COMPLETED => 'badge-success',
            self::FAILED => 'badge-error',
            self::CANCELLED => 'badge-neutral',
            self::REVERSED => 'badge-secondary',
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
