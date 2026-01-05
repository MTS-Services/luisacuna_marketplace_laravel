<?php

namespace App\Actions\Platform;

use App\Events\Server\ServerCreated;
use App\Models\Platform;
use App\Repositories\Contracts\PlatformRepositoryInterface;
use App\Services\Cloudinary\CloudinaryService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CreateAction
{
    public function __construct(
        protected PlatformRepositoryInterface $interface
        , protected CloudinaryService $cloudinaryService
    ) {
    }


    public function execute(array $data): Platform
    {
        return DB::transaction(function () use ($data) {

            
            if ($data['icon']) {
                
            
                $uploadIcon = $this->cloudinaryService->upload($data['icon'], ['folder' => 'platforms']);
                $data['icon'] = $uploadIcon->publicId;
            }

          
            $newData = $this->interface->create($data);

          
            return $newData->fresh();
        });
    }
}
