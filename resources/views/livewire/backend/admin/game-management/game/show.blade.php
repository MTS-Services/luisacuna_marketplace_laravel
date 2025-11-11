<section>
    <div class="glass-card rounded-2xl p-6 mb-6">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-bold text-text-black dark:text-text-white">{{ __('Game View') }}</h2>
            <div class="flex items-center gap-2">
                {{-- <x-ui.button href="{{ route('admin.am.admin.trash') }}" type='secondary'>
                    <flux:icon name="trash" class="w-4 h-4 stroke-white" />
                    {{ __('Trash') }}
                </x-ui.button> --}}
                {{-- <x-ui.button href="{{ route('admin.am.admin.create') }}">
                    <flux:icon name="user-plus" class="w-4 h-4 stroke-white" />
                    {{ __('Add') }}
                </x-ui.button>  --}}
                <x-ui.button href="{{ route('admin.gm.game.index') }}" type='accent' class="w-auto! py-2!">
                    <flux:icon name="arrow-left" class="w-4 h-4 stroke-white" />
                    {{ __('Back') }}
                </x-ui.button>
            </div>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 shadow rounded-xl p-6 min-h-[500px]">
        <div class="flex items-start gap-4 mb-6">
            {{-- Logo Display --}}
            @if ($data->logo)
                <div class="flex-shrink-0">
                    <img src="{{ asset('storage/' . $data->logo) }}" alt="{{ $data->name }}"
                        class="w-16 h-16 rounded-lg object-cover border-2 border-gray-200 dark:border-gray-700">
                </div>
            @endif

            <div>
                <h3 class="text-2xl font-bold text-gray-900 dark:text-white">
                    {{ $data->name }}
                </h3>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">{{ $data->slug }}</p>
            </div>
        </div>

        {{-- Banner Images Section --}}
        <div class="mb-8">
           <div class="mb-6">
                <h3 class="text-lg font-medium mb-2">{{ __('Banner Image') }}</h3>
                <div class="overflow-hidden">
                    <img src="{{ asset('storage/' . $data->banner) }}" alt="{{ $data->name }}"
                        class="w-auto object-contain bg-gray-100">
                </div>
            </div>
            <!-- Main Card -->
            <div class="bg-bg-primary rounded-2xl shadow-lg overflow-hidden border border-gray-500/20">
                <!-- Event Header Section -->
                <div class="dark:bg-bg-container1 bg-bg-secondary px-8 py-8">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">

        </div>

        {{-- Thaumbnail Images Section --}}
        <div class="mb-8">

            <div class="mb-6">
                <h3 class="text-lg font-medium mb-2">{{ __('Thumbnail Image') }}</h3>
                <div class="overflow-hidden">
                    <img src="{{ asset('storage/' . $data->thumbnail) }}" alt="{{ $data->name }}"
                        class="w-auto object-contain bg-gray-100">
                </div>
            </div>

        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">

            {{-- Name --}}
            <div class="col-span-1">
                <p class="text-gray-500 dark:text-gray-400">{{ __('Name') }}</p>
                <p class="font-mono font-semibold text-gray-900 dark:text-white">
                    {{ $data->name }}
                </p>
            </div>

            {{-- Game Category --}}
            <div class="col-span-1">
                <p class="text-gray-500 dark:text-gray-400">{{ __('Game Category') }}</p>
                <p class="font-mono font-semibold text-gray-900 dark:text-white">
                    {{ $data->category->name }}
                </p>
            </div>

            {{-- Slug --}}
            <div class="col-span-1">
                <p class="text-gray-500 dark:text-gray-400">{{ __('Slug') }}</p>
                <p class="font-mono font-semibold text-gray-900 dark:text-white">
                    {{ $data->slug }}
                </p>
            </div>
            {{-- Developer --}}
            <div class="col-span-1">
                <p class="text-gray-500 dark:text-gray-400">{{ __('Developer') }}</p>
                <p class="font-mono font-semibold text-gray-900 dark:text-white">
                    {{ $data->developer }}
                </p>
            </div>

            {{-- Developer --}}
            <div class="col-span-1">
                <p class="text-gray-500 dark:text-gray-400">{{ __('Publisher') }}</p>
                <p class="font-mono font-semibold text-gray-900 dark:text-white">
                    {{ $data->publisher }}
                </p>
            </div>
            {{-- Developer --}}
            <div class="col-span-1">
                <p class="text-gray-500 dark:text-gray-400">{{ __('Developer') }}</p>
                <p class="font-mono font-semibold text-gray-900 dark:text-white">
                    {{ $data->release_date }}
                </p>
            </div>

            {{-- Platform --}}
            <div class="col-span-1">
                <p class="text-gray-500 dark:text-gray-400">{{ __('Platforms') }}</p>
                <p class="font-mono font-semibold text-gray-900 dark:text-white">
                    {{ json_encode($data->platform) }}
                </p>
            </div>



            {{-- Featured --}}
            <div class="col-span-1">
                <p class="text-gray-500 dark:text-gray-400">{{ __('Featured') }}</p>
                <p class="font-mono font-semibold text-gray-900 dark:text-white">
                    {{ $data->is_featured ? 'Yes' : 'No' }}
                </p>
            </div>


            {{-- Trending --}}
            <div class="col-span-1">
                <p class="text-gray-500 dark:text-gray-400">{{ __('Trending') }}</p>
                <p class="font-mono font-semibold text-gray-900 dark:text-white">
                    {{ $data->is_trending ? 'Yes' : 'No' }}
                </p>
            </div>

            {{-- Status --}}
            <div class="col-span-1">
                <p class="text-gray-500 dark:text-gray-400">{{ __('Status') }}</p>
                <p class="font-mono font-semibold text-gray-900 dark:text-white">
                    {{ $data->status->label() }}
                </p>
            </div>

            {{-- Meta Title --}}
            <div class="col-span-1">
                <p class="text-gray-500 dark:text-gray-400">{{ __('Meta Title') }}</p>
                <p class="font-mono font-semibold text-gray-900 dark:text-white">
                    {{ $data->meta_title ?? 'N/A' }}
                </p>
            </div>

            {{-- Meta Description --}}
            <div class="col-span-1">
                <p class="text-gray-500 dark:text-gray-400">{{ __('Meta Description') }}</p>
                <p class="font-mono font-semibold text-gray-900 dark:text-white">
                    {{ $data->meta_description ?? 'N/A' }}
                </p>
            </div>


            {{-- Meta Keywords --}}
            <div class="col-span-1">
                <p class="text-gray-500 dark:text-gray-400">{{ __('Meta Keywords') }}</p>
                <p class="font-mono font-semibold text-gray-900 dark:text-white">
                    {{ $data->meta_keywords ?? 'N/A' }}
                </p>
            </div>


            {{-- Kreated At --}}
            <div class="col-span-1">
                <p class="text-gray-500 dark:text-gray-400">{{ __('Created At') }}</p>
                <p class="font-mono font-semibold text-gray-900 dark:text-white">
                    {{ $data->created_at_formatted ?? 'N/A' }}
                </p>
            </div>

            {{-- Updated At --}}
            <div class="col-span-1">
                <p class="text-gray-500 dark:text-gray-400">{{ __('Created At') }}</p>
                <p class="font-mono font-semibold text-gray-900 dark:text-white">
                    {{ $data->updated_at_formatted ?? 'N/A' }}
                </p>
            </div>


            {{-- Delete At At --}}
            <div class="col-span-1">
                <p class="text-gray-500 dark:text-gray-400">{{ __('Deleted At') }}</p>
                <p class="font-mono font-semibold text-gray-900 dark:text-white">
                    {{ $data->deleted_at_formatted ?? 'N/A' }}
                </p>
            </div>



            {{-- Created By --}}
            <div class="col-span-1">
                <p class="text-gray-500 dark:text-gray-400">{{ __('Created By') }}</p>
                <p class="font-mono font-semibold text-gray-900 dark:text-white uppercase">
                    {{ $data->creater?->name ?? 'N/A' }}
                </p>
            </div>

            {{-- Created Type --}}
            <div class="col-span-1">
                <p class="text-gray-500 dark:text-gray-400">{{ __('Created Type') }}</p>
                <p class="font-mono font-semibold text-gray-900 dark:text-white uppercase">

                    {{ 'Not Set' }}
                </p>
            </div>

            {{-- Updated By --}}
            <div class="col-span-1">
                <p class="text-gray-500 dark:text-gray-400">{{ __('Updated by') }}</p>
                <p class="font-mono font-semibold text-gray-900 dark:text-white uppercase">
                    {{-- {{ $data->updater?->name ?? 'N/A' }} --}}
                </p>
            </div>

            {{-- Updater Type --}}
            <div class="col-span-1">
                <p class="text-gray-500 dark:text-gray-400">{{ __('Updater Type') }}</p>
                <p class="font-mono font-semibold text-gray-900 dark:text-white uppercase">

                    {{ 'Not Set' }}
                </p>
            </div>

            {{-- Rostorer By --}}
            <div class="col-span-1">
                <p class="text-gray-500 dark:text-gray-400">{{ __('Restorer by') }}</p>
                <p class="font-mono font-semibold text-gray-900 dark:text-white uppercase">
                    {{ $data->restorer?->name ?? 'N/A' }}
                </p>
            </div>

            {{-- Restorer Type --}}
            <div class="col-span-1">
                <p class="text-gray-500 dark:text-gray-400">{{ __('Restorer Type') }}</p>
                <p class="font-mono font-semibold text-gray-900 dark:text-white uppercase">

                    {{ 'Not Set' }}
                </p>
            </div>



        </div>
        {{-- Description Section --}}
        <div class="mt-8 border-t border-gray-200 dark:border-gray-700 pt-6">
            <h4 class="text-lg font-bold text-gray-900 dark:text-white mb-3">{{ __('Description') }}</h4>
            <div class="prose dark:prose-invert max-w-none text-gray-700 dark:text-gray-300">
                {!! $data->description !!}
            </div>
        </div>
    </div>
</div>
