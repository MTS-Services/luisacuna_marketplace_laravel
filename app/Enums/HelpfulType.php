<?php

namespace App\Enums;

enum HelpfulType: string
{
    case POSITIVE = 'positive';
    case NEGATIVE = 'negative';

    public function label(): string
    {
        return match ($this) {
            self::POSITIVE => __('positive'),
            self::NEGATIVE => __('negative'),
        };
    }

    public function color(): string
    {
        return match ($this) {
            // self::POSITIVE => 'success',
        };
    }

    public static function options(): array
    {
        return array_map(
            fn ($case) => ['value' => $case->value, 'label' => $case->label()],
            self::cases()
        );
    }
}
