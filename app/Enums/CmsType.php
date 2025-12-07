<?php

namespace App\Enums;

enum CmsType: string
{
    case TERMS_CONDITION = 'terms_condition';
    case REFUND_POLICY = 'refund_policy';
    case PRIVACY_POLICY = 'privacy_policy';



    public function label(): string
    {
        return match ($this) {
            self::TERMS_CONDITION => 'Terms & Condition',
            self::REFUND_POLICY => 'Refund Policy',
            self::PRIVACY_POLICY => 'Privacy Policy',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::TERMS_CONDITION => 'badge-primary',
            self::REFUND_POLICY => 'badge-warning',
            self::PRIVACY_POLICY => 'badge-info',
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
