<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AdminStaffNote extends Model
{
    protected $fillable = [
        'sort_order',
        'order_id',
        'admin_id',
        'note',
    ];

    protected $casts = [
        'sort_order' => 'integer',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }
}
