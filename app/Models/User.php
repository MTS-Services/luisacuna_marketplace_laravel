<?php

namespace App\Models;

use App\Enums\UserStatus;
use App\Models\AuthBaseModel;

class User extends AuthBaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'last_synced_at',
        'otp',
        'otp_expires_at',
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
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'last_synced_at' => 'datetime',
            'otp_expires_at' => 'datetime',
            'status' => UserStatus::class,
        ];
    }

    public function isActive(): bool
    {
        return $this->status === UserStatus::Active;
    }

    public function getStatusBadgeAttribute(): string
    {
        return sprintf(
            '%s',
            $this->status->color(),
            $this->status->color(),
            $this->status->label()
        );
    }
}
