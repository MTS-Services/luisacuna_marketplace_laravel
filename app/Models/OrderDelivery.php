<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderDelivery extends Model
{
    protected $fillable = [
        'order_id',
        'seller_id',
        'delivery_message',
        'files',
        'external_links',
    ];

    protected function casts(): array
    {
        return [
            'files' => 'array',
            'external_links' => 'array',
        ];
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function seller(): BelongsTo
    {
        return $this->belongsTo(User::class, 'seller_id');
    }
}
