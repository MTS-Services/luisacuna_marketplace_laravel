<?php

namespace App\Models;

use App\Enums\ReferralSettingStatus;
use Illuminate\Database\Eloquent\Model;
use App\Traits\AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable;

class ReferralSetting extends AuditBaseModel implements Auditable
{
    use  AuditableTrait;
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */


    protected $fillable = [
        'status',
        'title',
        'description',
        'referrer_bonus',
        'referred_bonus',
        'max_referrals_per_user',
        'expiry_days',
        'currency_id',




        'created_type',
        'created_id',
        'updated_type',
        'updated_id',
        'deleted_type',
        'deleted_id',
    ];



    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */



    protected $casts = [
        'status' => ReferralSettingStatus::class,
    ];




    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */


    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }
    public function userReferrals()
    {
        return $this->hasMany(UserReferral::class);
    }


    /*
    |--------------------------------------------------------------------------
    | Query Scopes
    |--------------------------------------------------------------------------
    */

    public function scopeActive($query)
    {
        return $query->where('status', ReferralSettingStatus::ACTIVE);
    }
    public function scopeInactive($query)
    {
        return $query->where('status', ReferralSettingStatus::INACTIVE);
    }

    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('title', 'like', "%{$search}%")
                ->orWhere('description', 'like', "%{$search}%");
        });
    }



    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */


    public function getStatusLabelAttribute(): string
    {
        return $this->status->label();
    }

    public function getStatusColorAttribute(): string
    {
        return $this->status->color();
    }


    /*
    |--------------------------------------------------------------------------
    | Methods
    |--------------------------------------------------------------------------
    */


    public function is_active(): bool
    {
        return $this->status === ReferralSettingStatus::ACTIVE;
    }

    public function activate(): void
    {
        $this->update(['status' => ReferralSettingStatus::ACTIVE]);
    }

    public function deactivate(): void
    {
        $this->update(['status' => ReferralSettingStatus::INACTIVE]);
    }
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->appends = array_merge(parent::getAppends(), [
            'status_label',
            'status_color',
        ]);
    }
}
