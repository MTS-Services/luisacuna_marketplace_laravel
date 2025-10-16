<?php

namespace App\Enums;

enum SellerLevel: string
{
    case BRONZE = 'bronze';
    case SILVER = 'silver';
    case GOLD = 'gold';
    case PLATINUM = 'platinum';
    case DIAMOND = 'diamond';


    public function label(): string
    {
        return match($this) {
            self::BRONZE => 'Bronze',
            self::SILVER => 'Silver',
            self::GOLD => 'Gold',
            self::PLATINUM => 'Platinum',
            self::DIAMOND => 'Diamond',
        };
    }


    public function color(): string
    {
        return match($this) {
            self::BRONZE => 'badge-bronze',
            self::SILVER => 'badge-silver',
            self::GOLD => 'badge-gold',
            self::PLATINUM => 'badge-platinum',
            self::DIAMOND => 'badge-diamond',
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
