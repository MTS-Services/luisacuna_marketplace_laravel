<?php

namespace App\Livewire;

use App\Services\CloudinaryService;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Validate;

class ImageUploader extends Component
{
    use WithFileUploads;

    #[Validate('required|file|max:10240')]
    public $photo;

    public $uploadedPhotos = [];
    public $uploading = false;

    protected CloudinaryService $cloudinaryService;

    public function boot(CloudinaryService $cloudinaryService)
    {
        $this->cloudinaryService = $cloudinaryService;
    }

    public function mount()
    {
        $this->loadUploadedPhotos();
    }

    public function uploadImage()
    {
        $this->validate();
        $this->uploading = true;

        try {
            // Upload using the service
            $file = $this->cloudinaryService->upload($this->photo, [
                'folder' => 'uploads/images',
                'tags' => ['user-upload', 'image'],
                'description' => 'User uploaded image',
            ]);

            if ($file) {
                $this->uploadedPhotos[] = [
                    'id' => $file->id,
                    'path' => $file->public_id,
                    'url' => $file->url,
                    'name' => $file->original_filename,
                    'thumbnail' => $file->thumbnail_url,
                ];

                session()->flash('message', 'Image uploaded successfully!');
                $this->reset('photo');
            } else {
                session()->flash('error', 'Upload failed. Please try again.');
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Upload failed: ' . $e->getMessage());
        } finally {
            $this->uploading = false;
        }
    }

    public function uploadMultiple()
    {
        $this->validate([
            'photos.*' => 'required|image|max:10240',
        ]);

        $result = $this->cloudinaryService->uploadMultiple($this->photos, [
            'folder' => 'uploads/images',
            'tags' => ['user-upload', 'batch'],
        ]);

        if ($result['success_count'] > 0) {
            session()->flash('message', "{$result['success_count']} images uploaded successfully!");
            $this->loadUploadedPhotos();
        }

        if ($result['failed_count'] > 0) {
            session()->flash('error', "{$result['failed_count']} images failed to upload.");
        }

        $this->reset('photos');
    }

    public function deleteImage($index)
    {
        try {
            $photo = $this->uploadedPhotos[$index];

            $deleted = $this->cloudinaryService->delete($photo['path']);

            if ($deleted) {
                unset($this->uploadedPhotos[$index]);
                $this->uploadedPhotos = array_values($this->uploadedPhotos);
                session()->flash('message', 'Image deleted successfully!');
            } else {
                session()->flash('error', 'Delete failed. Please try again.');
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Delete failed: ' . $e->getMessage());
        }
    }

    protected function loadUploadedPhotos()
    {
        $files = $this->cloudinaryService->getFilesByUser(auth()->id(), 'image');

        $this->uploadedPhotos = $files->map(function ($file) {
            return [
                'id' => $file->id,
                'path' => $file->public_id,
                'url' => $file->url,
                'name' => $file->original_filename,
                'thumbnail' => $file->thumbnail_url,
            ];
        })->toArray();
    }

    public function render()
    {
        return view('livewire.image-uploader');
    }
}
