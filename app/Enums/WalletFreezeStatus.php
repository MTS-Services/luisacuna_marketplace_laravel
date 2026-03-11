<?php

namespace App\Enums;

enum WalletFreezeStatus: string
{
    case FROZEN = 'frozen';
    case RELEASED = 'released';
    case REFUNDED = 'refunded';
    case EXPIRED = 'expired';
    case CANCELLED = 'cancelled';
    case HOLD = 'hold';
    case SPLIT = 'split';
    case PARTIALLY_REFUNDED = 'partially_refunded';

    public function label(): string
    {
        return match ($this) {
            self::FROZEN => 'Frozen',
            self::RELEASED => 'Released',
            self::REFUNDED => 'Refunded',
            self::EXPIRED => 'Expired',
            self::CANCELLED => 'Cancelled',
            self::HOLD => 'Hold',
            self::PARTIALLY_REFUNDED => 'Partially Refunded',
            self::SPLIT => 'Split',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::FROZEN => 'badge-warning',
            self::RELEASED => 'badge-success',
            self::REFUNDED => 'badge-secondary',
            self::EXPIRED => 'badge-danger',
            self::CANCELLED => 'badge-danger',
            self::HOLD => 'badge-warning',
            self::PARTIALLY_REFUNDED => 'badge-info',
            self::SPLIT => 'badge-info',
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
