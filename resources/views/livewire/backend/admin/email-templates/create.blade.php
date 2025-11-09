<div>
    {{-- Success is as dangerous as failure. --}}
    <div  class="container mx-auto">
   <div class="max-w-3xl mx-auto bg-zinc-600 text-cyan-700 p-8 rounded-xl shadow-lg">
    <h2 class="text-2xl font-bold mb-6 text-gray-800">Create Email Template</h2>

    @if (session()->has('success'))
        <div class="p-3 mb-4 text-green-700 bg-green-100 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    <form wire:submit.prevent="save" class="space-y-5">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block font-medium text-gray-black ">Sort Order</label>
                <input type="number" wire:model="sort_order" class="input input-bordered w-full" placeholder="0">
                @error('sort_order') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block font-medium text-black">Key</label>
                <input type="text" wire:model="key" class="input input-bordered w-full" placeholder="unique_key_name">
                @error('key') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>
        </div>

        <div>
            <label class="block font-medium text-black">Name</label>
            <input type="text" wire:model="name" class="input input-bordered w-full" placeholder="Email Template Name">
            @error('name') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block font-medium text-black">Subject</label>
            <input type="text" wire:model="subject" class="input input-bordered w-full" placeholder="Email Subject">
            @error('subject') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block font-medium text-black ">Variables (comma separated)</label>
            <input type="text" wire:model="variables" class="input input-bordered w-full" placeholder="e.g. name,email,phone">
            @error('variables') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block font-medium text-black">Body</label>
            <textarea wire:model="body" rows="6" class="textarea textarea-bordered w-full text-black" placeholder="Write your email content here..."></textarea>
            @error('body') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="flex justify-end">
            <button type="submit" class="btn btn-primary">Save Template</button>
        </div>
         <div class="flex items-start w-auto h-ahto">
                <a href="{{ route('admin.email_templates.index')}}">
                <button type="submit " class="btn btn-primary">break to home</button>
                </a>

            </div>
    </form>
</div>

</div>
</div>
