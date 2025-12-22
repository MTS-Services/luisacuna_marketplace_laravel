<?php

namespace App\Enums;

enum WalletTransactionType: string
{
    case DEPOSIT = 'deposit';
    case WITHDRAWAL = 'withdrawal';
    case PAYMENT = 'payment';
    case REFUND = 'refund';
    case TRANSFER_IN = 'transfer_in';
    case TRANSFER_OUT = 'transfer_out';
    case ADMIN_CREDIT = 'admin_credit';
    case ADMIN_DEBIT = 'admin_debit';

    public function label(): string
    {
        return match ($this) {
            self::DEPOSIT => 'Deposit',
            self::WITHDRAWAL => 'Withdrawal',
            self::PAYMENT => 'Payment',
            self::REFUND => 'Refund',
            self::TRANSFER_IN => 'Transfer In',
            self::TRANSFER_OUT => 'Transfer Out',
            self::ADMIN_CREDIT => 'Admin Credit',
            self::ADMIN_DEBIT => 'Admin Debit',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::DEPOSIT => 'badge-success',
            self::WITHDRAWAL => 'badge-danger',
            self::PAYMENT => 'badge-primary',
            self::REFUND => 'badge-warning',
            self::TRANSFER_IN => 'badge-success',
            self::TRANSFER_OUT => 'badge-danger',
            self::ADMIN_CREDIT => 'badge-success',
            self::ADMIN_DEBIT => 'badge-danger',
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
