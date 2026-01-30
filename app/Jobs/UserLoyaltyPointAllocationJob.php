<?php

namespace App\Jobs;

use App\Models\User;
use App\Enums\PointType;
use App\Models\PointLog;
use App\Models\UserPoint;
use App\Services\UserService;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserLoyaltyPointAllocationJob implements ShouldQueue
{
    use Queueable;


    protected User $user;
    /**
     * Create a new job instance.
     */
    public function __construct() {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {

         User::where('created_at', '<=', now()->subYear())->chunk(100, function ($users) {
                foreach ($users as $user) {
                    Log::info('UserPoint button clicked', [
                        'user_id' => $user?->id,
                    ]);

                    if (!$user) {
                        Log::warning('User not logged in');
                        return;
                    }

                    $accountAge = $user->created_at->diffInDays(now());

                    Log::info('Account age checked', [
                        'days' => $accountAge,
                    ]);

                    $alreadyGiven = PointLog::where('user_id', $user->id)
                        ->where('notes', 'like', '%Account 1 year anniversary%')
                        ->exists();

                    Log::info('Already given checked', [
                        'already_given' => $alreadyGiven,
                    ]);

                    if ($accountAge >= 365 && !$alreadyGiven) {

                        Log::info('Condition passed → giving points');

                        $pointLog = PointLog::create([
                            'user_id' => $user->id,
                            'source_id' => $user->id,
                            'source_type' => User::class,
                            'type' => PointType::EARNED->value,
                            'points' => 2000,
                            'notes' => 'Account 1 year anniversary points',
                        ]);

                        $userPoint = UserPoint::firstOrNew(['user_id' => $user->id]);
                        $userPoint->points += $pointLog->points;
                        $userPoint->save();

                        Log::info('Points added successfully', [
                            'points' => $pointLog->points,
                        ]);

                    } else {

                        Log::info('Condition failed → no points', [
                            'account_age' => $accountAge,
                            'already_given' => $alreadyGiven,
                        ]);
                    }
                }
            });
    }
}
