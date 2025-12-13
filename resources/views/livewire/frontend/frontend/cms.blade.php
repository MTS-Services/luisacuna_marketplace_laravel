<div>
    <div class="bg-bg-primary text-text-white font-sans min-h-screen">

        <div class="max-w-7xl mx-auto py-12 px-6">

            <div class="text-center mb-10">
                <h2 class="text-xl font-bold text-text-black dark:text-text-white"> {{ $typeEnum->label() }}</h2>
                <p class="text-gray-500 text-sm">{{ __('Update Time : ') . $cms?->updated_at_formatted }}</p>
            </div>

            <div class="space-y-8">
                {!! $cms?->content !!}
            </div>

        </div>
    </div>
</div>
