<?php

namespace App\Models;

use App\Enums\OtpType;
use App\Enums\UserType;
use App\Enums\UserStatus;
use App\Enums\userKycStatus;
use App\Traits\AuditableTrait;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Carbon;
use App\Traits\HasTranslations;
use App\Enums\UserAccountStatus;
use App\Traits\HasDeviceManagement;
use OwenIt\Auditing\Contracts\Auditable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends AuthBaseModel implements Auditable
{
    use TwoFactorAuthenticatable, AuditableTrait, HasTranslations, Notifiable, SoftDeletes, HasDeviceManagement;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'sort_order',
        // 'country_id',

        'username',
        'first_name',
        'last_name',
        'uuid',
        'email',
        'description',

        'apple_id',
        'facebook_id',
        'google_id',
        'avatar',
        'date_of_birth',
        'last_seen_at',

        'timezone',
        // 'language_id',
        // 'currency_id',

        'reason',
        'banned_reason',
        'banned_at',


        'email_verified_at',
        'password',

        'phone',
        'phone_verified_at',

        'user_type',
        'account_status',

        'last_login_at',
        'last_login_ip',
        'login_attempts',
        'locked_until',

        'two_factor_enabled',
        'two_factor_secret',
        'two_factor_recovery_codes',
        'two_factor_confirmed_at',

        'terms_accepted_at',
        'privacy_accepted_at',

        'last_synced_at',
        'language_id',

        'session_version',
        'all_devices_logged_out_at',

        'creater_type',
        'updater_type',
        'deleter_type',
        'creater_id',
        'updater_id',
        'deleter_id',
        'restorer_id',


    ];

    protected $auditExclude = [
        'password',
        'remember_token',
        'created_at',
        'updated_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'phone_verified_at' => 'datetime',
            'otp_expires_at' => 'datetime',
            'last_login_at' => 'datetime',
            'locked_until' => 'datetime',
            'terms_accepted_at' => 'datetime',
            'privacy_accepted_at' => 'datetime',
            'last_synced_at' => 'datetime',
            'two_factor_confirmed_at' => 'datetime',
            'all_devices_logged_out_at' => 'datetime',
            'date_of_birth' => 'date',

            'two_factor_enabled' => 'boolean',
            'password' => 'hashed',

            'user_type' => UserType::class,
            'account_status' => UserAccountStatus::class,
            'kyc_status' => userKycStatus::class,
            'last_seen_at' => 'datetime',
        ];
    }

    // Booting Method
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            // Only set UUID if empty
            if (empty($user->uuid)) {
                $user->uuid = (string) \generate_uuid();
            }
        });
        static::created(function ($user) {
            UserNotificationSetting::create([
                'user_id' => $user->id,
            ]);
            UserPoint::updateOrCreate([
                'user_id' => $user->id,
            ]);
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function wallet(): HasOne
    {
        return $this->hasOne(Wallet::class, 'user_id', 'id');
    }

    public function userTranslations(): HasMany
    {
        return $this->hasMany(UserTranslations::class, 'user_id', 'id');
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class, 'country_id', 'id');
    }

    public function seller(): HasOne
    {
        return $this->hasOne(SellerProfile::class, 'user_id', 'id');
    }
    public function statistic(): HasOne
    {
        return $this->hasOne(UserStatistic::class, 'user_id', 'id');
    }
    public function referral(): HasOne
    {
        return $this->hasOne(UserReferral::class, 'user_id', 'id');
    }
    public function userReferral(): HasOne
    {
        return $this->hasOne(UserReferral::class, 'user_id', 'id');
    }
    public function sellerProduct(): HasOne
    {
        return $this->hasOne(Product::class, 'user_id', 'id');
    }
    public function productReview(): HasOne
    {
        return $this->hasOne(Product::class, 'user_id', 'id');
    }

    public function userBans(): HasMany
    {
        return $this->hasMany(UserBan::class, 'user_id', 'id');
    }
    public function bandedBy(): HasMany
    {
        return $this->hasMany(User::class, 'banned_by', 'id');
    }
    public function unbandedBy(): HasMany
    {
        return $this->hasMany(User::class, 'unbanned_by', 'id');
    }
    public function activeRank(): BelongsToMany
    {
        return $this->belongsToMany(Rank::class, 'user_ranks')
            ->wherePivot('activated_at', '!=', null)
            ->withPivot('activated_at', 'rank_id')
            ->limit(1);
    }

    public function ranks()
    {
        return $this->belongsToMany(Rank::class, 'user_ranks')
            ->withPivot('activated_at', 'rank_id')
            ->withTimestamps();
    }

    public function userPoint(): HasOne
    {
        return $this->hasOne(UserPoint::class, 'user_id', 'id');
    }

    public function audits(): MorphMany
    {
        return $this->morphMany(Audit::class, 'user');
    }
    public function notificationSetting(): HasOne
    {
        return $this->hasOne(UserNotificationSetting::class, 'user_id', 'id');
    }

    public function rankedUsers(): HasManyThrough
    {
        return $this->hasManyThrough(
            User::class,
            UserRank::class,
            'rank_id',
            'id',
            'id',
            'user_id'
        );
    }
    public function Sender(): HasMany
    {
        return $this->hasMany(Message::class, 'sender_id', 'id');
    }
    public function Receiver(): HasMany
    {
        return $this->hasMany(Message::class, 'receiver_id', 'id');
    }

    public function conversationParticipant()
    {
        return $this->morphMany(ConversationParticipant::class, 'participant_id');
    }
    public function messageReadReceipts()
    {
        return $this->hasMany(MessageReadReceipt::class, 'user_id', 'id');
    }


    public function feedbacks()
    {
        return $this->hasMany(Feedback::class, 'author_id', 'id');
    }

    public function feedbacksReceived()
    {
        return $this->hasMany(Feedback::class, 'target_user_id', 'id');
    }
    public function AchievementProgress()
    {
        return $this->hasMany(UserAchievementProgress::class, 'user_id', 'id');
    }

    public function pointLogs()
    {
        return $this->hasMany(PointLog::class, 'user_id', 'id');
    }
    /*
    |--------------------------------------------------------------------------
    | Query Scopes
    |--------------------------------------------------------------------------
    */

    public function scopeActive($query)
    {
        return $query->where('status', UserAccountStatus::ACTIVE);
    }

    public function scopeInactive($query)
    {
        return $query->where('status', UserAccountStatus::INACTIVE);
    }

    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('username', 'like', "%{$search}%")
                ->orWhere('first_name', 'like', "%{$search}%")
                ->orWhere('last_name', 'like', "%{$search}%")
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
        $query->when(array_key_exists('banned', $filters), fn($q) => $filters['banned'] ? $q->whereNotNull('banned_at') : $q->whereNull('banned_at'));
        
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
        return $this->account_status->label();
    }

    public function getStatusColorAttribute(): string
    {
        return $this->account_status->color();
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
            ? $this->avatar
            : 'default_avatar';
    }

    public function getDateOfBirthAttribute($value)
    {
        return $value ? Carbon::parse($value)->format('Y-m-d') : null;
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

    /**
     * Get all OTP verifications for the user.
     */

    public function otpVerifications()
    {
        return $this->morphMany(OtpVerification::class, 'verifiable');
    }

    /**
     * Get the latest OTP verification of a specific type.
     */
    public function latestOtp(OtpType $type)
    {
        return $this->otpVerifications()
            ->where('type', $type)
            ->latest()
            ->first();
    }

    /**
     * Create a new OTP verification.
     */
    public function createOtp(OtpType $type, int $expiresInMinutes = 10): OtpVerification
    {
        // Invalidate old OTPs of same type
        $this->otpVerifications()
            ->where('type', $type)
            ->whereNull('verified_at')
            ->update(['expires_at' => now()]);

        $otp = sprintf('%06d', mt_rand(0, 999999));

        return $this->otpVerifications()->create([
            'type' => $type,
            'code' => $otp,
            'expires_at' => now()->addMinutes($expiresInMinutes),
            'attempts' => 0,
        ]);
    }

    /**
     * Mark email as verified.
     */
    public function markEmailAsVerified()
    {
        return $this->forceFill([
            'email_verified_at' => now(),
        ])->save();
    }

    /**
     * Mark phone as verified.
     */
    public function markPhoneAsVerified()
    {
        return $this->forceFill([
            'phone_verified_at' => now(),
        ])->save();
    }

    // Translations

    public function getTranslationConfig(): array
    {
        return [
            'fields' => ['description'],
            'relation' => 'userTranslations',
            'model' => UserTranslations::class,
            'foreign_key' => 'user_id',
            'field_mapping' => [
                'description' => 'description',
            ],
        ];
    }

    public function translatedDescription($languageIdOrLocale): string
    {
        return $this->getTranslated('description', $languageIdOrLocale) ?? $this->description;
    }


    public function cloudinaryFiles()
    {
        return $this->hasMany(CloudinaryFile::class);
    }

    public function images()
    {
        return $this->cloudinaryFiles()->where('resource_type', 'image');
    }



    public function isOnline(): bool
    {
        return $this->last_seen_at !== null && $this->last_seen_at->gt(now()->subMinutes(2));
    }

    public function offlineStatus(): string
    {
        return (!$this->isOnline() && $this->last_seen_at !== null && $this->last_seen_at->diffInMinutes(now()) < 60) ? round($this->last_seen_at->diffInMinutes(now())) . ' min ago' : 'Offline';
    }

    public function isVerifiedSeller(): bool
    {
        $this->load('seller');
        return (bool) ($this->seller?->seller_verified_at !== null);
    }
}
