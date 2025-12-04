<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

trait FileManagementTrait
{
    public function handleSingleFileUpload($file, $folderName = 'uploads', $disk = 'public'): string
    {
        $prefix = uniqid('IMX') . '-' . time() . '-' . uniqid();
        $fileName = $prefix . '-' . $file->getClientOriginalName();
        $path = '';
        if ($disk == 'public') {
            $path = Storage::disk('public')->putFileAs($folderName, $file, $fileName);
        } elseif ($disk == 's3') {
            $path = Storage::disk('s3')->putFileAs($folderName, $file, $fileName);
        }

        return $path;
    }
}
