<?php

namespace App\Actions\Achievement;

use App\Models\Achievement;
use Illuminate\Support\Facades\DB;
use App\Repositories\Contracts\AchievementRepositoryInterface;
use Illuminate\Support\Facades\Storage;

class CreateAction
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        protected AchievementRepositoryInterface $interface
    ) {}


    public function execute(array $data): Achievement
    {
        return DB::transaction(function () use ($data) {
            if ($data['icon']) {
                $prefix = uniqid('IMX') . '-' . time() . '-' . uniqid();
                $fileName = $prefix . '-' . $data['icon']->getClientOriginalName();
                $data['icon'] = Storage::disk('public')->putFileAs('achievements', $data['icon'], $fileName);
            }

            

            $newData = $this->interface->create($data);
           
            $freshData =  $newData->fresh();

             $freshData->dispatchTranslation(
                defaultLanguageLocale: 'en',
                targetLanguageIds: null
            );
            return $freshData;
        });
    }
}
