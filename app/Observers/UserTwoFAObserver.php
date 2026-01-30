<?php

namespace App\Observers;

use App\Models\User;
use App\Enums\PointType;
use App\Models\PointLog;
use App\Models\UserPoint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UserTwoFAObserver
{
    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        //
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        // Check: two_factor_confirmed_at changed from null to a date AND user hasn't received reward yet
        if (
            $user->wasChanged('two_factor_confirmed_at') &&
            $user->two_factor_confirmed_at !== null &&
            $user->is_two_factor_verified != true
        ) {
            try {
                DB::transaction(function () use ($user) {

                    // Create point log
                    $pointLog = PointLog::create([
                        'user_id'     => $user->id,
                        'source_id'   => $user->id,
                        'source_type' => User::class,
                        'type'        => PointType::EARNED->value,
                        'points'      => 1000,
                        'notes'       => '2FA enabled and confirmed for the first time',
                    ]);

                    // Update or create user points
                    $userPoint = UserPoint::firstOrNew(['user_id' => $user->id]);
                    $userPoint->points = ($userPoint->points ?? 0) + $pointLog->points;
                    $userPoint->save();

                    // Mark as verified (direct DB query to avoid infinite loop)
                    DB::table('users')
                        ->where('id', $user->id)
                        ->update([
                            'is_two_factor_verified' => true,
                            'updated_at' => now(),
                        ]);

                    Log::info('2FA Reward Granted Successfully', [
                        'user_id' => $user->id,
                        'points_added' => $pointLog->points,
                        'total_points' => $userPoint->points,
                    ]);
                });
            } catch (\Exception $e) {
                Log::error('2FA Reward Failed', [
                    'user_id' => $user->id,
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                ]);
            }
        }
    }


    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $user): void
    {
        //
    }

    /**
     * Handle the User "restored" event.
     */
    public function restored(User $user): void
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     */
    public function forceDeleted(User $user): void
    {
        //
    }
}
