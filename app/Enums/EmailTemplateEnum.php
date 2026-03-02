<?php

namespace App\Enums;

enum EmailTemplateEnum: string
{
    case ORDER_MESSAGE = 'order_message';
    case NEW_MESSAGE_RECEIVED = 'new_message_received';
    case ORDER_STATUS_CHANGED = 'order_status_changed';
    case ORDER_DISPUTE = 'order_dispute';
    case PAYMENT = 'payment';
    case WITHDRAWAL = 'withdrawal';
    case VERIFICATION = 'verification';
    case BOOSTING_OFFER = 'boosting_offer';

    public function label(): string
    {
        return match ($this) {
            self::ORDER_MESSAGE => __('Order Message'),
            self::NEW_MESSAGE_RECEIVED => __('New Message Received'),
            self::ORDER_STATUS_CHANGED => __('Order Status Changed'),
            self::ORDER_DISPUTE => __('Order Dispute'),
            self::PAYMENT => __('Payment'),
            self::WITHDRAWAL => __('Withdrawal'),
            self::VERIFICATION => __('Verification'),
            self::BOOSTING_OFFER => __('Boosting Offer'),
        };
    }

    public function color(): string
    {
        return 'success';
    }

    public static function options(): array
    {
        return array_map(
            fn ($case) => ['value' => $case->value, 'label' => $case->label()],
            self::cases()
        );
    }
}
