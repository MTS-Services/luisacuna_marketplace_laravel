<?php

namespace App\Enums;

enum OtpType: string
{
    case EMAIL = 'email';
    case SMS = 'sms';
    case AUTHENTICATOR_APP = 'authenticator_app';
    case EMAIL_VERIFICATION = 'email_verification';
    case PHONE_VERIFICATION = 'phone_verification';
    case PASSWORD_RESET = 'password_reset';
    case LOGIN_VERIFICATION = 'login_verification';

    public function label(): string
    {
        return match ($this) {
            self::EMAIL => __('Email'),
            self::SMS => __('SMS'),
            self::AUTHENTICATOR_APP => __('Authenticator App'),
            self::EMAIL_VERIFICATION => __('Email Verification'),
            self::PHONE_VERIFICATION => __('Phone Verification'),
            self::PASSWORD_RESET => __('Password Reset'),
            self::LOGIN_VERIFICATION => __('Login Verification'),
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::EMAIL => 'badge-primary',
            self::SMS => 'badge-info',
            self::AUTHENTICATOR_APP => 'badge-success',
            self::EMAIL_VERIFICATION => 'badge-warning',
            self::PHONE_VERIFICATION => 'badge-info',
            self::PASSWORD_RESET => 'badge-danger',
            self::LOGIN_VERIFICATION => 'badge-secondary',
        };
    }
}
