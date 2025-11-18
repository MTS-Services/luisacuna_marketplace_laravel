<?php

namespace App\Actions\Rank;

use App\Models\Rank;
use Illuminate\Support\Facades\DB;
use App\Repositories\Contracts\RankRepositoryInterface;
use Illuminate\Support\Facades\Storage;


class CreateAction
{

    public function __construct(protected RankRepositoryInterface $interface) {}


    public function execute(array $data): Rank
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
