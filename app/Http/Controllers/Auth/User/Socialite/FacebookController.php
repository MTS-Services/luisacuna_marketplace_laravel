<?php

namespace App\Http\Controllers\Auth\User\Socialite;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\InvalidStateException;

/**
 * Class FacebookController
 */
class FacebookController extends Controller
{
    public function redirectToFacebook()
    {
        try {
            return Socialite::driver('facebook')
                ->scopes(['email', 'public_profile'])
                ->fields(['id', 'name', 'email', 'first_name', 'last_name'])
                ->with([
                    'auth_type' => 'rerequest',
                    'display' => 'popup',
                ])
                ->redirect();
        } catch (Exception $e) {
            Log::error('Facebook Login: Redirect Error - '.$e->getMessage());

            return redirect('/login')->withErrors(['error' => 'Failed to connect to Facebook.']);
        }
    }

    public function handleFacebookCallback()
    {
        try {
            $facebookUser = Socialite::driver('facebook')->user();

            $facebookId = $facebookUser->getId();
            $name = $facebookUser->getName();
            $email = $facebookUser->getEmail();
            $avatar = $facebookUser->getAvatar();

            if (! $email) {
                return redirect('/login')->withErrors(['error' => 'Facebook did not return an email address. Please ensure your Facebook account has a public email.']);
            }

            $user = User::where('facebook_id', $facebookId)->first();

            if (! $user && $email) {
                $user = User::where('email', $email)->first();
            }

            if ($user) {
                if (! $user->facebook_id) {
                    $user->facebook_id = $facebookId;
                }

                if (! $user->email && $email) {
                    $user->email = $email;
                }

                if ($avatar && ! $user->avatar) {
                    $user->avatar = $avatar;
                }

                if (! $user->email_verified_at) {
                    $user->email_verified_at = now();
                }

                if ($user->isDirty()) {
                    $user->save();
                }
            } else {
                $nameParts = explode(' ', $name ?? '', 2);
                $firstName = $nameParts[0] ?? '';
                $lastName = $nameParts[1] ?? '';

                if (! $firstName) {
                    $firstName = 'fbuser';
                }

                $baseUsername = $this->generateUsername($email, $firstName, $facebookId);
                $username = $this->ensureUniqueUsername($baseUsername);

                // ✅ Email thakle email_verified_at set hobe, na hole null
                $user = User::create([
                    'username' => $username,
                    'first_name' => $firstName,
                    'last_name' => $lastName,
                    'email' => $email,
                    'facebook_id' => $facebookId,
                    'avatar' => $avatar,
                    'password' => Hash::make(uniqid()),
                    'email_verified_at' => $email ? now() : null,
                ]);
            }
            Auth::login($user, true);

            return redirect()->route('profile', $user->username);
        } catch (InvalidStateException $e) {
            Log::error('Facebook Login: Invalid State Exception - '.$e->getMessage());

            return redirect('/login')->withErrors(['error' => 'Session expired. Please try logging in again.']);
        } catch (ClientException $e) {
            Log::error('Facebook Login: Client Exception - '.$e->getMessage());

            return redirect('/login')->withErrors(['error' => 'Facebook authentication failed. Please check your app credentials.']);
        } catch (Exception $e) {
            Log::error('Facebook Login: General Exception - '.$e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);

            return redirect('/login')->withErrors(['error' => 'Unable to login with Facebook.']);
        }
    }

    private function generateUsername($email, $firstName, $facebookId)
    {
        if ($email) {
            $username = explode('@', $email)[0];
        } elseif ($firstName) {
            $username = strtolower($firstName);
        } else {
            $username = 'fbuser'.substr($facebookId, -6);
        }

        $username = preg_replace('/[^a-zA-Z0-9]/', '', $username);

        if (strlen($username) < 3) {
            $username = 'fbuser'.substr($facebookId, -6);
        }

        return strtolower($username);
    }

    private function ensureUniqueUsername($username)
    {
        $originalUsername = $username;
        $counter = 1;

        while (User::where('username', $username)->exists()) {
            $username = $originalUsername.$counter;
            $counter++;
        }

        return $username;
    }
}
