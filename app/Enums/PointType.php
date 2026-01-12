<?php

namespace App\Enums;

enum PointType: string
{
    case EARNED = 'earned';
    case SPEND = 'spend';
    case REWARD = 'reward';
    case REFUND = 'refund';

    public function label(): string
    {
        return match ($this) {
            self::EARNED => 'Earned',
            self::SPEND => 'Spend',
            self::REWARD => 'Reward',
            self::REFUND => 'Refund',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::EARNED => 'badge-success',
            self::SPEND => 'badge-danger',
            self::REWARD => 'badge-warning',
            self::REFUND => 'badge-info',
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
