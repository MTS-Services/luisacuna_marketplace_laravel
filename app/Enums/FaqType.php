<?php

namespace App\Enums;

enum FaqType: string
{

    case BUYER = 'buyer';
    case SELLER = 'seller';

    public function label(): string
    {
        return match ($this) {
            self::BUYER => 'Buyer',
            self::SELLER => 'Seller',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::BUYER => 'badge-success',
            self::SELLER => 'badge-info',
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
