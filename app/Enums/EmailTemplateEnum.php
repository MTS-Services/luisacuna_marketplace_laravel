<?php
 
namespace App\Enums;
 
enum EmailTemplateEnum: string
{
    case WELCOME_EMAIL = 'welcome_email';
    case PASSWORD_RESET = 'password_reset';
    case ORDER_CONFIRMATION = 'order_confirmation';
    case ORDER_DISPUTE_UPDATE = 'order_dispute_update';
 
    public function label(): string
    {
        return match($this) {
            self::WELCOME_EMAIL => 'welcome_email',
            self::PASSWORD_RESET => 'password_reset',
            self::ORDER_CONFIRMATION => 'order_confirmation',
            self::ORDER_DISPUTE_UPDATE => 'order_dispute_update',
        };
    }
 
    public function color(): string
    {
        return match($this) {
            self::WELCOME_EMAIL => 'success',
            self::PASSWORD_RESET => 'success',
            self::ORDER_CONFIRMATION => 'success',
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