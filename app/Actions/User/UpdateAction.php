<?php

namespace App\Actions\User;

use App\Events\User\AccountStatusChnage;
use App\Events\User\UserUpdated;
use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class UpdateAction
{
    public function __construct(
        protected UserRepositoryInterface $interface
    ) {}

    public function execute(int $id, array $data): User
    {
        $newSingleAvatarPath = null;
        $uploadedPaths = []; // Multiple avatar paths

        try {
            return DB::transaction(function () use ($id, $data, &$newSingleAvatarPath, &$uploadedPaths) {

                $user = $this->interface->find($id);

                if (!$user) {
                    Log::error('User not found', ['user_id' => $userId]);
                    throw new \Exception('User not found');
                }

                $oldData = $user->getAttributes();
                $newData = $data;

                // --- 1. Single Avatar Handling ---
                $oldAvatarPath = Arr::get($oldData, 'avatar');
                $uploadedAvatar = Arr::get($data, 'avatar');

                if ($uploadedAvatar instanceof UploadedFile) {
                    // Delete old file permanently (File deletion is non-reversible)
                    if ($oldAvatarPath && Storage::disk('public')->exists($oldAvatarPath)) {
                        Storage::disk('public')->delete($oldAvatarPath);
                    }
                    // Store the new file and track path for rollback
                    $prefix = uniqid('IMX') . '-' . time() . '-' . uniqid();
                    $fileName = $prefix . '-' . $uploadedAvatar->getClientOriginalName();

                    $newSingleAvatarPath = Storage::disk('public')->putFileAs('users', $uploadedAvatar, $fileName);
                    $newData['avatar'] = $newSingleAvatarPath;
                } elseif (Arr::get($data, 'remove_file')) {
                    if ($oldAvatarPath && Storage::disk('public')->exists($oldAvatarPath)) {
                        Storage::disk('public')->delete($oldAvatarPath);
                    }
                    $newData['avatar'] = null;
                }
                // Cleanup temporary/file object keys
                if (!$newData['remove_file'] && !$newSingleAvatarPath) {
                    $newData['avatar'] = $oldAvatarPath ?? null;
                }
                unset($newData['remove_file']);

                // --- 2. Password Handling ---
                $newPassword = Arr::get($data, 'password');
                if (!empty($newPassword)) {
                    $newData['password'] = Hash::make($newPassword);
                } else {
                    unset($newData['password']);
                }

                $updated = $this->interface->update($id, $newData);

                if (!$updated) {
                    throw new \Exception('Failed to update Data');
                }


                // --- Track account_status change BEFORE update ---
                $oldAccountStatus = Arr::get($oldData, 'account_status');
                $newAccountStatus = Arr::get($data, 'account_status');
                $reason = Arr::get($data, 'reason');

                // Status change check and reason not null
                if ($oldAccountStatus !== $newAccountStatus && $reason) {
                    // Event fire
                    event(new AccountStatusChnage($user, $oldAccountStatus, $newAccountStatus, $reason));
                }


                // Refresh model and dispatch event
                $user = $user->fresh();
                $newAttributes = $user->getAttributes();
                $changes = [];

                foreach ($newAttributes as $key => $value) {
                    if (in_array($key, ['created_at', 'updated_at', 'id'])) continue;
                    $oldValue = Arr::get($oldData, $key);
                    if ($oldValue !== $value) {
                        $changes[$key] = ['old' => $oldValue, 'new' => $value];
                    }
                }

                if (!empty($changes)) {
                    event(new UserUpdated($user, $changes));
                }

                return $user;
            });
        } catch (\Exception $e) {

            // --- FILE ROLLBACK MECHANISM: Delete files uploaded in this transaction ---

            // 1. Rollback single avatar file
            if ($newSingleAvatarPath && Storage::disk('public')->exists($newSingleAvatarPath)) {
                Storage::disk('public')->delete($newSingleAvatarPath);
                Log::warning('File Rollback: Deleted single new avatar file.', ['path' => $newSingleAvatarPath]);
            }

            // Re-throw the exception to communicate failure
            throw $e;
        }
    }
}
