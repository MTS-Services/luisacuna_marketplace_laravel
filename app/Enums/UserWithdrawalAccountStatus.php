<?php

namespace App\Enums;

enum UserWithdrawalAccountStatus: string
{
    case PENDING = 'pending';
    case ACTIVE = 'active';

    case DECLINE = 'decline';

    public function label(): string
    {
        return match($this) {
            self::PENDING => 'Pending',
            self::ACTIVE => 'Active',
            self::DECLINE => 'Decline',
        };
    }

    public function color(): string
    {
        return match($this) {
            self::PENDING => 'badge-warning',
            self::ACTIVE => 'badge-info',
            self::DECLINE => 'badge-danger',
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
