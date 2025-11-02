<?php

namespace App\Http\Controllers\Auth\User\Socialite;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;
use Exception;

class GoogleAuthController extends Controller
{
    /**
     * Redirect to Google OAuth
     */
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Handle Google OAuth callback
     */
    public function callback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            $user = $this->findOrCreateUser($googleUser);
            Auth::login($user);

            return redirect()->intended('user/orders/purchased-orders');
        } catch (Exception $e) {
            return redirect()->route('login')
                ->with('error', 'Unable to login with Google. Please try again.');
        }
    }

    /**
     * Find existing user or create new one
     */
    private function findOrCreateUser($googleUser): User
    {
        $user = User::where('google_id', $googleUser->id)
            ->orWhere('email', $googleUser->email)
            ->first();

        return $user ? $this->updateExistingUser($user, $googleUser) : $this->createNewUser($googleUser);
    }

    /**
     * Update existing user with Google data
     */
    private function updateExistingUser(User $user, $googleUser): User
    {
        if (!$user->google_id) {
            $user->update([
                'google_id' => $googleUser->id,
                'avatar' => $googleUser->avatar,
                'email_verified_at' => $user->email_verified_at ?? now(),
            ]);
        }

        return $user;
    }

    /**
     * Create new user from Google data
     */
    private function createNewUser($googleUser): User
    {
        $firstName = $googleUser->user['given_name'] ?? '';
        $lastName = $googleUser->user['family_name'] ?? '';

        if (empty($firstName) && empty($lastName)) {
            [$firstName, $lastName] = $this->parseName($googleUser->name);
        }

        $username = $this->generateUniqueUsername($googleUser->email);

        $userData = [
            'username' => $username,
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email' => $googleUser->email,
            'google_id' => $googleUser->id,
            'avatar' => $googleUser->avatar,
            'password' => Hash::make(Str::random(32)),
            'email_verified_at' => now(),
        ];

        return DB::transaction(fn() => User::create($userData));
    }

    /**
     * Parse full name into first and last name (backup method)
     */
    private function parseName(string $fullName): array
    {
        $parts = array_filter(explode(' ', trim($fullName)));

        if (empty($parts)) return ['User', ''];
        if (count($parts) === 1) return [$parts[0], ''];

        $lastName = array_pop($parts);
        $firstName = implode(' ', $parts);

        return [$firstName, $lastName];
    }

    /**
     * Generate unique username from email
     */
    private function generateUniqueUsername(string $email): string
    {
        $base = strtolower(explode('@', $email)[0]);
        $base = preg_replace('/[^a-z0-9_]/', '', $base);
        $base = substr($base, 0, 20);
        if (empty($base)) $base = 'user';

        $username = $base;
        $suffix = 1;

        while (User::where('username', $username)->exists()) {
            $username = $base . $suffix;
            $suffix++;
            if ($suffix > 9999) {
                $username = $base . Str::random(4);
                break;
            }
        }

        return $username;
    }
}
