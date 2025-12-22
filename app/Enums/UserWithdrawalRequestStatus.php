<?php

namespace App\Enums;

enum UserWithdrawalRequestStatus: string
{
    case PENDING = 'pending';
    case PROCESSING = 'processing';
    case COMPLETE = 'complete';
    case DECLINE = 'decline';
    case CANCEL = 'cancel';

    public function label(): string
    {
        return match($this) {
            self::PENDING => 'Pending',
            self::PROCESSING => 'Processing',
            self::COMPLETE => 'Complete',
            self::DECLINE => 'Decline',
            self::CANCEL => 'Cancel',
        };
    }

    public function color(): string
    {
        return match($this) {
            self::PENDING => 'badge-warning',
            self::PROCESSING => 'badge-info',
            self::COMPLETE => 'badge-success',
            self::DECLINE => 'badge-danger',
            self::CANCEL => 'badge-secondary',
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
