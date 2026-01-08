<div>
    <div class="bg-bg-primary text-text-white font-sans min-h-screen">

        <div class="max-w-7xl mx-auto py-12 px-6">

            <div class="text-center mb-10">
                <h2 class="text-xl font-bold text-text-black dark:text-text-white"> {{ $typeEnum->label() }}</h2>
                <p class="text-gray-500 text-sm">{{ __('Update Time : ') . $cms?->updated_at_formatted }}</p>
            </div>

            <div class="space-y-8 prose prose-lg dark:prose-invert max-w-none mx-auto">
                {!! $cms?->content !!}
            </div>

            <div class="flex justify-end space-x-4 pt-10">
                <button
                    class="flex items-center px-5 py-2.5 rounded-full bg-gray-100 text-text-purple font-medium transition duration-150 text-sm shadow-md">
                    <x-phosphor-thumbs-up-fill class="w-5 h-5 fill-zinc-500 mr-2" />
                    {{ __("It's helpful") }}
                </button>

                <button
                    class="flex items-center px-5 py-2.5 rounded-full bg-gray-100 text-text-purple font-medium transition duration-150 text-sm shadow-md">
                    <x-phosphor-thumbs-down-fill class="w-5 h-5 fill-zinc-500 mr-2" />
                    {{ __("It's not helpful") }}
                </button>
            </div>
        </div>
    </div>
</div>
