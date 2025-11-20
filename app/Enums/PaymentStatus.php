<?php

namespace App\Enums;

enum PaymentStatus: string
{
    case PENDING = 'pending';
    case PROCESSING = 'processing';
    case COMPLETED = 'completed';
    case FAILED = 'failed';
    case REFUNDED = 'refunded';
    case PARTIALLY_REFUNDED = 'partially_refunded';
    case CANCELLED = 'cancelled';

    public function label(): string
    {
        return match ($this) {
            self::PENDING => 'Pending',
            self::PROCESSING => 'Processing',
            self::COMPLETED => 'Completed',
            self::FAILED => 'Failed',
            self::REFUNDED => 'Refunded',
            self::CANCELLED => 'Cancelled',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::PENDING => 'badge-warning',
            self::PROCESSING => 'badge-info',
            self::COMPLETED => 'badge-success',
            self::FAILED => 'badge-error',
            self::REFUNDED => 'badge-secondary',
            self::CANCELLED => 'badge-neutral',
        };
    }

    public static function options(): array
    {
        return array_map(
            fn($case) => ['value' => $case->value, 'label' => $case->label()],
            self::cases()
        );
    }


    case PAYMENT_GATEWAY_STRIPE = 'stripe';
    case PAYMENT_GATEWAY_COINBASE = 'coinbase';

    public function gateway(): string
    {
        return match ($this) {
            self::PAYMENT_GATEWAY_STRIPE => 'Stripe',
            self::PAYMENT_GATEWAY_COINBASE => 'Coinbase',
        };
    }
}
