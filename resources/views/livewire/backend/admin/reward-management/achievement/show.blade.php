<div>
    {{-- Page Header --}}

    <div class="bg-bg-secondary w-full rounded">
        <div class="mx-auto">
            <div class="glass-card rounded-2xl p-4 lg:p-6 mb-6">
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                    <h2 class="text-xl lg:text-2xl font-bold text-text-black dark:text-text-white">
                        {{ __('Achievement Details') }}
                    </h2>
                    
                    <div class="flex items-center gap-2 w-full sm:w-auto">
                        <x-ui.button
                            x-on:click="$dispatch('show-translation-modal', {
                                modelId: '{{ encrypt($data->id) }}',
                                modelType: '{{ base64_encode(\App\Models\Achievement::class) }}'
                            })"
                            variant="secondary" class="w-auto py-2! text-nowrap">
                            <flux:icon name="arrows-pointing-out"
                                class="w-4 h-4 stroke-text-btn-secondary group-hover:stroke-text-btn-primary" />
                            {{ __('Manage Translations') }}
                        </x-ui.button>
                        
                        <x-ui.button href="{{ route('admin.rm.achievement.index') }}" class="w-auto py-2!">
                            <flux:icon name="arrow-left"
                                class="w-4 h-4 stroke-text-btn-primary group-hover:stroke-text-btn-secondary" />
                            {{ __('Back') }}
                        </x-ui.button>
                    </div>
                </div>
            </div>
            <!-- Main Card -->
            <div class="bg-bg-primary rounded-2xl shadow-lg overflow-hidden border border-gray-500/20">

                <!-- Product Data Section -->
                <div class="px-8 py-8">
                    <div class="mb-10">
                        <div class="bg-slate-50 dark:bg-gray-700 rounded-lg p-4 border border-slate-200">
                            <p class="text-text-white text-xs font-semibold mb-2 capitalize">{{ __('Image') }}</p>

                            <div class="flex items-center justify-center">
                                <img src="{{ storage_url($data->icon) }}" alt="{{ $data->name }}" class="max-w-full">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">

                            <div class="bg-slate-50 dark:bg-gray-700 rounded-lg p-4 border border-slate-200">
                                <p class="text-text-white text-xs font-semibold mb-2">{{ __('TITLE') }}</p>
                                <p class="text-slate-400 text-lg font-bold">{{ $data->title }}</p>
                            </div>

                            {{-- <div class="bg-slate-50 dark:bg-gray-700 rounded-lg p-4 border border-slate-200">
                                <p class="text-text-white text-xs font-semibold mb-2">{{ __('Rank') }}</p>
                                <p class="text-slate-400 text-lg font-bold">{{ $data->rank->name }}</p>
                            </div> --}}

                            <div class="bg-slate-50 dark:bg-gray-700 rounded-lg p-4 border border-slate-200">
                                <p class="text-text-white text-xs font-semibold mb-2">{{ __('Achievement Type') }}</p>
                                <p class="text-slate-400 text-lg font-bold">{{ $data->achievement->name ?? 'N/A' }}</p>
                            </div>

                            <div class="bg-slate-50 dark:bg-gray-700 rounded-lg p-4 border border-slate-200">
                                <p class="text-text-white text-xs font-semibold mb-2">{{ __('TARGET VALUE') }}</p>
                                <p class="text-slate-400 text-lg font-bold">{{ $data->target_value }}</p>
                            </div>

                            <div class="bg-slate-50 dark:bg-gray-700 rounded-lg p-4 border border-slate-200">
                                <p class="text-text-white text-xs font-semibold mb-2">{{ __('POINT REWARD') }}</p>
                                <p class="text-slate-400 text-lg font-bold">{{ $data->point_reward }}</p>
                            </div>
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
                                    {{ $data->creater_admin->name ?? 'N/A' }}</p>
                            </div>

                            <div class="bg-slate-50 dark:bg-gray-700 rounded-lg p-4 border border-slate-200">
                                <p class="text-text-white text-xs font-semibold mb-2">{{ __('UPDATED BY') }}</p>
                                <p class="text-slate-400 text-lg font-bold">
                                    {{ $data->updater_admin->name ?? 'N/A' }}</p>
                            </div>

                            <div class="bg-slate-50 dark:bg-gray-700 rounded-lg p-4 border border-slate-200">
                                <p class="text-text-white text-xs font-semibold mb-2">{{ __('DELETED BY') }}</p>
                                <p class="text-slate-400 text-lg font-bold">
                                    {{ $data->deleter_admin->name ?? 'N/A' }}</p>
                            </div>
                            <div class="bg-slate-50 dark:bg-gray-700  rounded-lg p-4 border border-slate-200">
                                <p class="text-text-white text-xs font-semibold mb-2">{{ __('RESTORED BY') }} </p>
                                <p class="text-slate-400 text-lg font-bold">
                                    {{ $data->restorer_admin->name ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-slate-50 dark:bg-gray-700 rounded-lg p-4 border border-slate-200 mt-4">
                        <p class="text-text-white text-xs font-semibold mb-2">{{ __('DESCRIPTION') }}</p>
                        <p class="text-slate-400 text-lg font-bold">{!! $data->description !!}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
