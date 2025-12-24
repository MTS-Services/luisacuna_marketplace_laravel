<?php

namespace App\Enums;

enum CalculationType: string
{
    case CREDIT = 'credit'; // money out
    case DEBIT = 'debit'; // money in

    public function label(): string
    {
        return match ($this) {
            self::CREDIT => 'Credit',
            self::DEBIT => 'Debit',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::DEBIT => 'badge-success',
            self::CREDIT => 'badge-danger',
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
