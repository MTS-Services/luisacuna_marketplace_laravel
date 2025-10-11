<?php

namespace App\Actions\User;

use App\DTOs\User\UpdateUserDTO;
use App\Events\User\UserUpdated;
use App\Models\User;
use App\Repositories\Contracts\User\UserRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class UpdateUserAction
{
    public function __construct(
        protected UserRepositoryInterface $userRepository
    ) {}

    public function execute(int $userId, UpdateUserDTO $dto): User
    {
        return DB::transaction(function () use ($userId, $dto) {
            $user = $this->userRepository->find($userId);

            if (!$user) {
                throw new \Exception('User not found');
            }

            $oldData = $user->toArray();
            $data = $dto->toArray();

            // Handle avatar upload
            if ($dto->avatar) {
                // Delete old avatar
                if ($user->avatar) {
                    Storage::disk('public')->delete($user->avatar);
                }
                $data['avatar'] = $dto->avatar->store('avatars', 'public');
            }

            // Handle avatar removal
            if ($dto->removeAvatar && $user->avatar) {
                Storage::disk('public')->delete($user->avatar);
                $data['avatar'] = null;
            }

            // Update user
            $this->userRepository->update($userId, $data);
            $user = $user->fresh();

            // Calculate changes
            $changes = array_diff_assoc($user->toArray(), $oldData);

            // Dispatch event
            event(new UserUpdated($user, $changes));

            return $user;
        });
    }
}