<?php

namespace App\Enums;

enum GameDeliveryMethod: string
{
    case INSTANT_DELIVERY = 'instant_delivery';
    case MANUAL_DELIVERY = 'manual_delivery';

    public function label(): string
    {
        return match ($this) {
            self::INSTANT_DELIVERY => 'Instant Delivery',
            self::MANUAL_DELIVERY => 'Manual Delivery',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::INSTANT_DELIVERY => 'badge-success',
            self::MANUAL_DELIVERY => 'badge-warning',
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
