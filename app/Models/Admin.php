<?php

namespace App\Models;

use App\Models\AuthBaseModel;

class Admin extends AuthBaseModel
{
    protected $fillable = [
        'name',
        'email',
        'password',
        'last_synced_at',
        'otp',
        'otp_expires_at',
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
        ];
    }

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->appends = array_merge(parent::getAppends(), [
            'status_label',
            'status_color',
            'status_btn_label',
            'status_btn_color',

            'modified_image',
        ]);
    }
}
