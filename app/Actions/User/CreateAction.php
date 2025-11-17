<?php

namespace App\Actions\User;

use App\Events\User\UserCreated;
use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CreateAction
{
    public function __construct(
        protected UserRepositoryInterface $interface
    ) {}

    public function execute(array $data): User
    {
        return DB::transaction(function () use ($data) {

              if ($data['avatar']) {
                $prefix = uniqid('IMX') . '-' . time() . '-' . uniqid();
                $fileName = $prefix . '-' . $data['avatar']->getClientOriginalName();
                $data['avatar'] = Storage::disk('public')->putFileAs('users', $data['avatar'], $fileName);
            }


            // Create user
           
            $newData = $this->interface->create($data);

            event(new UserCreated($newData));

            return $newData->fresh();
        });
    }
}