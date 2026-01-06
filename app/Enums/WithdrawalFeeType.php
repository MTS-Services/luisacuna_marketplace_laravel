<?php

namespace App\Enums;

enum WithdrawalFeeType: string
{

    case FIXED = 'fixed';
    case PERCENTAGE = 'percentage';

    public function label(): string
    {
        return match ($this) {
            self::FIXED => 'Fixed',
            self::PERCENTAGE => 'Percentage',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::FIXED => 'badge-info',
            self::PERCENTAGE => 'badge-warning',
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
