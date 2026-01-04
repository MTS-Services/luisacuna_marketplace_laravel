<?php

namespace App\Livewire;

use App\Models\CloudinaryFile;
use App\Traits\HasCloudinaryUploads;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Log;

class ImageUploader extends Component
{
    use WithFileUploads, HasCloudinaryUploads;

    public $photo;
    public $photos = [];
    public $uploadedPhotos = [];
    public $uploading = false;

    // Validation rules
    protected $rules = [
        'photo' => 'required|image|max:10240', // 10MB
        'photos.*' => 'image|max:10240',
    ];

    /**
     * Mount - Load existing images
     */
    public function mount()
    {
        $this->loadUploadedImages();
    }

    /**
     * Load uploaded images from database
     */
    public function loadUploadedImages()
    {
        $files = CloudinaryFile::where('user_id', auth()->id())
            ->where('resource_type', 'image')
            ->latest()
            ->get();

        $this->uploadedPhotos = $files->map(function ($file) {
            return [
                'id' => $file->id,
                'path' => $file->public_id,
                'url' => $file->url,
                'name' => $file->original_filename ?? 'Untitled',
            ];
        })->toArray();
    }

    /**
     * Real-time validation
     */
    public function updatedPhoto()
    {
        $this->validate(['photo' => 'required|image|max:10240']);
    }

    /**
     * Upload single image
     */
    public function uploadImage()
    {
        try {
            $this->validate(['photo' => 'required|image|max:10240']);
            $this->uploading = true;

            Log::info('Starting image upload', [
                'filename' => $this->photo->getClientOriginalName(),
                'size' => $this->photo->getSize()
            ]);

            // Validate file with custom rules
            if (!$this->validateCloudinaryFile($this->photo, [
                'max_size' => 10240,
                'allowed_types' => ['image'],
            ])) {
                Log::warning('File validation failed');
                return;
            }

            // Upload and save to database
            $file = $this->uploadAndSave(
                file: $this->photo,
                modelClass: CloudinaryFile::class,
                additionalData: [
                    'user_id' => auth()->id(),
                ],
                uploadOptions: [
                    'folder' => 'uploads/images/' . auth()->id(),
                ]
            );

            if ($file) {
                Log::info('Image uploaded successfully', [
                    'file_id' => $file->id,
                    'public_id' => $file->public_id
                ]);

                // Reload images from database
                $this->loadUploadedImages();

                session()->flash('message', 'Image uploaded successfully!');
                $this->reset('photo');
            } else {
                Log::error('Upload failed - no file returned');
                session()->flash('error', 'Failed to upload image. Please try again.');
            }
        } catch (\Exception $e) {
            Log::error('Upload error', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            session()->flash('error', 'Upload failed: ' . $e->getMessage());
        } finally {
            $this->uploading = false;
        }
    }

    /**
     * Upload multiple images
     */
    public function uploadMultipleImages()
    {
        try {
            $this->validate(['photos.*' => 'image|max:10240']);
            $this->uploading = true;

            $results = $this->uploadMultipleToCloudinary($this->photos, [
                'folder' => 'uploads/images/' . auth()->id(),
            ]);

            foreach ($results as $result) {
                CloudinaryFile::create(array_merge(
                    $result->toArray(),
                    ['user_id' => auth()->id()]
                ));
            }

            // Reload images from database
            $this->loadUploadedImages();

            session()->flash('message', count($results) . ' images uploaded successfully!');
            $this->reset('photos');
        } catch (\Exception $e) {
            Log::error('Multiple upload error', [
                'message' => $e->getMessage()
            ]);
            session()->flash('error', 'Upload failed: ' . $e->getMessage());
        } finally {
            $this->uploading = false;
        }
    }

    /**
     * Delete image
     */
    public function deleteImage($index)
    {
        try {
            $photo = $this->uploadedPhotos[$index];
            $file = CloudinaryFile::find($photo['id']);

            if (!$file) {
                session()->flash('error', 'Image not found');
                return;
            }

            // Check ownership
            if ($file->user_id !== auth()->id()) {
                session()->flash('error', 'Unauthorized action');
                return;
            }

            if ($this->deleteAndRemove($file)) {
                // Reload images from database
                $this->loadUploadedImages();
                session()->flash('message', 'Image deleted successfully!');
            } else {
                session()->flash('error', 'Failed to delete image');
            }
        } catch (\Exception $e) {
            Log::error('Delete error', [
                'message' => $e->getMessage()
            ]);
            session()->flash('error', 'Failed to delete image: ' . $e->getMessage());
        }
    }

    /**
     * Clear all uploaded images
     */
    public function clearAll()
    {
        try {
            $files = CloudinaryFile::where('resource_type', 'image')
                ->get();

            foreach ($files as $file) {
                $this->deleteAndRemove($file);
            }

            $this->uploadedPhotos = [];
            session()->flash('message', 'All images cleared successfully!');
        } catch (\Exception $e) {
            Log::error('Clear all error', [
                'message' => $e->getMessage()
            ]);
            session()->flash('error', 'Failed to clear images: ' . $e->getMessage());
        }
    }

    /**
     * Get thumbnail URL
     */
    public function getThumbnail($publicId)
    {
        return $this->getCloudinaryTransformedUrl($publicId, [
            'width' => 150,
            'height' => 150,
            'crop' => 'fill',
            'quality' => 'auto',
        ]);
    }

    public function render()
    {
        return view('livewire.image-uploader');
    }
}
