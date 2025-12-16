<?php

namespace App\Enums;

use Illuminate\Database\Eloquent\Builder;

enum CustomNotificationType: string
{
    case PUBLIC = 'public';
    case USER = 'user';
    case ADMIN = 'admin';

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

    // Scopes 
    public function scopeForCurrentUser(Builder $query): Builder
    {
        return $query->where('type', user()->isAdmin() ? self::ADMIN : self::USER);
    }

    public function scopeForAdmin(Builder $query): Builder
    {
        return $query->where('type', self::ADMIN);
    }

    public function scopeForPublic(Builder $query): Builder
    {
        return $query->where('type', self::PUBLIC);
    }
}
