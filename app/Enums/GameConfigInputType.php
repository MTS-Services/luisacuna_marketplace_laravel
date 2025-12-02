<?php

namespace App\Enums;

enum GameConfigInputType: string
{
    //


    case TEXT = 'text';
    case NUMBER = 'number';
    case SELECT_DROPDOWN = 'select_dropdown';

    public function label(): string
    {
        return match ($this) {
            self::TEXT => 'Text',
            self::NUMBER => 'Number',
            self::SELECT_DROPDOWN => 'Select Dropdown',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::TEXT => 'badge-success',
            self::NUMBER => 'badge-info',
            self::SELECT_DROPDOWN => 'badge-warning',
        };
    }

    public static function options(): array
    {
        return array_map(fn($case) => ['value' => $case->value, 'label' => $case->label()], self::cases());
    }

}
