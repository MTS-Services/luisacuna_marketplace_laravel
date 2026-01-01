<?php

namespace App\Livewire;

use App\Models\CloudinaryFile;
use App\Services\CloudinaryService;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;

class FileUploader extends Component
{
    use WithFileUploads;

    public $file;
    public $uploadedFiles = [];
    public $uploadType = 'auto'; // auto, image, video, document, audio
    public $isUploading = false;
    public $uploadProgress = 0;

    // Filters
    public $filterType = 'all'; // all, image, video, document

    protected $rules = [
        'file' => 'required|file|max:102400', // 100MB Max
    ];

    protected $messages = [
        'file.required' => 'Please select a file to upload.',
        'file.max' => 'File size must not exceed 100MB.',
    ];

    public function mount()
    {
        $this->loadUploadedFiles();
    }

    public function updatedFile()
    {
        $this->validate();
    }

    public function uploadFile()
    {
        $this->validate();

        $this->isUploading = true;
        $this->uploadProgress = 0;

        try {
            $cloudinaryService = app(CloudinaryService::class);

            // Validate file
            $validation = $cloudinaryService->validateFile($this->file, [
                'max_size' => 100 * 1024 * 1024, // 100MB
            ]);

            if (!$validation['valid']) {
                session()->flash('error', implode(', ', $validation['errors']));
                $this->isUploading = false;
                return;
            }

            // Upload based on type
            $result = match ($this->uploadType) {
                'image' => $cloudinaryService->uploadImage($this->file),
                'video' => $cloudinaryService->uploadVideo($this->file),
                'document' => $cloudinaryService->uploadDocument($this->file),
                'audio' => $cloudinaryService->uploadAudio($this->file),
                default => $cloudinaryService->upload($this->file),
            };

            // Save to database
            CloudinaryFile::create([
                'user_id' => Auth::id(),
                'public_id' => $result['public_id'],
                'url' => $result['url'],
                'resource_type' => $result['resource_type'],
                'format' => $result['format'],
                'size' => $result['size'],
                'width' => $result['width'],
                'height' => $result['height'],
                'duration' => $result['duration'],
                'folder' => dirname($result['public_id']),
            ]);

            session()->flash('message', 'File uploaded successfully!');

            $this->reset(['file', 'uploadProgress']);
            $this->loadUploadedFiles();
        } catch (\Exception $e) {
            session()->flash('error', 'Upload failed: ' . $e->getMessage());
        } finally {
            $this->isUploading = false;
        }
    }

    public function deleteFile($id)
    {
        try {
            $file = CloudinaryFile::findOrFail($id);

            // Check ownership
            if ($file->user_id !== Auth::id()) {
                session()->flash('error', 'Unauthorized action.');
                return;
            }

            $cloudinaryService = app(CloudinaryService::class);

            // Delete from Cloudinary
            $cloudinaryService->destroy($file->public_id, $file->resource_type);

            // Delete from database
            $file->delete();

            session()->flash('message', 'File deleted successfully!');
            $this->loadUploadedFiles();
        } catch (\Exception $e) {
            session()->flash('error', 'Delete failed: ' . $e->getMessage());
        }
    }

    public function deleteMultiple($ids)
    {
        try {
            $files = CloudinaryFile::whereIn('id', $ids)
                ->where('user_id', Auth::id())
                ->get();

            if ($files->isEmpty()) {
                session()->flash('error', 'No files found to delete.');
                return;
            }

            $cloudinaryService = app(CloudinaryService::class);

            // Group by resource type
            $grouped = $files->groupBy('resource_type');

            foreach ($grouped as $resourceType => $fileGroup) {
                $publicIds = $fileGroup->pluck('public_id')->toArray();
                $cloudinaryService->destroyMultiple($publicIds, $resourceType);
            }

            // Delete from database
            CloudinaryFile::whereIn('id', $ids)->delete();

            session()->flash('message', count($ids) . ' files deleted successfully!');
            $this->loadUploadedFiles();
        } catch (\Exception $e) {
            session()->flash('error', 'Batch delete failed: ' . $e->getMessage());
        }
    }

    public function loadUploadedFiles()
    {
        $query = CloudinaryFile::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc');

        if ($this->filterType !== 'all') {
            $query->where('resource_type', $this->filterType);
        }

        $this->uploadedFiles = $query->get()->toArray();
    }

    public function updatedFilterType()
    {
        $this->loadUploadedFiles();
    }

    public function render()
    {
        return view('livewire.file-uploader');
    }
}
