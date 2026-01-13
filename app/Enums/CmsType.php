<?php

namespace App\Enums;

enum CmsType: string
{
    case TERMS_CONDITION = 'terms_condition';
    case REFUND_POLICY = 'refund_policy';
    case PRIVACY_POLICY = 'privacy_policy';
    case HOW_TO_BUY = 'how_to_buy';
    case BUYER_PROTECTION = 'buyer_protection';
    case HOW_TO_SELL = 'how_to_sell';
    case SELLER_PROTECTION = 'seller_protection';



    public function label(): string
    {
        return match ($this) {
            self::TERMS_CONDITION => 'Terms & Condition',
            self::REFUND_POLICY => 'Refund Policy',
            self::PRIVACY_POLICY => 'Privacy Policy',
            self::HOW_TO_BUY => 'How to Buy',
            self::BUYER_PROTECTION => 'Buyer Protection',
            self::HOW_TO_SELL => 'How to Sell',
            self::SELLER_PROTECTION => 'Seller Protection',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::TERMS_CONDITION => 'badge-primary',
            self::REFUND_POLICY => 'badge-warning',
            self::PRIVACY_POLICY => 'badge-info',
            self::HOW_TO_BUY => 'badge-danger',
            self::BUYER_PROTECTION => 'badge-danger',
            self::HOW_TO_SELL => 'badge-danger',
            self::SELLER_PROTECTION => 'badge-danger',
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
