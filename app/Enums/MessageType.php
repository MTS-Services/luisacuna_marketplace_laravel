<?php

namespace App\Enums;

enum MessageType: string
{
    case TEXT = 'text';
    case SYSTEM = 'system';
    case IMAGE = 'image';
    case VIDEO = 'video';
    case AUDIO = 'audio';
    case FILE = 'file';
    case ORDER_NOTIFICATION = 'order_notification';
    case SUPPORT_NOTIFICATION = 'support_notification';
    case ORDER_STATUS_UPDATED = 'order_status_updated';

    public function label(): string
    {
        return match ($this) {
            self::TEXT => 'Text',
            self::SYSTEM => 'System',
            self::IMAGE => 'Image',
            self::VIDEO => 'Video',
            self::AUDIO => 'Audio',
            self::FILE => 'File',
            self::ORDER_NOTIFICATION => 'Order Notification',
            self::SUPPORT_NOTIFICATION => 'Support Notification',
            self::ORDER_STATUS_UPDATED => 'Order Status Updated',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::TEXT => 'badge-secondary',
            self::SYSTEM => 'badge-info',
            self::IMAGE => 'badge-success',
            self::VIDEO => 'badge-warning',
            self::AUDIO => 'badge-danger',
            self::FILE => 'badge-dark',
            self::ORDER_NOTIFICATION => 'badge-primary',
            self::SUPPORT_NOTIFICATION => 'badge-primary',
            self::ORDER_STATUS_UPDATED => 'badge-primary',
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
