<?php

namespace App\Actions\Rarity;

use App\Models\Rarity;
use Illuminate\Support\Facades\DB;
use App\Repositories\Contracts\RarityRepositoryInterface;
use Storage;


class CreateAction
{

    public function __construct(protected RarityRepositoryInterface $interface)
    {
    }


    public function execute(array $data): Rarity
    {
        return DB::transaction(function () use ($data) {

            if ($data['icon']) {
                $prefix = uniqid('IMX') . '-' . time() . '-' . uniqid();
                $fileName = $prefix . '-' . $data['icon']->getClientOriginalName();
                $data['icon'] = Storage::disk('public')->putFileAs('icons', $data['icon'], $fileName);
            }
            $newData = $this->interface->create($data);

            return $newData->fresh();
        });
    }

}
