<?php

namespace App\Actions\Platform;

use App\Events\Server\ServerCreated;
use App\Models\Platform;
use App\Repositories\Contracts\PlatformRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CreateAction
{
    public function __construct(
        protected PlatformRepositoryInterface $interface
    ) {
    }


    public function execute(array $data): Platform
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
