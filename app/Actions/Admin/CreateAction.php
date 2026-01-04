<?php

namespace App\Actions\Admin;


use App\Events\Admin\AdminCreated;
use App\Models\Admin;
use App\Repositories\Contracts\AdminRepositoryInterface;
use App\Services\Cloudinary\CloudinaryService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CreateAction
{
    public function __construct(
        protected AdminRepositoryInterface $interface,
        protected CloudinaryService $cloudinaryService
    ) {}
    public function execute(array $data): Admin
    {
        return DB::transaction(function () use ($data) {
            if ($data['avatar']) {
                // $prefix = uniqid('IMX') . '-' . time() . '-' . uniqid();
                // $fileName = $prefix . '-' . $data['avatar']->getClientOriginalName();
                // $data['avatar'] = Storage::disk('public')->putFileAs('admins', $data['avatar'], $fileName);
                $uploadedAvatar = $this->cloudinaryService->upload($data['avatar'], ['folder' => 'admins']);
                $data['avatar'] = $uploadedAvatar->publicId;
            }

            // if ($data['avatars']) {
            //     $data['avatars'] = array_map(function ($avatar) {
            //         $prefix = uniqid('IMX') . '-' . time() . '-' . uniqid();
            //         $fileName = $prefix . '-' . $avatar->getClientOriginalName();
            //         return Storage::disk('public')->putFileAs('admins', $avatar, $fileName);
            //     }, $data['avatars']);

            //     if (!is_array($data['avatars'])) {
            //         $data['avatars'] = [$data['avatars']];
            //     }
            //     $data['avatars'] = $data['avatars'] ?? [];
            // }

            $newData = $this->interface->create($data);
            // Dispatch event
            event(new AdminCreated($newData));

            return $newData->fresh();
        });
    }
}
