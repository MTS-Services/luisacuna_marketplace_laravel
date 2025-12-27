<?php

namespace App\Enums;

enum TransactionType: string
{
    case PURCHSED = 'purchased';
    case SALES = 'sales';
    case WITHDRAWAL = 'withdrawal';
    case REFUND = 'refund';
    case TOPUP = 'topup';

    public function label(): string
    {
        return match ($this) {
            self::PURCHSED => 'Purchased',
            self::SALES => 'Sales',
            self::WITHDRAWAL => 'Withdrawal',
            self::REFUND => 'Refund',
            self::TOPUP => 'Top Up',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::PURCHSED => 'badge-success',
            self::SALES => 'badge-info',
            self::WITHDRAWAL => 'badge-warning',
            self::REFUND => 'badge-danger',
            self::TOPUP => 'badge-primary',
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
