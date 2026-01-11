<?php

namespace App\Actions\User;

use App\Models\Rank;
use App\Models\User;
use App\Models\UserPoint;
use App\Events\User\UserCreated;
use App\Models\UserRank;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Services\Cloudinary\CloudinaryService;
use Illuminate\Support\Facades\Log;

class CreateAction
{
    public function __construct(
        protected UserRepositoryInterface $interface,
         protected CloudinaryService $cloudinaryService
    ) {}

    public function execute(array $data): User
    {
        return DB::transaction(function () use ($data) {

            if ($data['avatar']) {
                
                $uploadedAvatar = $this->cloudinaryService->upload($data['avatar'], ['folder' => 'users']);
                $data['avatar'] = $uploadedAvatar->publicId;
            }


            // Create user

            $newData = $this->interface->create($data);

            $lowestRank = Rank::orderBy('minimum_points', 'asc')->first();

            UserPoint::create([
                'user_id' => $newData->id,
                'points' => 0,
                'note' => 'New User Created',
            ]);
            UserRank::create([
                'user_id' => $newData->id,
                'rank_id' => $lowestRank->id,
                'activated_at' => now(),
                'is_active' => 1,
            ]);

            event(new UserCreated($newData));


             $freshData = $newData->fresh();

            // Dispatch translation job in background
            // Assuming the source language is English (EN)
            // Dispatch translation job (English is default, will be saved but not translated)
            Log::info('Dispatching TranslateModelJob for userId: ' . $freshData->id);

            // $freshData->dispatchTranslation(
            //     defaultLanguageLocale: 'en',

            //     targetLanguageIds: null
            // );\

              $freshData->dispatchTranslation(
                defaultLanguageLocale: app()->getLocale() ?? 'en',
                forceTranslation: true,
                targetLanguageIds: null
            );

           

            return $freshData;
        });
    }
}
