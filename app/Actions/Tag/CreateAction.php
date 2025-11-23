<?php

namespace App\Actions\Tag;


use App\Models\Tag;
use Illuminate\Support\Facades\DB;
use App\Repositories\Contracts\TagRepositoryInterface;
use Storage;


class CreateAction
{

    public function __construct(protected TagRepositoryInterface $interface)
    {
    }


    public function execute(array $data): Tag
    {
        return DB::transaction(function () use ($data) {

            if ($data['icon']) {
                $prefix = uniqid('IMX') . '-' . time() . '-' . uniqid();
                $fileName = $prefix . '-' . $data['icon']->getClientOriginalName();
                $data['icon'] = Storage::disk('public')->putFileAs('tags', $data['icon'], $fileName);
            }
            $newData = $this->interface->create($data);

            return $newData->fresh();
        });
    }

}
