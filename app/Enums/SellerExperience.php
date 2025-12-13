<?php
 
namespace App\Enums;
 
enum SellerExperience: string
{
    case EXPERIENCED = 'experienced';
    case NEWBIE = 'newbie';
 
    public function label(): string
    {
        return match($this) {
            self::EXPERIENCED => 'Experienced',
            self::NEWBIE => 'Newbie',
        };
    }
 
    public function color(): string
    {
        return match($this) {
            self::EXPERIENCED => 'badge badge-success',
            self::NEWBIE => 'badge badge-info',
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