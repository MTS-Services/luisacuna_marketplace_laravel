<?php

namespace App\Livewire;

use App\Models\CloudinaryFile;
use Livewire\Component;
use Livewire\WithFileUploads;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Support\Facades\Log;

class ImageUploader extends Component
{
    use WithFileUploads;

    public $photo;
    public $uploadedPhotos = [];
    public $uploading = false;

    protected $rules = [
        'photo' => 'required|image|max:10240', // 10MB Max
    ];

    public function updatedPhoto()
    {
        $this->validate();
    }

    public function uploadImage()
    {
        $this->validate();
        $this->uploading = true;

        try {
            // Upload using Cloudinary Facade
            $result = Cloudinary::upload($this->photo->getRealPath(), [
                'folder' => env('CLOUDINARY_PREFIX', 'swapy') . '/uploads/images',
            ]);

            $publicId = $result->getPublicId();
            $secureUrl = $result->getSecurePath();

            // Store in array for display
            $this->uploadedPhotos[] = [
                'path' => $publicId,
                'url' => $secureUrl,
                'name' => $this->photo->getClientOriginalName(),
            ];

            // Save to database
            CloudinaryFile::create([
                'user_id' => auth()->id(),
                'public_id' => $publicId,
                'url' => $secureUrl,
                'resource_type' => 'image',
                'format' => $result->getExtension(),
                'size' => $result->getSize(),
                'width' => $result->getWidth(),
                'height' => $result->getHeight(),
                'original_filename' => $this->photo->getClientOriginalName(),
            ]);

            session()->flash('message', 'Image uploaded successfully!');
            $this->reset('photo');
        } catch (\Exception $e) {
            Log::error('Cloudinary Upload Error', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            session()->flash('error', 'Upload failed: ' . $e->getMessage());
        } finally {
            $this->uploading = false;
        }
    }

    public function deleteImage($index)
    {
        try {
            $photo = $this->uploadedPhotos[$index];

            // Delete from Cloudinary
            Cloudinary::destroy($photo['path']);

            // Delete from database
            CloudinaryFile::where('public_id', $photo['path'])->delete();

            // Remove from array
            unset($this->uploadedPhotos[$index]);
            $this->uploadedPhotos = array_values($this->uploadedPhotos);

            session()->flash('message', 'Image deleted successfully!');
        } catch (\Exception $e) {
            Log::error('Cloudinary Delete Error', [
                'message' => $e->getMessage(),
            ]);

            session()->flash('error', 'Delete failed: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.image-uploader');
    }
}
