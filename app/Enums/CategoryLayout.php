<?php

namespace App\Enums;

enum CategoryLayout: string
{
    //
    case LIST_GRID = 'list_grid';
    case GROUP_GIFT_CARD = 'group_gift_card';

    public function label(): string
    {
        return match($this) {
            self::LIST_GRID => 'List Grid',
            self::GROUP_GIFT_CARD => 'Group Gift Card',
        };
    }

   public function color(): string
    {
        return match ($this) {
            self::LIST_GRID => 'badge-info',
            self::GROUP_GIFT_CARD => 'badge-primary',
        };
    }

    public static function options(): array
    {
        return array_map(fn($case) => ['value' => $case->value, 'label' => $case->label()], self::cases());
    }
}
