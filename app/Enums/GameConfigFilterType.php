<?php

namespace App\Enums;

enum GameConfigFilterType: string
{
    //


    case NO_FILTER = 'no_filter';
    case FILTER_BY_SELECT = 'filter_by_select';
    case FILTER_BY_RANGE = 'filter_by_range';

    public function label(): string
    {
        return match ($this) {
            self::NO_FILTER => 'No Filter',
            self::FILTER_BY_SELECT => 'Filter By Select',
            self::FILTER_BY_RANGE => 'Filter By Range',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::NO_FILTER => 'badge-success',
            self::FILTER_BY_SELECT => 'badge-info',
            self::FILTER_BY_RANGE => 'badge-warning',
        };
    }

    public static function options(): array
    {
        return array_map(fn($case) => ['value' => $case->value, 'label' => $case->label()], self::cases());
    }

}
