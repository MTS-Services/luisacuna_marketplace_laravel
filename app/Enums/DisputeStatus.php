<?php

namespace App\Enums;

enum DisputeStatus: string
{
    case PENDING_VENDOR = 'pending_vendor';
    case PENDING_REVIEW = 'pending_review';
    case ESCALATED = 'escalated';
    case RESOLVED_BUYER_WINS = 'resolved_buyer_wins';
    case RESOLVED_SELLER_WINS = 'resolved_seller_wins';
    case RESOLVED_PARTIAL_SPLIT = 'resolved_partial_split';
    case RESOLVED_NEUTRAL = 'resolved_neutral';
    case RESOLVED_REFUND = 'resolved_refund';
    case RESOLVED_CLOSED = 'resolved_closed';

    public function label(): string
    {
        return match ($this) {
            self::PENDING_VENDOR => __('Pending Vendor Response'),
            self::PENDING_REVIEW => __('Pending Admin Review'),
            self::ESCALATED => __('Escalated to Admin'),
            self::RESOLVED_BUYER_WINS => __('Resolved (Buyer Wins)'),
            self::RESOLVED_SELLER_WINS => __('Resolved (Seller Wins)'),
            self::RESOLVED_PARTIAL_SPLIT => __('Resolved (Partial Split)'),
            self::RESOLVED_NEUTRAL => __('Resolved (Neutral Cancel)'),
            self::RESOLVED_REFUND => __('Resolved (Refund)'),
            self::RESOLVED_CLOSED => __('Resolved (Closed)'),
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::PENDING_VENDOR => 'badge-warning',
            self::PENDING_REVIEW => 'badge-warning',
            self::ESCALATED => 'badge-info',
            self::RESOLVED_BUYER_WINS => 'badge-error',
            self::RESOLVED_SELLER_WINS => 'badge-success',
            self::RESOLVED_PARTIAL_SPLIT => 'badge-warning',
            self::RESOLVED_NEUTRAL => 'badge-neutral',
            self::RESOLVED_REFUND => 'badge-secondary',
            self::RESOLVED_CLOSED => 'badge-success',
        };
    }

    public static function options(): array
    {
        return array_map(
            fn (self $case) => ['value' => $case->value, 'label' => $case->label()],
            self::cases()
        );
    }

    public function isOpen(): bool
    {
        return in_array($this, [
            self::PENDING_VENDOR,
            self::PENDING_REVIEW,
            self::ESCALATED,
        ], true);
    }

    public function isResolved(): bool
    {
        return ! $this->isOpen();
    }
}
