<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserDisputeStats extends Model
{
    protected $fillable = [
        'user_id',
        'total_orders',
        'total_disputes',
        'won_disputes',
        'lost_disputes',
        'dispute_rate',
        'positive_rate',
        'negative_rate',
    ];

    protected function casts(): array
    {
        return [
            'total_orders' => 'integer',
            'total_disputes' => 'integer',
            'won_disputes' => 'integer',
            'lost_disputes' => 'integer',
            'dispute_rate' => 'decimal:2',
            'positive_rate' => 'decimal:2',
            'negative_rate' => 'decimal:2',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Recalculate all rates based on current counts.
     */
    public function recalculateRates(): void
    {
        if ($this->total_orders > 0) {
            $this->dispute_rate = round(($this->total_disputes / $this->total_orders) * 100, 2);
        }

        if ($this->total_disputes > 0) {
            $this->positive_rate = round(($this->won_disputes / $this->total_disputes) * 100, 2);
            $this->negative_rate = round(($this->lost_disputes / $this->total_disputes) * 100, 2);
        }
    }
}
