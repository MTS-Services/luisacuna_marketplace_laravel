<?php

namespace App\Enums;

enum OtpType: string
{
    case EMAIL = 'email';
    case SMS = 'sms';
    case AUTHENTICATOR_APP = 'authenticator_app';


    public function label(): string
    {
        return match($this) {
            self::EMAIL => 'Email',
            self::SMS => 'SMS',
            self::AUTHENTICATOR_APP => 'Authenticator App',
        };
    }
   public function color(): string
    {
        return match($this) {
            self::EMAIL => 'badge-primary',
            self::SMS => 'badge-info',
            self::AUTHENTICATOR_APP => 'badge-success',
        };
    }

}
