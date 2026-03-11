<?php

namespace App\Enums;

enum SanctionType: string
{
    case ForceKyc = 'force_kyc';
    case FreezeWallet = 'freeze_wallet';
    case Suspend = 'suspend';
    case BanHwid = 'ban_hwid';

    public function label(): string
    {
        return match ($this) {
            self::ForceKyc => __('Force KYC'),
            self::FreezeWallet => __('Freeze Wallet'),
            self::Suspend => __('Suspend'),
            self::BanHwid => __('Ban HWID'),
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::ForceKyc => 'badge-warning',
            self::FreezeWallet => 'badge-info',
            self::Suspend => 'badge-error',
            self::BanHwid => 'badge-error',
        };
    }

    public static function options(): array
    {
        return array_map(
            fn (self $case) => ['value' => $case->value, 'label' => $case->label()],
            self::cases()
        );
    }
}
