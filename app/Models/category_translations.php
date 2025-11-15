<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CategoryTranslation extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'game_category_id',
        'language_id',
        'name',
        'description',
        'meta_title',
        'meta_description',
        'is_auto_translated',
        'created_by',
        'updated_by',
        'deleted_by',
        'restored_by',
        'restored_at',
    ];

    protected $casts = [
        'is_auto_translated' => 'boolean',
        'restored_at' => 'datetime',
    ];

    // Relations
    public function category()
    {
        return $this->belongsTo(GameCategory ::class, 'game_category_id');
    }

    public function language()
    {
        return $this->belongsTo(Language::class, 'language_id');
    }

    public function creator()
    {
        return $this->belongsTo(Admin::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(Admin::class, 'updated_by');
    }

    public function deleter()
    {
        return $this->belongsTo(Admin::class, 'deleted_by');
    }

    public function restorer()
    {
        return $this->belongsTo(Admin::class, 'restored_by');
    }
}
