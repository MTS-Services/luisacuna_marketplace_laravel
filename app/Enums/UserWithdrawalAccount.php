<?php

namespace App\Enums;

enum UserWithdrawalAccount: string
{
    case PENDING = 'pending';
    case ACTIVE = 'active';
    case DECLINED = 'declined';
    public function label(): string
    {
        return match ($this) {
            self::PENDING => 'Pending',
            self::ACTIVE => 'Active',
            self::DECLINED => 'Declined',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::PENDING => 'warning',
            self::ACTIVE => 'success',
            self::DECLINED => 'danger',
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
