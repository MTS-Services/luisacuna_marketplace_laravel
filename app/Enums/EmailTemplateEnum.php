<?php

namespace App\Enums;

enum EmailTemplateEnum: string
{
    case ORDER_MESSAGE_BUYER = 'order_message_buyer';
    case ORDER_MESSAGE_SELLER = 'order_message_seller';
    case ORDER_MESSAGE_ADMIN = 'order_message_admin';
    case PAYMENT_SUCCESS_BUYER = 'payment_success_buyer';
    case PAYMENT_SUCCESS_SELLER = 'payment_success_seller';
    case PAYMENT_SUCCESS_SUPER_ADMIN = 'payment_success_super_admin';
    case PAYMENT_CANCELED_BUYER = 'payment_canceled_buyer';
    case WITHDRAWAL_REQUEST_SUBMIT_SELLER = 'withdrawal_request_submit_seller';
    case WITHDRAWAL_REQUEST_SUBMIT_SUPER_ADMIN = 'withdrawal_request_submit_super_admin';
    case WITHDRAWAL_PROCESS_SUCCESS_SUPER_ADMIN = 'withdrawal_process_success_super_admin';
    case WITHDRAWAL_PROCESS_SUCCESS_SELLER = 'withdrawal_process_success_seller';
    case USER_BANNED = 'user_banned';
    case OTP_VERIFICATION = 'otp_verification';
    case ORDER_DISPUTE_RESOLVED_BUYER = 'order_dispute_resolved_buyer';
    case ORDER_DISPUTE_RESOLVED_SELLER = 'order_dispute_resolved_seller';
    case ORDER_DISPUTE_OPENED_SELLER = 'order_dispute_opened_seller';

    public function label(): string
    {
        return match ($this) {
            self::ORDER_MESSAGE_BUYER => __('Order message to Buyer'),
            self::ORDER_MESSAGE_SELLER => __('Order message to Seller'),
            self::ORDER_MESSAGE_ADMIN => __('Order message to Admin'),
            self::PAYMENT_SUCCESS_BUYER => __('Payment Success to Buyer'),
            self::PAYMENT_SUCCESS_SUPER_ADMIN => __('Payment Success to Super Admins'),
            self::PAYMENT_CANCELED_BUYER => __('Payment Canceled to Buyer'),
            self::WITHDRAWAL_REQUEST_SUBMIT_SELLER => __('Withdrawal Request Submit to Seller'),
            self::WITHDRAWAL_REQUEST_SUBMIT_SUPER_ADMIN => __('Withdrawal Request Submit to Super Admins'),
            self::WITHDRAWAL_PROCESS_SUCCESS_SUPER_ADMIN => __('Withdrawal Process Success to Super Admins'),
            self::WITHDRAWAL_PROCESS_SUCCESS_SELLER => __('Withdrawal Process Success to Seller'),
            self::USER_BANNED => __('User Banned'),
            self::OTP_VERIFICATION => __('OTP Verification'),
            self::ORDER_DISPUTE_RESOLVED_BUYER => __('Order Dispute resolved to Buyer'),
            self::ORDER_DISPUTE_RESOLVED_SELLER => __('Order Dispute resolved to Seller'),
            self::ORDER_DISPUTE_OPENED_SELLER => __('Order Dispute opened to Seller'),
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
