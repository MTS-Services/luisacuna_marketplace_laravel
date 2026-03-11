<?php

namespace App\Models;

use App\Enums\OrderStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderStatusHistory extends Model
{
    protected $fillable = [
        'order_id',
        'from_status',
        'to_status',
        'actor_type',
        'actor_id',
        'metadata',
    ];

    protected function casts(): array
    {
        return [
            'from_status' => OrderStatus::class,
            'to_status' => OrderStatus::class,
            'metadata' => 'array',
        ];
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function actor(): BelongsTo
    {
        return match ($this->actor_type) {
            'admin' => $this->belongsTo(Admin::class, 'actor_id'),
            default => $this->belongsTo(User::class, 'actor_id'),
        };
    }
}
