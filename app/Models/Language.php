<?php

namespace App\Models;

use App\Enums\LanguageDirection;
use App\Enums\LanguageStatus;
use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    protected $fillable = [
        'sort_order',
        'locale',
        'name',
        'native_name',
        'status',
        'is_active',
        'direction',


        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $casts = [
        'status' => LanguageStatus::class,
        'is_active' => 'boolean',
        'direction' => LanguageDirection::class,
    ];
}
