<?php

namespace App\Observers;

use App\Models\User;
use App\Models\UserPoint;
use App\Models\UserRank;

class UserPointObserver
{
    /**
     * Handle the UserPoint "created" event.
     */
    public function created(UserPoint $userPoint): void
    {
        //
    }

    /**
     * Handle the UserPoint "updated" event.
     */
    public function updated(UserPoint $userPoint): void
    {
       $point = $userPoint->points;
       $rank = UserRank::where('user_id', $userPoint->user_id)->with('rank')->first();

       $minimumValue = $rank->rank->minimum_points;
       $maximumValue = $rank->rank->maximum_points;

       if ($point >= $minimumValue && $point <= $maximumValue) {
           $rank->rank_id = $rank->rank->id;
       } elseif ($point > $maximumValue) {
           $newRank = \App\Models\Rank::where('minimum_points', '<=', $point)
               ->where('maximum_points', '>=', $point)
               ->first();
           if ($newRank) {
               $rank->rank_id = $newRank->id;
           }
       } else {
           $newRank = \App\Models\Rank::where('maximum_points', '>=', $point)
               ->orderBy('maximum_points', 'asc')
               ->first();
           if ($newRank) {
               $rank->rank_id = $newRank->id;
           }
       }
       
       $rank->save();

    }

    /**
     * Handle the UserPoint "deleted" event.
     */
    public function deleted(UserPoint $userPoint): void
    {
        //
    }

    /**
     * Handle the UserPoint "restored" event.
     */
    public function restored(UserPoint $userPoint): void
    {
        //
    }

    /**
     * Handle the UserPoint "force deleted" event.
     */
    public function forceDeleted(UserPoint $userPoint): void
    {
        //
    }
}
