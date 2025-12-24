<?php

namespace App\Enums;

enum TransactionType: string
{
    case PAYMENT = 'payment';
    case WALLET = 'wallet';
    case REFUND = 'refund';
    case WITHDRAWAL = 'withdrawal';
    case DEPOSIT = 'deposit';
    case TRANSFER = 'transfer';
    case FEE = 'fee';
    case COMMISSION = 'commission';

    public function label(): string
    {
        return match ($this) {
            self::PAYMENT => 'Payment',
            self::WALLET => 'Wallet',
            self::REFUND => 'Refund',
            self::WITHDRAWAL => 'Withdrawal',
            self::DEPOSIT => 'Deposit',
            self::TRANSFER => 'Transfer',
            self::FEE => 'Fee',
            self::COMMISSION => 'Commission',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::PAYMENT => 'badge-primary',
            self::WALLET => 'badge-info',
            self::REFUND => 'badge-warning',
            self::WITHDRAWAL => 'badge-danger',
            self::DEPOSIT => 'badge-success',
            self::TRANSFER => 'badge-info',
            self::FEE => 'badge-secondary',
            self::COMMISSION => 'badge-accent',
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
