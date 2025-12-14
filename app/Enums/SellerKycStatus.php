<?php
 
namespace App\Enums;
 
enum SellerKycStatus: string
{
   
   
    case PROSESSING = 'processing';
    case PENDING = 'pending';
    case APPROVED   = 'approved';
    case REJECTED = 'rejected';
 
    public function label(): string
    {
        return match($this) {
            self::PROSESSING => 'processing',
            self::APPROVED => 'approved',
            self::PENDING => 'pending',
            self::REJECTED => 'rejected',
        };
    }
 
    public function color(): string
    {
        return match($this) {
            self::PROSESSING => 'badge badge-info',
            self::APPROVED => 'badge badge-success',
            self::PENDING => 'badge badge-warning',
            self::REJECTED => 'badge badge-danger',
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