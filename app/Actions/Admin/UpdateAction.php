<?php

namespace App\Actions\Admin;

use App\Events\Admin\AdminUpdated;
use App\Models\Admin;
use App\Repositories\Contracts\AdminRepositoryInterface;
use App\Services\Cloudinary\CloudinaryService;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class UpdateAction
{
    public function __construct(
        protected AdminRepositoryInterface $interface,
        protected CloudinaryService $cloudinaryService,
    ) {}

    public function execute(int $id, array $data): Admin
    {
        // 1. Initialize variables to track newly uploaded files for rollback
        $newSingleAvatarPath = null;
        $uploadedPaths = []; // Multiple avatar paths

        try {
            // Start the database transaction
            return DB::transaction(function () use ($id, $data, &$newSingleAvatarPath, &$uploadedPaths) {
                $admin = $this->interface->find($id);

                if (!$admin) {
                    Log::error('Admin not found', ['admin_id' => $id]);
                    throw new \Exception('Data not found');
                }

                $oldData = $admin->getAttributes();
                $newData = $data;

                // --- 1. Single Avatar Handling ---
                $oldAvatarPath = Arr::get($oldData, 'avatar');
                $uploadedAvatar = Arr::get($data, 'avatar');

                if ($uploadedAvatar instanceof UploadedFile) {
                    // Delete old file permanently (File deletion is non-reversible)
                    if ($oldAvatarPath) {
                        $this->cloudinaryService->delete($oldAvatarPath);
                     }

                    $uploadedAvatar = $this->cloudinaryService->upload($uploadedAvatar, ['folder' => 'admins']);

                    $newSingleAvatarPath = $uploadedAvatar->publicId;

                    $newData['avatar'] = $newSingleAvatarPath;

                } elseif (Arr::get($data, 'remove_file')) {
                    if ($oldAvatarPath) {
                        $this->cloudinaryService->delete($oldAvatarPath);
                    }
                    $newData['avatar'] = null;
                }
                // Cleanup temporary/file object keys
                if (!$newData['remove_file'] && !$newSingleAvatarPath) {
                    dd('checked');
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

                // --- 3. Multiple Avatars Handling (Pivot Table) ---

                // a. Prepare new file uploads
                $newAvatars = Arr::get($data, 'avatars');

                if (is_array($newAvatars) && !empty($newAvatars)) {
                    $uploadedPaths = array_map(function ($avatar) {
                        if ($avatar instanceof UploadedFile) {
                            $prefix = uniqid('IMX') . '-' . time() . '-' . uniqid();
                            $fileName = $prefix . '-' . $avatar->getClientOriginalName();
                            // Upload file and collect path
                            return Storage::disk('public')->putFileAs('admins', $avatar, $fileName);
                        }
                        return null;
                    }, $newAvatars);

                    $uploadedPaths = array_filter($uploadedPaths);
                }

                // Pass the new uploaded file paths to the repository
                $newData['avatars'] = $uploadedPaths;

                // b. Handle file removals from storage
                $removedFiles = Arr::get($data, 'removed_files', []);
                if (!empty($removedFiles)) {
                    foreach ($removedFiles as $file) {
                        // Action deletes the file from disk (Permanent deletion)
                        if (Storage::disk('public')->exists($file)) {
                            Storage::disk('public')->delete($file);
                        }
                    }
                    // The repository will use $newData['removed_files'] to delete DB records
                    $newData['removed_files'] = $removedFiles;
                } else {
                    unset($newData['removed_files']);
                }

                // --- 4. Update Admin ---
                Log::info('Data sent to repository', ['data' => $newData]);
               
                $updated = $this->interface->update($id, $newData);

                if (!$updated) {
                    throw new \Exception('Failed to update Data');
                }

                // Refresh model and dispatch event
                $admin = $admin->fresh();
                $newAttributes = $admin->getAttributes();
                $changes = [];

                foreach ($newAttributes as $key => $value) {
                    if (in_array($key, ['created_at', 'updated_at', 'id'])) continue;
                    $oldValue = Arr::get($oldData, $key);
                    if ($oldValue !== $value) {
                        $changes[$key] = ['old' => $oldValue, 'new' => $value];
                    }
                }

                if (!empty($changes)) {
                    event(new AdminUpdated($admin, $changes));
                }

                return $admin;
            });
        } catch (\Exception $e) {
            // --- FILE ROLLBACK MECHANISM: Delete files uploaded in this transaction ---

            // 1. Rollback single avatar file
            if ($newSingleAvatarPath && Storage::disk('public')->exists($newSingleAvatarPath)) {
                Storage::disk('public')->delete($newSingleAvatarPath);
                Log::warning('File Rollback: Deleted single new avatar file.', ['path' => $newSingleAvatarPath]);
            }

            // 2. Rollback multiple avatar files
            if (!empty($uploadedPaths)) {
                foreach ($uploadedPaths as $path) {
                    if (Storage::disk('public')->exists($path)) {
                        Storage::disk('public')->delete($path);
                    }
                }
                Log::warning('File Rollback: Deleted ' . count($uploadedPaths) . ' new multiple avatar files.');
            }

            // Re-throw the exception to communicate failure
            throw $e;
        }
    }
}
