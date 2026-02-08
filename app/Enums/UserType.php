<?php

namespace App\Enums;

enum UserType: string
{
    case BUYER = 'buyer';
    case SELLER = 'seller';
    case BOTH = 'both';
    public function label(): string
    {
        return match ($this) {
            self::BUYER => 'Buyer',
            self::SELLER => 'Seller',
            self::BOTH => 'Both',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::BUYER => 'badge-success',
            self::SELLER => 'badge-secondary',
            self::BOTH => 'badge-danger',
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
