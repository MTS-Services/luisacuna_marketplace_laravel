<?php

namespace App\Enums;

enum WalletTransactionType: string
{
    case DEPOSIT = 'deposit';
    case WITHDRAWAL = 'withdrawal';
    case TRANSFER = 'transfer';
    case REVERSAL = 'reversal';
    case REFUND = 'refund';
    case FEE = 'fee';
    case PAYOUT = 'payout';
    case CHARGE = 'charge';
    case CHARGEBACK = 'chargeback';
    case DISPUTE = 'dispute';

    public function label(): string
    {
        return match ($this) {
            self::DEPOSIT => 'Deposit',
            self::WITHDRAWAL => 'Withdrawal',
            self::TRANSFER => 'Transfer',
            self::REVERSAL => 'Reversal',
            self::REFUND => 'Refund',
            self::FEE => 'Fee',
            self::PAYOUT => 'Payout',
            self::CHARGE => 'Charge',
            self::CHARGEBACK => 'Chargeback',
            self::DISPUTE => 'Dispute'
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::DEPOSIT => 'badge-success',
            self::WITHDRAWAL => 'badge-warning',
            self::TRANSFER => 'badge-info',
            self::REVERSAL => 'badge-danger',
            self::REFUND => 'badge-secondary',
            self::FEE => 'badge-dark',
            self::PAYOUT => 'badge-primary',
            self::CHARGE => 'badge-primary',
            self::CHARGEBACK => 'badge-danger',
            self::DISPUTE => 'badge-danger'
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
