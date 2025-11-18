<?php

namespace App\Actions\Server;

use App\Events\Server\ServerCreated;
use App\Models\Server;
use App\Repositories\Contracts\ServerRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CreateAction
{
    public function __construct(
        protected ServerRepositoryInterface $interface
    ) {
    }


    public function execute(array $data): Server
    {
        return DB::transaction(function () use ($data) {

             if ($data['icon']) {
                $prefix = uniqid('IMX') . '-' . time() . '-' . uniqid();
                $fileName = $prefix . '-' . $data['icon']->getClientOriginalName();
                $data['icon'] = Storage::disk('public')->putFileAs('icons', $data['icon'], $fileName);
            }

            $newData = $this->interface->create($data);
            // Dispatch event
            event(new ServerCreated($newData));
            
            return $newData->fresh();
        });
    }
}
