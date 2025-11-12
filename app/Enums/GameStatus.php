<?php

namespace App\Enums;

enum GameStatus :string
{
    //
    case ACTIVE = 'active';
    case INACTIVE = 'inactive';
    case UPCOMING = 'upcoming';

    public function label(): string{
        return match($this){
                self::ACTIVE => 'Active',
                self::INACTIVE => 'Inactive',
                self::UPCOMING => 'Upcoming',
        };
    }

    public function color(): string{
        return match($this){
                self::ACTIVE => 'badge-success',
                self::INACTIVE => 'badge-error',
                self::UPCOMING => 'badge-warning',
        };
    }

    public static function options(): array 
    {
        return array_map(fn($case) => ['value' => $case->value, 'label' => $case->label()], self::cases());
    }
    
}
