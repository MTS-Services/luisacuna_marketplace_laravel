<?php

namespace App\Support;

use Illuminate\Auth\Access\AuthorizationException;

class SuperAdminGuard
{
    /**
     * Ensure the current admin has the Super Admin role. Throws AuthorizationException otherwise.
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public static function requireSuperAdmin(): void
    {
        $admin = admin();

        if (! $admin || ! $admin->hasRole('Super Admin')) {
            throw new AuthorizationException(
                'Only a Super Admin can perform this action.'
            );
        }
    }

    /**
     * Check whether the current admin has the Super Admin role.
     */
    public static function isSuperAdmin(): bool
    {
        $admin = admin();

        return $admin && $admin->hasRole('Super Admin');
    }
}
