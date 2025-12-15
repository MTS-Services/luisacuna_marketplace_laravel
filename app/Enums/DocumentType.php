<?php
 
namespace App\Enums;
 
enum DocumentType: string
{
    case NATIONAL_ID_CARD = 'national_id_card';
    case PASSPORT = 'Passport';
    case SMART_CARD = 'SMART_CARD';
 
    public function label(): string
    {
        return match($this) {
            self::NATIONAL_ID_CARD => 'National ID Card',
            self::PASSPORT => 'Passport',
            self::SMART_CARD => 'Smart Card',
        };
    }
 
    public function color(): string
    {
        return match($this) {
            self::NATIONAL_ID_CARD => 'badge badge-success',
            self::PASSPORT => 'badge badge-info',
            self::SMART_CARD => 'badge badge-warning',
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