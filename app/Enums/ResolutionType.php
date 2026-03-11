<?php

namespace App\Enums;

enum ResolutionType: string
{
    case BuyerWins = 'buyer_wins';
    case SellerWins = 'seller_wins';
    case PartialSplit = 'partial_split';
    case NeutralCancel = 'neutral_cancel';

    public function label(): string
    {
        return match ($this) {
            self::BuyerWins => __('Buyer Wins (Full Refund)'),
            self::SellerWins => __('Seller Wins (Release Funds)'),
            self::PartialSplit => __('Partial Split'),
            self::NeutralCancel => __('Neutral Cancellation'),
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::BuyerWins => 'badge-error',
            self::SellerWins => 'badge-success',
            self::PartialSplit => 'badge-warning',
            self::NeutralCancel => 'badge-neutral',
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
