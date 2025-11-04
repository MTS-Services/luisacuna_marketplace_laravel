<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class EmailTemplate extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $fillable = [
        'sort_order',
        'key',
        'name',
        'subject',
        'body',
        'variables',
        'created_by',
        'updated_by',
        'deleted_by',
        'restored_by',
        'restored_at',
    ];

    protected $casts = [
        'variables' => 'array',
        'restored_at' => 'datetime',
    ];

    // 🧠 Relationships
    public function createdBy() { return $this->belongsTo(Admin::class, 'created_by'); }
    public function updatedBy() { return $this->belongsTo(Admin::class, 'updated_by'); }
    public function deletedBy() { return $this->belongsTo(Admin::class, 'deleted_by'); }
    public function restoredBy() { return $this->belongsTo(Admin::class, 'restored_by'); }

    // 🪄 Auto fill created_by / updated_by
    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (Auth::check()) {
                $model->created_by = Auth::id();
            }
        });

        static::updating(function ($model) {
            if (Auth::check()) {
                $model->updated_by = Auth::id();
            }
        });

        static::deleting(function ($model) {
            if (Auth::check()) {
                $model->deleted_by = Auth::id();
                $model->saveQuietly();
            }
        });

        static::restoring(function ($model) {
            if (Auth::check()) {
                $model->restored_by = Auth::id();
                $model->restored_at = now();
            }
        });
    }

    // 🧩 Helper: render with variables
    public function render(array $data = []): string
    {
        $output = $this->body;

        foreach ($data as $key => $value) {
            $output = str_replace('{{ ' . $key . ' }}', e($value), $output);
        }

        return $output;
    }
}
