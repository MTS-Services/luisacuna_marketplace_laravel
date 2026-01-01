<div class="max-w-7xl mx-auto p-6" x-data="{ showUploadModal: @entangle('showUploadModal'), showDetailsModal: @entangle('showDetailsModal'), showEditModal: @entangle('showEditModal') }">
    
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">File Manager</h1>
                <p class="text-gray-600 mt-2">Upload and manage your files with Cloudinary</p>
            </div>
            <button @click="showUploadModal = true" 
                    class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg shadow-lg transition flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Upload Files
            </button>
        </div>
    </div>

    <!-- Flash Messages -->
    @if (session()->has('message'))
        <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6 rounded-lg shadow" x-data="{ show: true }" x-show="show">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <span class="text-green-800 font-medium">{{ session('message') }}</span>
                </div>
                <button @click="show = false" class="text-green-500 hover:text-green-700">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                    </svg>
                </button>
            </div>
        </div>
    @endif

    @if (session()->has('error'))
        <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-lg shadow" x-data="{ show: true }" x-show="show">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-red-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                    </svg>
                    <span class="text-red-800 font-medium">{{ session('error') }}</span>
                </div>
                <button @click="show = false" class="text-red-500 hover:text-red-700">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                    </svg>
                </button>
            </div>
        </div>
    @endif

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm font-medium">Total Files</p>
                    <p class="text-3xl font-bold mt-2">{{ $stats['total'] }}</p>
                </div>
                <div class="bg-blue-400 bg-opacity-50 rounded-full p-3">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-100 text-sm font-medium">Images</p>
                    <p class="text-3xl font-bold mt-2">{{ $stats['images'] }}</p>
                </div>
                <div class="bg-green-400 bg-opacity-50 rounded-full p-3">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-purple-100 text-sm font-medium">Videos</p>
                    <p class="text-3xl font-bold mt-2">{{ $stats['videos'] }}</p>
                </div>
                <div class="bg-purple-400 bg-opacity-50 rounded-full p-3">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-orange-100 text-sm font-medium">Storage Used</p>
                    <p class="text-3xl font-bold mt-2">{{ $this->formatBytes($stats['total_size']) }}</p>
                </div>
                <div class="bg-orange-400 bg-opacity-50 rounded-full p-3">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Upload Section -->
    <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
        <h2 class="text-xl font-semibold mb-4 text-gray-800">Quick Upload</h2>
        
        <form wire:submit.prevent="uploadFile">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
                <!-- Upload Type Selector -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Upload Type</label>
                    <select wire:model="uploadType" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="auto">Auto Detect</option>
                        <option value="image">📷 Image</option>
                        <option value="video">🎥 Video</option>
                        <option value="document">📄 Document</option>
                        <option value="audio">🎵 Audio</option>
                    </select>
                </div>

                <!-- File Input -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Select File</label>
                    <input type="file" wire:model="file" 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    @error('file') 
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Upload Button -->
                <div class="flex items-end">
                    <button type="submit" 
                            class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded-lg disabled:opacity-50 disabled:cursor-not-allowed transition flex items-center justify-center"
                            wire:loading.attr="disabled"
                            wire:target="file,uploadFile">
                        <span wire:loading.remove wire:target="uploadFile">
                            <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                            </svg>
                            Upload
                        </span>
                        <span wire:loading wire:target="uploadFile">
                            <svg class="animate-spin h-5 w-5 inline mr-2" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Uploading...
                        </span>
                    </button>
                </div>
            </div>

            <!-- Upload Progress -->
            @if ($isUploading && $uploadProgress > 0)
                <div class="mt-4">
                    <div class="w-full bg-gray-200 rounded-full h-3">
                        <div class="bg-blue-600 h-3 rounded-full transition-all duration-300 flex items-center justify-end pr-2" 
                             style="width: {{ $uploadProgress }}%">
                            <span class="text-xs text-white font-medium">{{ $uploadProgress }}%</span>
                        </div>
                    </div>
                </div>
            @endif
        </form>
    </div>

    <!-- Filters and Search -->
    <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
            <!-- Search -->
            <div class="flex-1 max-w-md">
                <div class="relative">
                    <input type="text" 
                           wire:model.live.debounce.300ms="searchTerm" 
                           placeholder="Search files..." 
                           class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <svg class="absolute left-3 top-2.5 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
            </div>

            <!-- Filter Tabs -->
            <div class="flex flex-wrap gap-2">
                <button wire:click="$set('filterType', 'all')"
                        class="px-4 py-2 rounded-lg font-medium transition {{ $filterType === 'all' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                    All ({{ $stats['total'] }})
                </button>
                <button wire:click="$set('filterType', 'image')"
                        class="px-4 py-2 rounded-lg font-medium transition {{ $filterType === 'image' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                    📷 Images ({{ $stats['images'] }})
                </button>
                <button wire:click="$set('filterType', 'video')"
                        class="px-4 py-2 rounded-lg font-medium transition {{ $filterType === 'video' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                    🎥 Videos ({{ $stats['videos'] }})
                </button>
                <button wire:click="$set('filterType', 'raw')"
                        class="px-4 py-2 rounded-lg font-medium transition {{ $filterType === 'raw' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                    📄 Docs ({{ $stats['documents'] }})
                </button>
            </div>

            <!-- View Mode Toggle -->
            <div class="flex items-center gap-2">
                <button wire:click="$set('viewMode', 'grid')" 
                        class="p-2 rounded-lg {{ $viewMode === 'grid' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                    </svg>
                </button>
                <button wire:click="$set('viewMode', 'list')" 
                        class="p-2 rounded-lg {{ $viewMode === 'list' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Bulk Actions -->
        @if (count($selectedFiles) > 0)
            <div class="mt-4 p-4 bg-blue-50 border border-blue-200 rounded-lg flex items-center justify-between">
                <span class="text-blue-700 font-medium">{{ count($selectedFiles) }} file(s) selected</span>
                <div class="flex gap-2">
                    <button wire:click="bulkDelete" 
                            onclick="return confirm('Are you sure you want to delete {{ count($selectedFiles) }} file(s)?')"
                            class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg font-medium transition">
                        Delete Selected
                    </button>
                    <button wire:click="$set('selectedFiles', [])" 
                            class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-lg font-medium transition">
                        Clear Selection
                    </button>
                </div>
            </div>
        @endif
    </div>

    <!-- Files List -->
    <div class="bg-white rounded-xl shadow-lg p-6">
        @if (count($uploadedFiles) > 0)
            
            @if ($viewMode === 'grid')
                <!-- Grid View -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @foreach ($uploadedFiles as $uploadedFile)
                        <div class="bg-white border-2 border-gray-200 rounded-xl overflow-hidden hover:shadow-xl hover:border-blue-400 transition-all duration-300 group">
                            <!-- Checkbox for selection -->
                            <div class="absolute top-3 left-3 z-10">
                                <input type="checkbox" 
                                       wire:model.live="selectedFiles" 
                                       value="{{ $uploadedFile['id'] }}"
                                       class="w-5 h-5 text-blue-600 rounded focus:ring-2 focus:ring-blue-500">
                            </div>

                            <!-- File Preview -->
                            <div class="aspect-square bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center overflow-hidden relative">
                                @if ($uploadedFile['resource_type'] === 'image')
                                    <img src="{{ $uploadedFile['thumbnail_url'] }}" 
                                         alt="{{ $uploadedFile['original_filename'] }}" 
                                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                                @elseif ($uploadedFile['resource_type'] === 'video')
                                    <div class="relative w-full h-full">
                                        <video class="w-full h-full object-cover">
                                            <source src="{{ $uploadedFile['url'] }}" type="video/{{ $uploadedFile['format'] }}">
                                        </video>
                                        <div class="absolute inset-0 flex items-center justify-center bg-black bg-opacity-30">
                                            <svg class="w-16 h-16 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M6.3 2.841A1.5 1.5 0 004 4.11V15.89a1.5 1.5 0 002.3 1.269l9.344-5.89a1.5 1.5 0 000-2.538L6.3 2.84z"/>
                                            </svg>
                                        </div>
                                    </div>
                                @else
                                    <div class="text-center p-6">
                                        <div class="text-6xl mb-3">📄</div>
                                        <p class="text-sm font-medium text-gray-700 uppercase tracking-wider">{{ $uploadedFile['format'] ?? 'File' }}</p>
                                    </div>
                                @endif

                                <!-- Quick Actions Overlay -->
                                <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-40 transition-all duration-300 flex items-center justify-center opacity-0 group-hover:opacity-100">
                                    <div class="flex gap-2">
                                        <button wire:click="showDetails({{ $uploadedFile['id'] }})"
                                                class="bg-white hover:bg-gray-100 text-gray-800 p-2 rounded-lg transition">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                        </button>
                                        <a href="{{ $uploadedFile['url'] }}" 
                                           target="_blank"
                                           class="bg-white hover:bg-gray-100 text-gray-800 p-2 rounded-lg transition">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <!-- File Info -->
                            <div class="p-4">
                                <div class="mb-3">
                                    <p class="text-sm font-semibold text-gray-900 truncate" title="{{ $uploadedFile['original_filename'] }}">
                                        {{ $uploadedFile['original_filename'] }}
                                    </p>
                                    <div class="flex items-center justify-between mt-2">
                                        <p class="text-xs text-gray-500">{{ $uploadedFile['formatted_size'] }}</p>
                                        @if (isset($uploadedFile['width']) && isset($uploadedFile['height']))
                                            <p class="text-xs text-gray-500">{{ $uploadedFile['width'] }}×{{ $uploadedFile['height'] }}</p>
                                        @endif
                                    </div>
                                    <p class="text-xs text-gray-400 mt-1">{{ $uploadedFile['created_at'] }}</p>
                                </div>

                                <!-- Action Buttons -->
                                <div class="flex gap-2">
                                    <button wire:click="openEditModal({{ $uploadedFile['id'] }})"
                                            class="flex-1 bg-blue-50 hover:bg-blue-100 text-blue-600 text-center py-2 px-3 rounded-lg text-sm font-medium transition">
                                        Edit
                                    </button>
                                    <button wire:click="deleteFile({{ $uploadedFile['id'] }})"
                                            onclick="return confirm('Are you sure you want to delete this file?')"
                                            class="flex-1 bg-red-50 hover:bg-red-100 text-red-600 text-center py-2 px-3 rounded-lg text-sm font-medium transition">
                                        Delete
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <!-- List View -->
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b-2 border-gray-200">
                                <th class="px-4 py-3 text-left">
                                    <input type="checkbox" 
                                           wire:model.live="selectAll"
                                           class="w-5 h-5 text-blue-600 rounded">
                                </th>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Preview</th>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700 cursor-pointer hover:text-blue-600"
                                    wire:click="toggleSort('original_filename')">
                                    Name
                                    @if ($sortBy === 'original_filename')
                                        <span>{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>
                                    @endif
                                </th>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Type</th>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700 cursor-pointer hover:text-blue-600"
                                    wire:click="toggleSort('size')">
                                    Size
                                    @if ($sortBy === 'size')
                                        <span>{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>
                                    @endif
                                </th>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700 cursor-pointer hover:text-blue-600"
                                    wire:click="toggleSort('created_at')">
                                    Date
                                    @if ($sortBy === 'created_at')
                                        <span>{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>
                                    @endif
                                </th>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($uploadedFiles as $uploadedFile)
                                <tr class="border-b border-gray-100 hover:bg-gray-50 transition">
                                    <td class="px-4 py-3 text-left">
                                        <input type="checkbox" 
                                               wire:model.live="selectedFiles.{{ $uploadedFile['id'] }}"
                                               class="w-5 h-5 text-blue-600 rounded">
                                    </td>
                                    <td class="px-4 py-3 text-left">
                                        @if ($uploadedFile['resource_type'] === 'image')
                                            <img src="{{ $uploadedFile['thumbnail_url'] }}" 
                                                 alt="{{ $uploadedFile['original_filename'] }}" 
                                                 class="w-10 h-10 object-cover rounded">
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-left">
                                        <p class="text-sm text-gray-900 truncate" title="{{ $uploadedFile['original_filename'] }}">
                                            {{ $uploadedFile['original_filename'] }}
                                        </p>
                                    </td>
                                    <td class="px-4 py-3 text-left">
                                        <p class="text-xs text-gray-500">{{ $uploadedFile['format'] }}</p>
                                    </td>
                                    <td class="px-4 py-3 text-left">
                                        <p class="text-xs text-gray-500">{{ $uploadedFile['formatted_size'] }}</p>
                                    </td>
                                    <td class="px-4 py-3 text-left">
                                        <p class="text-xs text-gray-500">{{ $uploadedFile['created_at'] }}</p>
                                    </td>
                                    <td class="px-4 py-3 text-left">
                                        <div class="flex gap-2">
                                            <button wire:click="showDetails({{ $uploadedFile['id'] }})"
                                                    class="bg-blue-50 hover:bg-blue-100 text-blue-600 text-center py-2 px-3 rounded-lg text-sm font-medium transition">
                                                <i class="fas fa-info-circle"></i>  Details
                                            </button>                                            
                                            <button wire:click="download({{ $uploadedFile['id'] }})"
                                                    class="bg-blue-50 hover:bg-blue-100 text-blue-600 text-center py-2 px-3 rounded-lg text-sm font-medium transition">
                                                <i class="fas fa-download"></i>  Download
                                            </button>
                                            <button wire:click="openEditModal({{ $uploadedFile['id'] }})"
                                                    class="bg-blue-50 hover:bg-blue-100 text-blue-600 text-center py-2 px-3 rounded-lg text-sm font-medium transition">
                                                <i class="fas fa-edit"></i>  Edit
                                            </button>
                                            <button wire:click="deleteFile({{ $uploadedFile['id'] }})"
                                                    onclick="return confirm('Are you sure you want to delete this file?')"
                                                    class="bg-red-50 hover:bg-red-100 text-red-600 text-center py-2 px-3 rounded-lg text-sm font-medium transition">    
                                                <i class="fas fa-trash"></i>  Delete
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        @else
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="text-center">
                    <svg class="w-16 h-16 mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">    
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" stroke-miterlimit="10" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                    <p class="text-2xl font-semibold text-gray-700">No files found</p>
                </div>
            </div>
        @endif
    </div>

    @if ($showDetailsModal)
        <div class="fixed inset-0 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h2 class="text-lg font-semibold mb-4">File Details</h2>
                <p><strong>File ID:</strong> {{ $selectedFileId }}</p>
                <p><strong>File Name:</strong> {{ $selectedFileName }}</p>
                <p><strong>File Type:</strong> {{ $selectedFileType }}</p>
                <p><strong>File Size:</strong> {{ $selectedFileSize }}</p>
                <p><strong>File Date:</strong> {{ $selectedFileDate }}</p>
                <p><strong>File Path:</strong> {{ $selectedFilePath }}</p>
                <p><strong>File URL:</strong> <a href="{{ $selectedFileUrl }}" target="_blank">{{ $selectedFileUrl }}</a></p>
                <button wire:click="closeDetailsModal" class="mt-4 bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded">Close</button>
            </div>
        </div>
    @endif

    @if ($showEditModal)
        <div class="fixed inset-0 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h2 class="text-lg font-semibold mb-4">Edit File</h2>
                <form wire:submit.prevent="editFile">
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">New File Name</label>
                        <input type="text" 
                               wire:model="newFileName" 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                    <button type="submit" 
                            class="mt-4 bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded">Save</button>
                </form>
            </div>
        </div>
    @endif
</div>