<?php

namespace App\Actions\Tag;


use App\Models\Tag;
use Illuminate\Support\Facades\DB;
use App\Repositories\Contracts\TagRepositoryInterface;
use App\Services\Cloudinary\CloudinaryService;



class CreateAction
{

    public function __construct(protected TagRepositoryInterface $interface, protected CloudinaryService $cloudinaryService)
    {
    }


    public function execute(array $data): Tag
    {
        return DB::transaction(function () use ($data) {

            if ($data['icon']) {
                 
                $uploadIcon = $this->cloudinaryService->upload($data['icon'], ['folder' => 'tags']);

                $data['icon'] = $uploadIcon->publicId;

            }
            
            $newData = $this->interface->create($data);
            return $newData->fresh();
        });
    }

}
