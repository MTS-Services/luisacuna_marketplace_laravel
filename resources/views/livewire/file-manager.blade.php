<div class="max-w-7xl mx-auto p-6">
    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900">File Manager</h1>
        <p class="text-gray-600 mt-2">Upload and manage your files with Cloudinary</p>
    </div>

    <!-- Flash Messages -->
    @if (session()->has('message'))
        <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6 rounded">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                        clip-rule="evenodd" />
                </svg>
                <span class="text-green-800">{{ session('message') }}</span>
            </div>
        </div>
    @endif

    @if (session()->has('error'))
        <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-red-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                        clip-rule="evenodd" />
                </svg>
                <span class="text-red-800">{{ session('error') }}</span>
            </div>
        </div>
    @endif

    <!-- Upload Section -->
    <div class="bg-white rounded-lg shadow-lg p-6 mb-8">
        <h2 class="text-xl font-semibold mb-4">Upload New File</h2>

        <form wire:submit.prevent="uploadFile">
            <!-- Upload Type Selector -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Upload Type
                </label>
                <div class="flex flex-wrap gap-2">
                    <button type="button" wire:click="$set('uploadType', 'auto')"
                        class="px-4 py-2 rounded-lg {{ $uploadType === 'auto' ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700' }}">
                        Auto Detect
                    </button>
                    <button type="button" wire:click="$set('uploadType', 'image')"
                        class="px-4 py-2 rounded-lg {{ $uploadType === 'image' ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700' }}">
                        📷 Image
                    </button>
                    <button type="button" wire:click="$set('uploadType', 'video')"
                        class="px-4 py-2 rounded-lg {{ $uploadType === 'video' ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700' }}">
                        🎥 Video
                    </button>
                    <button type="button" wire:click="$set('uploadType', 'document')"
                        class="px-4 py-2 rounded-lg {{ $uploadType === 'document' ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700' }}">
                        📄 Document
                    </button>
                    <button type="button" wire:click="$set('uploadType', 'audio')"
                        class="px-4 py-2 rounded-lg {{ $uploadType === 'audio' ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700' }}">
                        🎵 Audio
                    </button>
                </div>
            </div>

            <!-- File Input -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Select File
                </label>
                <div class="flex items-center justify-center w-full">
                    <label
                        class="flex flex-col w-full h-32 border-4 border-dashed border-gray-300 rounded-lg hover:border-blue-500 hover:bg-gray-50 cursor-pointer transition">
                        <div class="flex flex-col items-center justify-center pt-7">
                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                            </svg>
                            <p class="pt-1 text-sm text-gray-500">Click to upload or drag and drop</p>
                            <p class="text-xs text-gray-400">Max size: 100MB</p>
                        </div>
                        <input type="file" wire:model="file" class="hidden" />
                    </label>
                </div>
                @error('file')
                    <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- File Preview -->
            @if ($file)
                <div class="mb-4 p-4 bg-gray-50 rounded-lg">
                    <h3 class="text-sm font-medium text-gray-700 mb-2">Selected File:</h3>
                    <div class="flex items-center space-x-4">
                        @if (str_starts_with($file->getMimeType(), 'image/'))
                            <img src="{{ $file->temporaryUrl() }}" class="w-20 h-20 object-cover rounded">
                        @endif
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-900">{{ $file->getClientOriginalName() }}</p>
                            <p class="text-xs text-gray-500">{{ number_format($file->getSize() / 1024, 2) }} KB</p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Upload Progress -->
            @if ($isUploading)
                <div class="mb-4">
                    <div class="w-full bg-gray-200 rounded-full h-2.5">
                        <div class="bg-blue-600 h-2.5 rounded-full transition-all duration-300"
                            style="width: {{ $uploadProgress }}%"></div>
                    </div>
                    <p class="text-sm text-gray-600 mt-2">Uploading... {{ $uploadProgress }}%</p>
                </div>
            @endif

            <!-- Submit Button -->
            <button type="submit"
                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg disabled:opacity-50 disabled:cursor-not-allowed transition"
                wire:loading.attr="disabled" wire:target="file,uploadFile">
                <span wire:loading.remove wire:target="uploadFile">
                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                    </svg>
                    Upload File
                </span>
                <span wire:loading wire:target="uploadFile">
                    <svg class="animate-spin h-5 w-5 inline mr-2" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                            stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor"
                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                        </path>
                    </svg>
                    Uploading...
                </span>
            </button>
        </form>
    </div>

    <!-- Files List Section -->
    <div class="bg-white rounded-lg shadow-lg p-6">
        <!-- Filter Tabs -->
        <div class="flex items-center justify-between mb-6">
            <div class="flex space-x-2">
                <button wire:click="$set('filterType', 'all')"
                    class="px-4 py-2 rounded-lg {{ $filterType === 'all' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700' }}">
                    All Files ({{ count($uploadedFiles) }})
                </button>
                <button wire:click="$set('filterType', 'image')"
                    class="px-4 py-2 rounded-lg {{ $filterType === 'image' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700' }}">
                    📷 Images
                </button>
                <button wire:click="$set('filterType', 'video')"
                    class="px-4 py-2 rounded-lg {{ $filterType === 'video' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700' }}">
                    🎥 Videos
                </button>
                <button wire:click="$set('filterType', 'raw')"
                    class="px-4 py-2 rounded-lg {{ $filterType === 'raw' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700' }}">
                    📄 Documents
                </button>
            </div>
        </div>

        <!-- Files Grid -->
        @if (count($uploadedFiles) > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach ($uploadedFiles as $uploadedFile)
                    <div class="bg-white border border-gray-200 rounded-lg overflow-hidden hover:shadow-lg transition">
                        <!-- File Preview -->
                        <div class="aspect-square bg-gray-100 flex items-center justify-center overflow-hidden">
                            @if ($uploadedFile['resource_type'] === 'image')
                                <img src="{{ $uploadedFile['public_id'] }}" 
                                    alt="attachment" class="rounded" />

                                
                            @elseif ($uploadedFile['resource_type'] === 'video')
                                <img src="{{ storage_url('cld-sample-5') }}" 
                                    alt="Uploaded File" class="rounded" />
                                <x-cloudinary::video public-id="{{ $uploadedFile['public_id'] }}" width="250"
                                    height="300" alt="Uploaded File" class="rounded" controls />
                            @else
                                <div class="text-center p-4">
                                    <div class="text-6xl mb-2">📄</div>
                                    <p class="text-sm text-gray-600 uppercase">{{ $uploadedFile['format'] ?? 'File' }}
                                    </p>
                                </div>
                            @endif
                        </div>

                        <!-- File Info -->
                        <div class="p-4">
                            <div class="mb-3">
                                <p class="text-sm font-medium text-gray-900 truncate">
                                    {{ basename($uploadedFile['public_id']) }}
                                </p>
                                <p class="text-xs text-gray-500 mt-1">
                                    {{ number_format(($uploadedFile['size'] ?? 0) / 1024, 2) }} KB
                                </p>
                                @if (isset($uploadedFile['width']) && isset($uploadedFile['height']))
                                    <p class="text-xs text-gray-500">
                                        {{ $uploadedFile['width'] }} × {{ $uploadedFile['height'] }}
                                    </p>
                                @endif
                            </div>

                            <!-- Actions -->
                            <div class="flex space-x-2">
                                <a href="{{ $uploadedFile['url'] }}" target="_blank"
                                    class="flex-1 bg-blue-50 hover:bg-blue-100 text-blue-600 text-center py-2 px-3 rounded text-sm font-medium transition">
                                    View
                                </a>
                                <button wire:click="deleteFile({{ $uploadedFile['id'] }})"
                                    onclick="return confirm('Are you sure you want to delete this file?')"
                                    class="flex-1 bg-red-50 hover:bg-red-100 text-red-600 text-center py-2 px-3 rounded text-sm font-medium transition">
                                    Delete
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-12">
                <svg class="w-24 h-24 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                </svg>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No files uploaded yet</h3>
                <p class="text-gray-500">Upload your first file to get started</p>
            </div>
        @endif
    </div>
</div>
