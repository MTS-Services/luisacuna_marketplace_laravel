<?php

namespace App\Http\Controllers\Auth\User\Socialite;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Facades\Socialite;
use Exception;

class FacebookController extends Controller
{
    /**
     * Redirect to Facebook for authentication
     */
    public function redirectToFacebook()
    {
        try {
            Log::info('Facebook Login: Redirecting to Facebook');
            return Socialite::driver('facebook')
                ->scopes(['email', 'public_profile'])
                ->fields(['id', 'name', 'email', 'first_name', 'last_name'])
                ->with(['auth_type' => 'rerequest'])
                ->redirect();
        } catch (Exception $e) {
            Log::error('Facebook Login: Redirect Error - ' . $e->getMessage());
            return redirect('/login')->withErrors(['error' => 'Failed to connect to Facebook: ' . $e->getMessage()]);
        }
    }

    /**
     * Handle Facebook callback
     */
    public function handleFacebookCallback()
    {
        try {
            Log::info('Facebook Login: Callback started');

            // Get Facebook user
            $facebookUser = Socialite::driver('facebook')->user();
            
            // Debug: Log everything Facebook returns
            Log::info('Facebook Login: Complete response', [
                'getRaw' => $facebookUser->getRaw(),
            ]);
            
            Log::info('Facebook Login: User data received', [
                'id' => $facebookUser->getId(),
                'name' => $facebookUser->getName(),
                'email' => $facebookUser->getEmail(),
            ]);

            // Check if email is provided
            $email = $facebookUser->getEmail();
            if (!$email) {
                Log::error('Facebook Login: No email provided by Facebook', [
                    'raw_data' => $facebookUser->getRaw()
                ]);
                
                return redirect('/login')->withErrors([
                    'error' => 'Email permission is required. Please allow email access when logging in with Facebook, or use a Facebook account with a verified email address.'
                ]);
            }

            // Find user by Facebook ID or email
            $user = User::where('facebook_id', $facebookUser->getId())
                ->orWhere('email', $email)
                ->first();

            if ($user) {
                Log::info('Facebook Login: Existing user found', ['user_id' => $user->id]);
                
                // Update Facebook ID if not set
                if (!$user->facebook_id) {
                    $user->facebook_id = $facebookUser->getId();
                    $user->save();
                    Log::info('Facebook Login: Facebook ID updated for user', ['user_id' => $user->id]);
                }
            } else {
                Log::info('Facebook Login: Creating new user');
                
                // Split the full name into first and last name
                $fullName = $facebookUser->getName();
                $nameParts = explode(' ', $fullName, 2);
                $firstName = $nameParts[0];
                $lastName = $nameParts[1] ?? '';

                // Generate unique username from email or name
                $baseUsername = $this->generateUsername($email, $firstName);
                $username = $this->ensureUniqueUsername($baseUsername);

                Log::info('Facebook Login: Generated username', ['username' => $username]);

                // Create new user
                $user = User::create([
                    'username' => $username,
                    'first_name' => $firstName,
                    'last_name' => $lastName,
                    'email' => $email,
                    'facebook_id' => $facebookUser->getId(),
                    'password' => Hash::make(uniqid()),
                    'email_verified_at' => now(),
                ]);

                Log::info('Facebook Login: New user created', ['user_id' => $user->id]);
            }

            // Log the user in
            Auth::login($user);
            Log::info('Facebook Login: User logged in successfully', ['user_id' => $user->id]);

            return redirect()->intended('user/orders/purchased-orders');

        } catch (\Laravel\Socialite\Two\InvalidStateException $e) {
            Log::error('Facebook Login: Invalid State Exception - ' . $e->getMessage());
            return redirect('/login')->withErrors(['error' => 'Session expired. Please try logging in again.']);
            
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            Log::error('Facebook Login: Client Exception - ' . $e->getMessage());
            return redirect('/login')->withErrors(['error' => 'Facebook authentication failed. Please check your app credentials.']);
            
        } catch (Exception $e) {
            Log::error('Facebook Login: General Exception - ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            return redirect('/login')->withErrors(['error' => 'Unable to login with Facebook: ' . $e->getMessage()]);
        }
    }

    /**
     * Generate username from email or name
     */
    private function generateUsername($email, $firstName)
    {
        if ($email) {
            $username = explode('@', $email)[0];
        } else {
            $username = strtolower($firstName);
        }

        $username = preg_replace('/[^a-zA-Z0-9]/', '', $username);
        return strtolower($username);
    }

    /**
     * Ensure username is unique by adding numbers if needed
     */
    private function ensureUniqueUsername($username)
    {
        $originalUsername = $username;
        $counter = 1;

        while (User::where('username', $username)->exists()) {
            $username = $originalUsername . $counter;
            $counter++;
        }

        return $username;
    }
}