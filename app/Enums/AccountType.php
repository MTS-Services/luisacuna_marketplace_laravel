<?php
 
namespace App\Enums;
 
enum AccountType: string
{
    case INDIVIDUAL = 'individual';
    case COMPANY = 'company';
 
    public function label(): string
    {
        return match($this) {
            self::INDIVIDUAL => 'Individual',
            self::COMPANY => 'Company',
        };
    }
 
    public function color(): string
    {
        return match($this) {
             self::INDIVIDUAL => 'badge badge-info',
            self::COMPANY => 'badge badge-success',
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