<div class="max-w-2xl mx-auto p-6">
    <div class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-2xl font-bold mb-4">Upload Image to Cloudinary</h2>

        @if (session()->has('message'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('message') }}
            </div>
        @endif

        @if (session()->has('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        <form wire:submit.prevent="uploadImage">
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">
                    Select Image
                </label>
                <input type="file" wire:model="image" class="w-full px-3 py-2 border rounded" accept="image/*">
                @error('image')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            @if ($image)
                <div class="mb-4">
                    <p class="text-sm text-gray-600 mb-2">Preview:</p>
                    <img src="{{ $image->temporaryUrl() }}" class="max-w-xs rounded">
                </div>
            @endif
 
            <button type="submit"
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded disabled:opacity-50"
                wire:loading.attr="disabled" wire:target="image,uploadImage">
                <span wire:loading.remove wire:target="uploadImage">Upload Image</span>
                <span wire:loading wire:target="uploadImage">Uploading...</span>
            </button>
        </form>

        @if ($uploadedImageUrl)
            <div class="mt-6 border-t pt-6">
                <h3 class="text-xl font-bold mb-3">Uploaded Image</h3>
                <img src="{{ $uploadedImageUrl }}" class="max-w-md rounded mb-3">
                <p class="text-sm text-gray-600 mb-2">URL: {{ $uploadedImageUrl }}</p>
                <p class="text-sm text-gray-600 mb-3">Public ID: {{ $publicId }}</p>
                <button wire:click="deleteImage"
                    class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                    Delete Image
                </button>
            </div>
        @endif
    </div>
    {{-- <x-cloudinary::widget>Upload Files</x-cloudinary::widget> --}}
</div>
