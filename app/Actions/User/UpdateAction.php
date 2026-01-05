<?php

namespace App\Actions\User;

use App\Models\User;
use Illuminate\Support\Arr;
use App\Enums\UserAccountStatus;
use App\Events\User\UserUpdated;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use App\Events\User\AccountStatusChnage;
use App\Mail\User\UserAccountStatusChanged;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Services\Cloudinary\CloudinaryService;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class UpdateAction
{
    public function __construct(
        protected UserRepositoryInterface $interface,
        protected CloudinaryService $cloudinaryService,
    ) {}

    public function execute(int $id, array $data): User
    {
        $newSingleAvatarPath = null;
        $uploadedPaths = []; // Multiple avatar paths

        try {
            return DB::transaction(function () use ($id, $data, &$newSingleAvatarPath, &$uploadedPaths) {

                $user = $this->interface->find($id);

                if (!$user) {
                    Log::error('User not found', ['user_id' => $id]);
                    throw new \Exception('User not found');
                }

                $oldData = $user->getAttributes();
                $newData = $data;

                // --- 1. Single Avatar Handling ---
                $oldAvatarPath = Arr::get($oldData, 'avatar');
                $uploadedAvatar = Arr::get($data, 'avatar');

                if ($uploadedAvatar instanceof UploadedFile) {
                    // Delete old file permanently (File deletion is non-reversible)
                    if ($oldAvatarPath) {
                        $this->cloudinaryService->delete($oldAvatarPath);
                     }
                    // Store the new file and track path for rollback

                    $uploadedAvatar = $this->cloudinaryService->upload($uploadedAvatar, ['folder' => 'users']);

                    $newSingleAvatarPath = $uploadedAvatar->publicId;
                    $newData['avatar'] = $newSingleAvatarPath;

                } elseif (Arr::get($data, 'remove_file')) {
                  
                    if ($oldAvatarPath) {
                        $this->cloudinaryService->delete($oldAvatarPath);
                     }

                    $newData['avatar'] = null;
                }

                if (!isset($newData['remove_file']) || (!$newData['remove_file'] && !$newSingleAvatarPath)) {
                    
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
                    // event(new AccountStatusChnage($user, $oldAccountStatus, $newAccountStatus, $reason));
                    if ($newAccountStatus === UserAccountStatus::SUSPENDED->value) {
                        Mail::to($user->email)->send(
                            new UserAccountStatusChanged(
                                $user,
                                $oldAccountStatus,
                                $newAccountStatus,
                                $reason
                            )
                        );

                        Log::info('Account Suspended email sent', [
                            'user_id' => $user->id,
                            'user_email' => $user->email,
                            'old_status' => $oldAccountStatus,
                            'new_status' => $newAccountStatus,
                            'reason' => $reason
                        ]);
                    }
                }


                // Refresh model and dispatch event
                $freshData = $user->fresh();
                $newAttributes = $freshData->getAttributes();
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


                $firstNameChanged = isset($newData['first_name']) && $newData['first_name'] !== $oldData['first_name'];
                $lastNameChanged = isset($newData['last_name']) && $newData['last_name'] !== $oldData['last_name'];
                // ---- RE-TRANSLATE IF NAME CHANGED ----
                if ($firstNameChanged || $lastNameChanged) {
                    Log::info('User Frist name name changed, dispatching translation job', [
                        'user_id' => $id,
                        'old_first_name' => $oldData['first_name'],
                        'new_first_name' => $newData['first_name'],
                        'old_last_name' => $oldData['last_name'],
                        'new_last_name' => $newData['last_name'],
                    ]);

                    $freshData->dispatchTranslation(
                        defaultLanguageLocale: 'en',
                        targetLanguageIds: null
                    );
                }

                return $freshData;
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
