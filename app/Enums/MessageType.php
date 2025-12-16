<?php
 
namespace App\Enums;
 
enum MessageType: string
{
    case TEXT = 'text';
    case SYSTEM = 'system';
    case ORDER_NOTIFICATION = 'order_notification';
    case SUPPORT_NOTIFICATION = 'support_notification';
    case ORDER_STATUS_UPDATED = 'order_status_updated';
 
    public function label(): string
    {
        return match($this) {
            // self::ACTIVE => 'Active',
        };
    }
 
    public function color(): string
    {
        return match($this) {
            // self::ACTIVE => 'success',
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