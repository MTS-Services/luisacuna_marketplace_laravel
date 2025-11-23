<?php
 
namespace App\Enums;
 
enum GameTag: string
{
    case POPULAR = 'popular';
    case TRENDING = 'trending';
    case HOT = 'hot';
 
    public function label(): string
    {
        return match($this) {
            self::POPULAR => 'popular',
            self::TRENDING => 'trending',
            self::HOT => 'hot',
        };
    }
 
    public function color(): string
    {
        return match($this) {
            self::POPULAR => 'badge badge-info',
            self::TRENDING => 'badge badge-warning',
            self::HOT => 'badge badge-error',
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