<?php

namespace App\Models;

use App\Enums\AdminStatus;
use App\Models\AuthBaseModel;

class Admin extends AuthBaseModel
{
    protected $fillable = [
        'name',
        'email',
        'password',
        'email_verified_at',
        'remember_token',
        'last_synced_at',
        'otp',
        'otp_expires_at',

        'phone',
        'address',
        'status',
        'avatar',

        'created_by',
        'updated_by',
        'deleted_by',
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
            'status' => AdminStatus::class,
        ];
    }

    public function scopeActive($query)
    {
        return $query->where('status', AdminStatus::ACTIVE);
    }

    public function scopeInactive($query)
    {
        return $query->where('status', AdminStatus::INACTIVE);
    }

    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%")
                ->orWhere('phone', 'like', "%{$search}%");
        });
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['status'] ?? null, function ($query, $status) {
            $query->where('status', $status);
        });

        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->search($search);
        });

        return $query;
    }

    // Accessors
    public function getStatusLabelAttribute(): string
    {
        return $this->status->label();
    }

    public function getStatusColorAttribute(): string
    {
        return $this->status->color();
    }

    public function getAvatarUrlAttribute(): string
    {
        return $this->avatar
            ? asset('storage/' . $this->avatar)
            : 'https://ui-avatars.com/api/?name=' . urlencode($this->name);
    }

    // Methods
    public function isActive(): bool
    {
        return $this->status === AdminStatus::ACTIVE;
    }

    public function activate(): void
    {
        $this->update(['status' => AdminStatus::ACTIVE]);
    }

    public function deactivate(): void
    {
        $this->update(['status' => AdminStatus::INACTIVE]);
    }

    public function suspend(): void
    {
        $this->update(['status' => AdminStatus::SUSPENDED]);
    }

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->appends = array_merge(parent::getAppends(), [
            //
        ]);
    }
    // public function routeNotificationForMail(): string
    // {
    //     return $this->email;
    // }
   

}
