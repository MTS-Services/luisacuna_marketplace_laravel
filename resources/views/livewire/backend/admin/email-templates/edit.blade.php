<div>

    {{-- If you look to others for fulfillment, you will never truly be fulfilled. --}}

<div class="max-w-3xl mx-auto bg-zinc-600 text-cyan-300 p-8 rounded-xl shadow-lg">
    <h2 class="text-2xl font-bold mb-6 text-gray-800">Edit Email Template</h2>

    @if (session()->has('success'))
        <div class="p-3 mb-4 text-green-700 bg-green-100 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    <form wire:submit.prevent="update" class="space-y-5">
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block font-medium text-gray-700">Sort Order</label>
                <input type="number" wire:model="sort_order" class="input input-bordered w-full">
                @error('sort_order') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block font-medium text-gray-700">Key</label>
                <input type="text" wire:model="key" class="input input-bordered w-full" readonly>
                @error('key') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>
        </div>

        <div>
            <label class="block font-medium text-gray-700">Name</label>
            <input type="text" wire:model="name" class="input input-bordered w-full">
            @error('name') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block font-medium text-gray-700">Subject</label>
            <input type="text" wire:model="subject" class="input input-bordered w-full">
            @error('subject') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block font-medium text-gray-700">Variables (comma separated)</label>
            <input type="text" wire:model="variables" class="input input-bordered w-full">
            @error('variables') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block font-medium text-gray-700">Body</label>
            <textarea wire:model="body" rows="6" class="textarea textarea-bordered w-full"></textarea>
            @error('body') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="flex justify-between items-center">
            <a href="{{ route('admin.email_templates.index') }}" class="text-gray-600 hover:text-gray-900">← Back</a>
            <button type="submit" class="btn btn-primary">Update Template</button>
        </div>
    </form>
</div>


</div>

