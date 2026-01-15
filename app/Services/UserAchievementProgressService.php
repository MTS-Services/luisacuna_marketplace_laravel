<?php

namespace App\Services;

use App\Models\UserAchievementProgress;

class UserAchievementProgressService{

 public function __construct(protected UserAchievementProgress $model)
 {
    
 }

 public function  getAllDatas(){
    return [];
 }

public function completedAcheievment(int $userId = null){
    if(! $userId) $userId = user()->id;

    return $this->model
        ->where('user_id', $userId)
        ->whereHas('achievement.progress', function ($q) use ($userId) {
            $q->where('user_id', $userId)
              ->whereNotNull('unlocked_at');
        })->get();
}

}