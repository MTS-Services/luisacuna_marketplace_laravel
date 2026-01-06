<?php

namespace App\Enums;

enum FeedbackType: string
{
    case POSITIVE = 'positive';
    case NEGATIVE = 'negative';

    public function label(): string
    {
        return match ($this) {
            self::POSITIVE => 'Positive',
            self::NEGATIVE => 'Negative',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::POSITIVE => 'badge-success',
            self::NEGATIVE => 'badge-danger',
        };
    }

    public static function options(): array
    {
        return array_map(
            fn($case) => ['value' => $case->value, 'label' => $case->label()],
            self::cases()
        );
    }

    public function icon()
    {
        return match ($this) {
            self::POSITIVE => 'thumbs-up',
            self::NEGATIVE => 'thumbs-down',
        };
    }
    public function iconColor()
    {
        return match ($this) {
            self::POSITIVE => 'fill-zinc-500 ',
            self::NEGATIVE => 'fill-pink-500 ',
        };
    }
}
