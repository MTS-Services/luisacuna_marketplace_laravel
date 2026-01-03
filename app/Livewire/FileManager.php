<?php

namespace App\Livewire;

use App\Models\CloudinaryFile;
use App\Traits\HasCloudinaryUploads;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Livewire\Attributes\On;

class FileManager extends Component
{
    use WithFileUploads, WithPagination, HasCloudinaryUploads;

    // Upload properties
    public $file;
    public $multipleFiles = [];
    public $uploadType = 'auto';
    public $isUploading = false;
    public $uploadProgress = 0;

    // Filter properties
    public $filterType = 'all';
    public $searchTerm = '';
    public $sortBy = 'created_at';
    public $sortDirection = 'desc';

    // View mode
    public $viewMode = 'grid'; // grid or list

    // Modal properties
    public $showUploadModal = false;
    public $showDetailsModal = false;
    public $showEditModal = false;
    public $selectedFile = null;

    // Edit properties
    public $editDescription = '';
    public $editTags = '';

    // Bulk actions
    public $selectedFiles = [];
    public $selectAll = false;

    // Files
    public $uploadedFiles = [];

    protected $rules = [
        'file' => 'nullable|file|max:102400', // 100MB
        'multipleFiles.*' => 'file|max:102400',
    ];

    public function mount()
    {
        $this->loadFiles();
    }

    public function updatedSearchTerm()
    {
        $this->loadFiles();
    }

    public function updatedFilterType()
    {
        $this->loadFiles();
    }

    public function updatedSortBy()
    {
        $this->loadFiles();
    }

    public function updatedSelectAll($value)
    {
        if ($value) {
            $this->selectedFiles = collect($this->uploadedFiles)->pluck('id')->toArray();
        } else {
            $this->selectedFiles = [];
        }
    }

    /**
     * Upload single file
     */
    public function uploadFile()
    {
        $this->validate();

        if (!$this->file) {
            session()->flash('error', 'Please select a file to upload.');
            return;
        }

        $this->isUploading = true;
        $this->uploadProgress = 0;

        try {
            $options = [
                'tags' => ['user-upload'],
                'description' => 'Uploaded via File Manager',
            ];

            // Set specific folder based on type
            if ($this->uploadType !== 'auto') {
                $options['folder'] = "uploads/{$this->uploadType}s";
            } else {
                $options['folder'] = "uploads/files";
            }

            // Simulate progress
            $this->uploadProgress = 30;

            $file = $this->uploadAndSave(
                file: $this->file,
                modelClass: CloudinaryFile::class,
                additionalData: [
                    'user_id' => auth()->id(),
                ],
                uploadOptions: [
                    'folder' => $options['folder'],
                ]
            );


            $this->uploadProgress = 100;

            if ($file) {
                session()->flash('message', 'File uploaded successfully!');
                $this->reset(['file', 'uploadType']);
                $this->uploadType = 'auto';
                $this->loadFiles();
            } else {
                session()->flash('error', 'Upload failed. Please try again.');
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Upload failed: ' . $e->getMessage());
        } finally {
            $this->isUploading = false;
            $this->uploadProgress = 0;
        }
    }

    /**
     * Upload multiple files
     */
    public function uploadMultipleFiles()
    {
        $this->validate([
            'multipleFiles.*' => 'required|file|max:102400',
        ]);

        $this->isUploading = true;

        try {
            $result = $this->cloudinaryService->uploadMultiple($this->multipleFiles, [
                'folder' => 'uploads/batch',
                'tags' => ['batch-upload'],
            ]);

            if ($result['success_count'] > 0) {
                session()->flash('message', "{$result['success_count']} files uploaded successfully!");
                $this->loadFiles();
            }

            if ($result['failed_count'] > 0) {
                session()->flash('error', "{$result['failed_count']} files failed to upload.");
            }

            $this->reset('multipleFiles');
            $this->showUploadModal = false;
        } catch (\Exception $e) {
            session()->flash('error', 'Upload failed: ' . $e->getMessage());
        } finally {
            $this->isUploading = false;
        }
    }

    /**
     * Delete single file
     */
    public function deleteFile($fileId)
    {
        try {
            $file = CloudinaryFile::find($fileId);

            if (!$file) {
                session()->flash('error', 'File not found.');
                return;
            }

            $deleted = $this->deleteAndRemove($file);

            if ($deleted) {
                session()->flash('message', 'File deleted successfully!');
                $this->loadFiles();
            } else {
                session()->flash('error', 'Failed to delete file.');
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Delete failed: ' . $e->getMessage());
        }
    }

    /**
     * Bulk delete files
     */
    public function bulkDelete()
    {
        if (empty($this->selectedFiles)) {
            session()->flash('error', 'No files selected.');
            return;
        }

        try {
            $files = CloudinaryFile::whereIn('id', $this->selectedFiles)->get();
            $result = $this->cloudinaryService->deleteMultiple($files->toArray());

            if ($result['success_count'] > 0) {
                session()->flash('message', "{$result['success_count']} files deleted successfully!");
                $this->loadFiles();
                $this->selectedFiles = [];
                $this->selectAll = false;
            }

            if ($result['failed_count'] > 0) {
                session()->flash('error', "{$result['failed_count']} files failed to delete.");
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Bulk delete failed: ' . $e->getMessage());
        }
    }

    /**
     * Show file details
     */
    public function showDetails($fileId)
    {
        $file = CloudinaryFile::find($fileId);

        if ($file) {
            $this->selectedFile = $file->toArray();
            $this->showDetailsModal = true;
        }
    }

    /**
     * Open edit modal
     */
    public function openEditModal($fileId)
    {
        $file = CloudinaryFile::find($fileId);

        if ($file) {
            $this->selectedFile = $file->toArray();
            $this->editDescription = $file->description ?? '';
            $this->editTags = is_array($file->tags) ? implode(', ', $file->tags) : '';
            $this->showEditModal = true;
        }
    }

    /**
     * Update file metadata
     */
    public function updateFileMetadata()
    {
        if (!$this->selectedFile) {
            return;
        }

        try {
            $file = CloudinaryFile::find($this->selectedFile['id']);

            if (!$file) {
                session()->flash('error', 'File not found.');
                return;
            }

            $tags = array_map('trim', explode(',', $this->editTags));
            $tags = array_filter($tags);

            $updated = $this->cloudinaryService->updateMetadata($file, [
                'description' => $this->editDescription,
                'tags' => $tags,
            ]);

            if ($updated) {
                session()->flash('message', 'File metadata updated successfully!');
                $this->loadFiles();
                $this->closeEditModal();
            } else {
                session()->flash('error', 'Failed to update metadata.');
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Update failed: ' . $e->getMessage());
        }
    }

    /**
     * Download file
     */
    public function downloadFile($fileId)
    {
        $file = CloudinaryFile::find($fileId);

        if ($file) {
            return redirect($file->url);
        }
    }

    /**
     * Copy URL to clipboard (handled by JavaScript)
     */
    #[On('url-copied')]
    public function urlCopied()
    {
        session()->flash('message', 'URL copied to clipboard!');
    }

    /**
     * Toggle sort direction
     */
    public function toggleSort($field)
    {
        if ($this->sortBy === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $field;
            $this->sortDirection = 'desc';
        }

        $this->loadFiles();
    }

    /**
     * Close modals
     */
    public function closeUploadModal()
    {
        $this->showUploadModal = false;
        $this->reset(['multipleFiles']);
    }

    public function closeDetailsModal()
    {
        $this->showDetailsModal = false;
        $this->selectedFile = null;
    }

    public function closeEditModal()
    {
        $this->showEditModal = false;
        $this->selectedFile = null;
        $this->reset(['editDescription', 'editTags']);
    }

    /**
     * Load files from database
     */
    protected function loadFiles()
    {
        $query = CloudinaryFile::where('user_id', auth()->id());

        // Apply filters
        if ($this->filterType !== 'all') {
            $query->where('resource_type', $this->filterType);
        }

        // Apply search
        if (!empty($this->searchTerm)) {
            $query->where(function ($q) {
                $q->where('original_filename', 'like', '%' . $this->searchTerm . '%')
                    ->orWhere('description', 'like', '%' . $this->searchTerm . '%')
                    ->orWhere('public_id', 'like', '%' . $this->searchTerm . '%');
            });
        }

        // Apply sorting
        $query->orderBy($this->sortBy, $this->sortDirection);

        $this->uploadedFiles = $query->get()->map(function ($file) {
            return [
                'id' => $file->id,
                'public_id' => $file->public_id,
                'url' => $file->url,
                'resource_type' => $file->resource_type,
                'format' => $file->format,
                'size' => $file->size,
                'width' => $file->width,
                'height' => $file->height,
                'original_filename' => $file->original_filename,
                'description' => $file->description,
                'tags' => $file->tags,
                'formatted_size' => $file->formatted_size,
                'thumbnail_url' => $file->thumbnail_url,
                'created_at' => $file->created_at->format('M d, Y'),
            ];
        })->toArray();
    }

    /**
     * Get statistics
     */
    public function getStatsProperty()
    {
        $userId = auth()->id();

        return [
            'total' => CloudinaryFile::where('user_id', $userId)->count(),
            'images' => CloudinaryFile::where('user_id', $userId)->where('resource_type', 'image')->count(),
            'videos' => CloudinaryFile::where('user_id', $userId)->where('resource_type', 'video')->count(),
            'documents' => CloudinaryFile::where('user_id', $userId)->where('resource_type', 'raw')->count(),
            'total_size' => CloudinaryFile::where('user_id', $userId)->sum('size'),
        ];
    }

    /**
     * Format bytes to human readable
     */
    public function formatBytes($bytes)
    {
        $units = ['B', 'KB', 'MB', 'GB'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        $bytes /= pow(1024, $pow);

        return round($bytes, 2) . ' ' . $units[$pow];
    }

    public function render()
    {
        return view('livewire.file-manager', [
            'stats' => $this->stats,
        ]);
    }
}
