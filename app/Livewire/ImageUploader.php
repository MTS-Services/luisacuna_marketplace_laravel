<?php

namespace App\Livewire;

use App\Models\CloudinaryImage;
use App\Services\CloudinaryService;
use Livewire\Component;
use Livewire\WithFileUploads;

class ImageUploader extends Component
{
    use WithFileUploads;

    public $image;
    public $uploadedImageUrl;
    public $publicId;
    public $isUploading = false;

    protected $rules = [
        'image' => 'required|image|max:10240', 
    ];

    public function updatedImage()
    {
        $this->validate();
    }

    public function uploadImage()
    {
        $this->validate();
        $this->isUploading = true;

        try {
            $cloudinaryService = app(CloudinaryService::class);

            $result = $cloudinaryService->upload($this->image->getRealPath());

            $this->uploadedImageUrl = $result['secure_url'];
            $this->publicId = $result['public_id'];

            CloudinaryImage::create([
                'url' => $this->uploadedImageUrl,
                'public_id' => $this->publicId
            ]);

            session()->flash('message', 'Image uploaded successfully!');
            $this->reset('image');
        } catch (\Exception $e) {
            session()->flash('error', 'Upload failed: ' . $e->getMessage());
        } finally {
            $this->isUploading = false;
        }
    }

    public function deleteImage()
    {
        if ($this->publicId) {
            try {
                $cloudinaryService = app(CloudinaryService::class);
                $cloudinaryService->destroy($this->publicId);

                // Delete from database
                CloudinaryImage::where('public_id', $this->publicId)->delete();

                $this->reset(['uploadedImageUrl', 'publicId']);
                session()->flash('message', 'Image deleted successfully!');
            } catch (\Exception $e) {
                session()->flash('error', 'Delete failed: ' . $e->getMessage());
            }
        }
    }

    public function render()
    {
        return view('livewire.image-uploader');
    }
}
