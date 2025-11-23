<?php

namespace App\Actions\Type;

use App\Models\Type;
use Illuminate\Support\Facades\DB;
use App\Repositories\Contracts\TypeRepositoryInterface;
use Storage;


class CreateAction
{

    public function __construct(protected TypeRepositoryInterface $interface)
    {
    }


    public function execute(array $data): Type
    {
        return DB::transaction(function () use ($data) {

            if ($data['icon']) {
                $prefix = uniqid('IMX') . '-' . time() . '-' . uniqid();
                $fileName = $prefix . '-' . $data['icon']->getClientOriginalName();
                $data['icon'] = Storage::disk('public')->putFileAs('types', $data['icon'], $fileName);
            }
            $newData = $this->interface->create($data);

            return $newData->fresh();
        });
    }

}
