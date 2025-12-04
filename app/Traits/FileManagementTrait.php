<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\File\UploadedFile;

trait FileManagementTrait
{
    // public function handleSingleFileUpload($file, $folderName = 'uploads', $disk = 'public'): string
    // {
    //     $prefix = uniqid('IMX') . '-' . time() . '-' . uniqid();
    //     $fileName = $prefix . '-' . $file->getClientOriginalName();
    //     $path = '';
    //     if ($disk == 'public') {
    //         $path = Storage::disk('public')->putFileAs($folderName, $file, $fileName);
    //     } elseif ($disk == 's3') {
    //         $path = Storage::disk('s3')->putFileAs($folderName, $file, $fileName);
    //     }

    //     return $path;
    // }

    public function handleSingleFileUpload($newFile = null, ?string $oldPath = null, bool $removeKey = false, string $folderName = 'uploads', string $disk = 'public'): string
    {
        $path = '';
        if ($newFile instanceof UploadedFile) {
            // Delete old file permanently (File deletion is non-reversible)
            if ($oldPath) {
                if ($disk == 'public') {
                    if (Storage::disk('public')->exists($oldPath)) {
                        Storage::disk('public')->delete($oldPath);
                    }
                } elseif ($disk == 's3') {
                    if (Storage::disk('s3')->exists($oldPath)) {
                        Storage::disk('s3')->delete($oldPath);
                    }
                }
            }
            // Store the new file and track path for rollback
            $prefix = uniqid('IMX') . '-' . time() . '-' . uniqid();
            $fileName = $prefix . '-' . $newFile->getClientOriginalName();

            if ($disk == 'public') {
                $path = Storage::disk('public')->putFileAs($folderName, $newFile, $fileName);
            } elseif ($disk == 's3') {
                $path = Storage::disk('s3')->putFileAs($folderName, $newFile, $fileName);
            }
        } elseif ($removeKey) {
            if ($oldPath) {
                if ($disk == 'public') {
                    if (Storage::disk('public')->exists($oldPath)) {
                        Storage::disk('public')->delete($oldPath);
                    }
                } elseif ($disk == 's3') {
                    if (Storage::disk('s3')->exists($oldPath)) {
                        Storage::disk('s3')->delete($oldPath);
                    }
                }
            }
            $path = null;
        }
        // Cleanup temporary/file object keys
        if (!$removeKey && !$newFile) {
            $path = $oldPath ?? null;
        }

        return $path;
    }
}
