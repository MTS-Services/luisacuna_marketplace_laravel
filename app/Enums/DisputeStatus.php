<?php

namespace App\Enums;

enum DisputeStatus: string
{
    case PENDING_VENDOR = 'pending_vendor';
    case ESCALATED = 'escalated';
    case RESOLVED_REFUND = 'resolved_refund';
    case RESOLVED_CLOSED = 'resolved_closed';

    public function label(): string
    {
        return match ($this) {
            self::PENDING_VENDOR => __('Pending Vendor'),
            self::ESCALATED => __('Escalated'),
            self::RESOLVED_REFUND => __('Resolved (Refund)'),
            self::RESOLVED_CLOSED => __('Resolved (Closed)'),
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::PENDING_VENDOR => 'badge-warning',
            self::ESCALATED => 'badge-info',
            self::RESOLVED_REFUND => 'badge-secondary',
            self::RESOLVED_CLOSED => 'badge-success',
        };
    }

    public static function options(): array
    {
        return array_map(
            fn (self $case) => ['value' => $case->value, 'label' => $case->label()],
            self::cases()
        );
    }

    public function isOpen(): bool
    {
        return match ($this) {
            self::PENDING_VENDOR,
            self::ESCALATED => true,
            self::RESOLVED_REFUND,
            self::RESOLVED_CLOSED => false,
        };
    }

    public function isResolved(): bool
    {
        return ! $this->isOpen();
    }
}

