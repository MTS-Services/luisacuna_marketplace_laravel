<div>
    {{-- Page Header --}}

    <div class="bg-bg-secondary w-full rounded">
        <div class="mx-auto">
            <div class="glass-card rounded-2xl p-4 lg:p-6 mb-6">
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                    <h2 class="text-xl lg:text-2xl font-bold text-text-black dark:text-text-white">
                        {{ __('Tag Details') }}
                    </h2>
                    <div class="flex items-center gap-2 w-full sm:w-auto">
                        <x-ui.button href="{{ route('admin.gm.tag.edit', encrypt($data->id)) }}" variant="secondary"
                            class="w-auto py-2!">
                            <flux:icon name="pencil"
                                class="w-4 h-4 stroke-text-btn-secondary group-hover:stroke-text-btn-primary" />
                            {{ __('Edit') }}
                        </x-ui.button>

                        <x-ui.button href="{{ route('admin.gm.tag.index') }}" class="w-auto py-2!">
                            <flux:icon name="arrow-left"
                                class="w-4 h-4 stroke-text-btn-primary group-hover:stroke-text-btn-secondary" />
                            {{ __('Back') }}
                        </x-ui.button>
                    </div>
                </div>
            </div>
            <!-- Main Card -->
            <div class="bg-bg-primary rounded-2xl shadow-lg overflow-hidden border border-gray-500/20">
                <div class="px-8 py-8">
                    <div class="mb-10">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">

                            <div class="bg-slate-50 dark:bg-gray-700 rounded-lg p-4 border border-slate-200">
                                <p class="text-text-white text-xs font-semibold mb-2">{{ __('Icon') }}</p>
                                @if ($data->icon)
                                    {{-- <img src="{{ Storage::url($data->icon) ?? 'N/A' }}" alt=""
                                        class="rounded overflow-hidden h-10 w-10"> --}}

                                    <img src="{{ storage_url($data->icon) }}"  alt="{{ $data->name }}" class="rounded overflow-hidden h-10 w-10" />
                                @else
                                    <div
                                        class="w-10 h-10 rounded-full bg-gray-200 dark:bg-gray-400 flex items-center justify-center text-gray-600 dark:text-gray-300 font-semibold">
                                        {{ strtoupper(substr($data->name, 0, 2)) }}</div>
                                @endif

                            </div>

                            <div class="bg-slate-50 dark:bg-gray-700 rounded-lg p-4 border border-slate-200">
                                <p class="text-text-white text-xs font-semibold mb-2">{{ __('Name') }}</p>

                                <p class="text-slate-400 text-lg font-bold">
                                    <span class="px-2 py-1 rounded-xl"
                                        style="color: {{ $data->text_color }} !important; background-color: {{ $data->bg_color }} !important">
                                        {{ $data->name }}
                                    </span>
                                </p>
                            </div>
                            <div class="bg-slate-50 dark:bg-gray-700 rounded-lg p-4 border border-slate-200">
                                <p class="text-text-white text-xs font-semibold mb-2">{{ __('STATUS') }}</p>
                                <p class="text-sm rounded-3xl font-bold {{ $data->status->color() }}">
                                    {{ $data->status->label() }}</p>
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
                </div>
            </div>
        </div>
    </div>
</div>
