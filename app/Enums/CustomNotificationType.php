<?php

namespace App\Enums;

enum CustomNotificationType: string
{
    case USER = 'user';
    case ADMIN = 'admin';
    case PUBLIC = 'public';

    public function label(): string
    {
        return match ($this) {
            self::USER => 'User Announcement',
            self::ADMIN => 'Admin Announcement',
            self::PUBLIC => 'Public Announcement',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::USER => 'badge-success',
            self::ADMIN => 'badge-info',
            self::PUBLIC => 'badge-accent',
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
