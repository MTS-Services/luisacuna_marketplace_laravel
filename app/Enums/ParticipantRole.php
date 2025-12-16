<?php
 
namespace App\Enums;
 
enum ParticipantRole: string
{
    case BUYER = 'buyer';
    case SELLER = 'seller';
    case ADMIN = 'admin';
    case SUPPORT = 'support';
 
    public function label(): string
    {
        return match($this) {
            self::BUYER => 'Buyer',
            self::SELLER => 'Seller',
            self::ADMIN => 'Admin',
            self::SUPPORT => 'Support',
        };
    }
 
    public function color(): string
    {
        return match($this) {
            self::BUYER => 'badge badge-success',
            self::SELLER => 'badge badge-info',
            self::ADMIN => 'badge badge-primary',
            self::SUPPORT => 'badge badge-danger',
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