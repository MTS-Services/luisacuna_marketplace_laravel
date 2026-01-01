<div class="max-w-4xl mx-auto p-6">
    <div class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-2xl font-bold mb-4 text-gray-800">Upload Images to Cloudinary</h2>

        {{-- Success Message --}}
        @if (session()->has('message'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 px-4 py-3 rounded mb-4" role="alert">
                <p class="font-medium">{{ session('message') }}</p>
            </div>
        @endif

        {{-- Error Message --}}
        @if (session()->has('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 px-4 py-3 rounded mb-4" role="alert">
                <p class="font-medium">{{ session('error') }}</p>
            </div>
        @endif

        {{-- Upload Form --}}
        <div class="mb-6">
            <label class="block text-gray-700 text-sm font-bold mb-2">
                Select Image
            </label>
            <input type="file" wire:model="photo" accept="image/*"
                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">

            @error('photo')
                <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
            @enderror

            {{-- Loading Indicator --}}
            <div wire:loading wire:target="photo" class="text-blue-500 text-sm mt-2 flex items-center">
                <svg class="animate-spin h-4 w-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                        stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor"
                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                    </path>
                </svg>
                Loading preview...
            </div>
        </div>

        {{-- Image Preview --}}
        @if ($photo)
            <div class="mb-6 bg-gray-50 p-4 rounded-lg">
                <p class="text-sm text-gray-600 mb-2 font-medium">Preview:</p>
                <img src="{{ $photo->temporaryUrl() }}" class="max-w-xs rounded-lg shadow-md border-2 border-gray-200"
                    alt="Preview">

                <button wire:click="uploadImage" wire:loading.attr="disabled" wire:target="uploadImage"
                    class="mt-4 bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg transition duration-200 disabled:opacity-50 disabled:cursor-not-allowed flex items-center">
                    <span wire:loading.remove wire:target="uploadImage">
                        <svg class="w-5 h-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12">
                            </path>
                        </svg>
                        Upload Image
                    </span>
                    <span wire:loading wire:target="uploadImage" class="flex items-center">
                        <svg class="animate-spin h-5 w-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>
                        Uploading...
                    </span>
                </button>
            </div>
        @endif

        {{-- Uploaded Images Gallery --}}
        @if (count($uploadedPhotos) > 0)
            <div class="mt-8">
                <h3 class="text-xl font-bold mb-4 text-gray-800">Uploaded Images</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($uploadedPhotos as $index => $photo)
                        <div
                            class="relative group bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-shadow duration-300">
                            <img src="{{ $photo['url'] }}" alt="{{ $photo['name'] }}" class="w-full h-48 object-cover">
                            <div class="p-3">
                                <p class="text-sm text-gray-600 truncate" title="{{ $photo['name'] }}">
                                    {{ $photo['name'] }}
                                </p>
                            </div>
                            <button wire:click="deleteImage({{ $index }})"
                                class="absolute top-2 right-2 bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity duration-200 shadow-lg flex items-center text-sm">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                    </path>
                                </svg>
                                Delete
                            </button>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>
