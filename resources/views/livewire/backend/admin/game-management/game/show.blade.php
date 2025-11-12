<section>
    <div class="glass-card rounded-2xl p-6 mb-6">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-bold text-text-black dark:text-text-white">{{ __('Game Details') }}</h2>
            <div class="flex items-center gap-2">
             
                <x-ui.button href="{{ route('admin.gm.game.index') }}" type='accent' class="w-auto! py-2!">
                    <flux:icon name="arrow-left" class="w-4 h-4 stroke-white" />
                    {{ __('Back') }}
                </x-ui.button>
            </div>
        </div>
    </div>
        <div class="bg-bg-primary rounded-2xl shadow-lg overflow-hidden border border-gray-500/20">
        <div class="px-8 py-8">
            <div class="mb-10">
             
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div class="bg-slate-50 dark:bg-gray-700 rounded-lg p-4 border border-slate-200">
                        <p class="text-text-white text-xs font-semibold mb-2">{{ __('Name') }}</p>

                        <p class="text-slate-400 text-lg font-bold"></p>{{ $data->name }}</p>
                    </div>
                    
                    <div class="bg-slate-50 dark:bg-gray-700 rounded-lg p-4 border border-slate-200">
                        <p class="text-text-white text-xs font-semibold mb-2">{{ __('Category') }}</p>

                        <p class="text-slate-400 text-lg font-bold"></p>{{ $data->category->name }}</p>
                    </div>
                    
                    {{-- - --}}
                    <div class="bg-slate-50 dark:bg-gray-700 rounded-lg p-4 border border-slate-200">
                        <p class="text-text-white text-xs font-semibold mb-2">{{ __('Slug') }}</p>

                        <p class="text-slate-400 text-lg font-bold"></p>{{ $data->slug }}</p>
                    </div>
                    {{-- - --}}

                    {{-- - --}}
                    <div class="bg-slate-50 dark:bg-gray-700 rounded-lg p-4 border border-slate-200">
                        <p class="text-text-white text-xs font-semibold mb-2">{{ __('Developer') }}</p>

                        <p class="text-slate-400 text-lg font-bold"></p>{{ $data->developer }}</p>
                    </div>
                    {{-- - --}}

                    {{-- - --}}
                    <div class="bg-slate-50 dark:bg-gray-700 rounded-lg p-4 border border-slate-200">
                        <p class="text-text-white text-xs font-semibold mb-2">{{ __('Publisher') }}</p>

                        <p class="text-slate-400 text-lg font-bold"></p>{{ $data->publisher }}</p>
                    </div>
                    {{-- - --}}

                    {{-- - --}}
                    <div class="bg-slate-50 dark:bg-gray-700 rounded-lg p-4 border border-slate-200">
                        <p class="text-text-white text-xs font-semibold mb-2">{{ __('Release Date') }}</p>

                        <p class="text-slate-400 text-lg font-bold"></p>{{ $data->release_date }}</p>
                    </div>
                    {{-- - --}}

                    {{-- - --}}
                    <div class="bg-slate-50 dark:bg-gray-700 rounded-lg p-4 border border-slate-200">
                        <p class="text-text-white text-xs font-semibold mb-2">{{ __('Platforms') }}</p>

                        <p class="text-slate-400 text-lg font-bold"></p>{{ json_encode($data->platform) }}</p>
                    </div>
                    {{-- - --}}

                    {{-- - --}}
                    <div class="bg-slate-50 dark:bg-gray-700 rounded-lg p-4 border border-slate-200">
                        <p class="text-text-white text-xs font-semibold mb-2">{{ __('Featured') }}</p>

                        <p class="text-slate-400 text-lg font-bold"></p> {{ $data->is_featured ? 'Yes' : 'No' }}</p>
                    </div>
                    {{-- - --}}

                    {{-- - --}}
                    <div class="bg-slate-50 dark:bg-gray-700 rounded-lg p-4 border border-slate-200">
                        <p class="text-text-white text-xs font-semibold mb-2">{{ __('Trending') }}</p>

                        <p class="text-slate-400 text-lg font-bold"></p> {{ $data->is_trending ? 'Yes' : 'No' }}</p>
                    </div>
                    {{-- - --}}

                    {{-- - --}}
                    <div class="bg-slate-50 dark:bg-gray-700 rounded-lg p-4 border border-slate-200">
                        <p class="text-text-white text-xs font-semibold mb-2">{{ __('Meta Title') }}</p>

                        <p class="text-slate-400 text-lg font-bold"></p> {{ $data->meta_title }}</p>
                    </div>
                    {{-- - --}}

                    {{-- - --}}
                    <div class="bg-slate-50 dark:bg-gray-700 rounded-lg p-4 border border-slate-200">
                        <p class="text-text-white text-xs font-semibold mb-2">{{ __('Description') }}</p>

                        <p class="text-slate-400 text-lg font-bold"></p> {{ $data->description }}</p>
                    </div>
                    {{-- - --}}

                    {{-- - --}}
                    <div class="bg-slate-50 dark:bg-gray-700 rounded-lg p-4 border border-slate-200">
                        <p class="text-text-white text-xs font-semibold mb-2">{{ __('Meta Description') }}</p>

                        <p class="text-slate-400 text-lg font-bold"></p> {{ $data->meta_description }}</p>
                    </div>
                    {{-- - --}}





                    <div class="bg-slate-50 dark:bg-gray-700 rounded-lg p-4 border border-slate-200">
                        <p class="text-text-white text-xs font-semibold mb-2">{{ __('STATUS') }}</p>
                        <p class="text-slate-400 text-lg font-bold">{{ $data->status }}</p>
                    </div>
                    <div class="bg-slate-50 dark:bg-gray-700 rounded-lg p-4 border border-slate-200">
                        <p class="text-text-white text-xs font-semibold mb-2">{{ __('CREATED AT') }}</p>
                        <p class="text-slate-400 text-lg font-bold">{{ $data->created_at_formatted ?? 'N/A' }}
                        </p>
                    </div>

                    <div class="bg-slate-50 dark:bg-gray-700 rounded-lg p-4 border border-slate-200">
                        <p class="text-text-white text-xs font-semibold mb-2">{{ __('UPDATED AT') }}</p>
                        <p class="text-slate-400 text-lg font-bold">{{ $data->updated_at_formatted ?? 'N/A' }}
                        </p>
                    </div>

                    <div class="bg-slate-50 dark:bg-gray-700 rounded-lg p-4 border border-slate-200">
                        <p class="text-text-white text-xs font-semibold mb-2">{{ __('DELETED AT') }}</p>
                        <p class="text-slate-400 text-lg font-bold">{{ $data->deleted_at_formatted ?? 'N/A' }}
                        </p>
                    </div>

                    <div class="bg-slate-50 dark:bg-gray-700 rounded-lg p-4 border border-slate-200">
                        <p class="text-text-white text-xs font-semibold mb-2">{{ __('RESTORED AT') }}</p>
                        <p class="text-slate-400 text-lg font-bold">{{ $data->restored_at_formatted ?? 'N/A' }}
                        </p>
                    </div>

                    <div class="bg-slate-50 dark:bg-gray-700 rounded-lg p-4 border border-slate-200">
                        <p class="text-text-white text-xs font-semibold mb-2">{{ __('CREATED BY') }}</p>
                        <p class="text-slate-400 text-lg font-bold">
                            {{ $data->creater->name ?? 'N/A' }}</p>
                    </div>

                    <div class="bg-slate-50 dark:bg-gray-700 rounded-lg p-4 border border-slate-200">
                        <p class="text-text-white text-xs font-semibold mb-2">{{ __('UPDATED BY') }}</p>
                        <p class="text-slate-400 text-lg font-bold">
                            {{ $data->updater->name ?? 'N/A' }}</p>
                    </div>

                    <div class="bg-slate-50 dark:bg-gray-700 rounded-lg p-4 border border-slate-200">
                        <p class="text-text-white text-xs font-semibold mb-2">{{ __('DELETED BY') }}</p>
                        <p class="text-slate-400 text-lg font-bold">
                            {{ $data->deleter->name ?? 'N/A' }}</p>
                    </div>
                    <div class="bg-slate-50 dark:bg-gray-700  rounded-lg p-4 border border-slate-200">
                        <p class="text-text-white text-xs font-semibold mb-2">{{ __('RESTORED BY') }} </p>
                        <p class="text-slate-400 text-lg font-bold">
                            {{ $data->restorer->name ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
