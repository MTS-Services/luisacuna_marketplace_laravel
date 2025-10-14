<?php

namespace App\Enums;

enum UserAccountStatus: string
{
    case ACTIVE = 'active';
    case INACTIVE = 'inactive';
    case SUSPENDED = 'suspended';
    case BANNED = 'banned';
    case PENDING_VERIFICATION = 'pending_verification';


    public function label(): string
    {
        return match($this) {
            self::ACTIVE => 'Active',
            self::INACTIVE => 'Inactive',
            self::SUSPENDED => 'Suspended',
            self::BANNED => 'Banned',
            self::PENDING_VERIFICATION => 'Pending Verification',
        };
    }


    public function color(): string
    {
        return match($this) {
            self::ACTIVE => 'badge-success',
            self::INACTIVE => 'badge-secondary',
            self::SUSPENDED => 'badge-warning',
            self::BANNED => 'badge-danger',
            self::PENDING_VERIFICATION => 'badge-info',
        };
    }
}
