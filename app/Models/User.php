<?php

namespace App\Models;

use App\Enums\UserAccountStatus;
use App\Enums\UserStatus;
use App\Enums\UserType;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends AuthBaseModel
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'sort_order',
        'country_id',

        'username',
        'first_name',
        'last_name',
        'display_name',

        'avatar',
        'date_of_birth',

        'timezone',
        'language',
        'currency',

        'email',
        'email_verified_at',
        'password',

        'phone',
        'phone_verified_at',
        'otp',
        'otp_expires_at',

        'user_type',
        'account_status',

        'last_login_at',
        'last_login_ip',
        'login_attempts',
        'locked_until',

        'two_factor_enabled',
        'two_factor_secret',
        'two_factor_recovery_codes',

        'terms_accepted_at',
        'privacy_accepted_at',

        'last_synced_at',
        'status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_secret',
        'two_factor_recovery_codes',
    ];

    /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at'      => 'datetime',
            'phone_verified_at'      => 'datetime',
            'otp_expires_at'         => 'datetime',
            'last_login_at'          => 'datetime',
            'locked_until'           => 'datetime',
            'terms_accepted_at'      => 'datetime',
            'privacy_accepted_at'    => 'datetime',
            'last_synced_at'         => 'datetime',
            'date_of_birth'          => 'date',

            'two_factor_enabled'     => 'boolean',
            'password'               => 'hashed',

            'status'                 => UserStatus::class,
            'user_type'              => UserType::class,
            'account_status'         => UserAccountStatus::class,
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    // public function country()
    // {
    //     return $this->belongsTo(Country::class, 'country_id');
    // }

    /*
    |--------------------------------------------------------------------------
    | Query Scopes
    |--------------------------------------------------------------------------
    */

    public function scopeActive($query)
    {
        return $query->where('status', UserStatus::ACTIVE);
    }

    public function scopeInactive($query)
    {
        return $query->where('status', UserStatus::INACTIVE);
    }

    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('username', 'like', "%{$search}%")
                ->orWhere('first_name', 'like', "%{$search}%")
                ->orWhere('last_name', 'like', "%{$search}%")
                ->orWhere('display_name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%")
                ->orWhere('phone', 'like', "%{$search}%");
        });
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['status'] ?? null, fn($q, $status) => $q->where('status', $status));
        $query->when($filters['search'] ?? null, fn($q, $search) => $q->search($search));
        $query->when($filters['user_type'] ?? null, fn($q, $type) => $q->where('user_type', $type));
        $query->when($filters['account_status'] ?? null, fn($q, $acc) => $q->where('account_status', $acc));

        return $query;
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */

    public function getFullNameAttribute(): string
    {
        return trim("{$this->first_name} {$this->last_name}");
    }

    public function getStatusLabelAttribute(): string
    {
        return $this->status->label();
    }

    public function getStatusColorAttribute(): string
    {
        return $this->status->color();
    }

    public function getUserTypeLabelAttribute(): string
    {
        return $this->user_type->label();
    }

    public function getUserTypeColorAttribute(): string
    {
        return $this->user_type->color();
    }

    public function getAccountStatusLabelAttribute(): string
    {
        return $this->account_status->label();
    }

    public function getAccountStatusColorAttribute(): string
    {
        return $this->account_status->color();
    }

    public function getAvatarUrlAttribute(): string
    {
        $name = $this->display_name ?? $this->full_name ?? $this->username;
        return $this->avatar
            ? asset('storage/' . $this->avatar)
            : 'https://ui-avatars.com/api/?name=' . urlencode($name);
    }

    /*
    |--------------------------------------------------------------------------
    | Methods
    |--------------------------------------------------------------------------
    */

    public function isActive(): bool
    {
        return $this->status === UserStatus::ACTIVE;
    }

    public function activate(): void
    {
        $this->update(['status' => UserStatus::ACTIVE]);
    }

    public function deactivate(): void
    {
        $this->update(['status' => UserStatus::INACTIVE]);
    }

    public function suspend(): void
    {
        $this->update(['status' => UserStatus::SUSPENDED]);
    }

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->appends = array_merge(parent::getAppends(), [
            'full_name',
            'avatar_url',
            'status_label',
            'status_color',
            'user_type_label',
            'user_type_color',
            'account_status_label',
            'account_status_color',
        ]);
    }
}
