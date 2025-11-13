<div>
    {{-- Page Header --}}
    {{--
    <div class="bg-bg-secondary w-full rounded">
        <div class="mx-auto">
            <div class="glass-card rounded-2xl p-4 lg:p-6 mb-6">
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                    <h2 class="text-xl lg:text-2xl font-bold text-text-black dark:text-text-white">
                        {{ __('Rank Details ') }}
                    </h2>
                    <div class="flex items-center gap-2 w-full sm:w-auto">
                        <x-ui.button href="{{ route('admin.rm.rank.index') }}" class="w-auto py-2!">
                            <flux:icon name="arrow-left"
                                class="w-4 h-4 stroke-text-btn-primary group-hover:stroke-text-btn-secondary" />
                            {{ __('Back') }}
                        </x-ui.button>
                    </div>
                </div>
            </div>
            <!-- Main Card -->
            <div class="bg-bg-primary rounded-2xl shadow-lg overflow-hidden border border-gray-500/20">
                <!-- Old Data Section -->
                <div class="px-8 py-8">
                    <div class="mb-10">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                            <div class="bg-slate-50 dark:bg-gray-700 rounded-lg p-4 border border-slate-200">
                                <p class="text-text-white text-xs font-semibold mb-2">{{ __('NAME') }}</p>

                                <p class="text-slate-400 text-lg font-bold">{{ $data->name }}</p>
                            </div>

                            <div class="bg-slate-50 dark:bg-gray-700  rounded-lg p-4 border border-slate-200">
                                <p class="text-text-white text-xs font-semibold mb-2">{{ __('SLUG') }}</p>
                                <p class="text-slate-400 text-lg font-bold">{{ $data->slug }}</p>

                            </div>

                            <div class="bg-slate-50 dark:bg-gray-700  rounded-lg p-4 border border-slate-200">
                                <p class="text-text-white text-xs font-semibold mb-2">{{ __('MINIMUM_POINTS') }}</p>
                                <p class="text-slate-400 text-lg font-bold">{{ $data->minimum_points }}</p>
                            </div>

                            <div class="bg-slate-50 dark:bg-gray-700  rounded-lg p-4 border border-slate-200">
                                <p class="text-text-white text-xs font-semibold mb-2">{{ __('MAXIMUM_POINTS') }}
                                </p>
                                <p class="text-slate-400 text-lg font-bold">{{ $data->maximum_points ?? 'N/A'}}</p>
                            </div>
                            <div class="bg-slate-50 dark:bg-gray-700  rounded-lg p-4 border border-slate-200">
                                <p class="text-text-white text-xs font-semibold mb-2">{{ __('ICON') }}
                                </p>
                                <p class="text-slate-400 text-lg font-bold">{{ $data->icon }}</p>
                            </div>
                            <div class="bg-slate-50 dark:bg-gray-700  rounded-lg p-4 border border-slate-200">
                                <p class="text-text-white text-xs font-semibold mb-2">{{ __('STATUS') }}
                                </p>
                                <p class="text-slate-400 text-lg font-bold">{{ $data->status }}</p>
                            </div>
                            <div class="bg-slate-50 dark:bg-gray-700  rounded-lg p-4 border border-slate-200">
                                <p class="text-text-white text-xs font-semibold mb-2">{{ __('INITIAL_ASSIGN') }}
                                </p>
                                <p class="text-slate-400 text-lg font-bold">{{ $data->initial_assign == 1 ? 'Yes' : 'No' }}</p>
                            </div>
                            <div class="bg-slate-50 dark:bg-gray-700  rounded-lg p-4 border border-slate-200">
                                <p class="text-text-white text-xs font-semibold mb-2">{{ __('CREATED_AT') }}
                                </p>
                                <p class="text-slate-400 text-lg font-bold">{{ $data->created_at_formatted }}</p>
                            </div>
                            <div class="bg-slate-50 dark:bg-gray-700  rounded-lg p-4 border border-slate-200">
                                <p class="text-text-white text-xs font-semibold mb-2">{{ __('UPDATED_AT') }}
                                </p>
                                <p class="text-slate-400 text-lg font-bold">{{ $data->updated_at_formatted }}</p>
                            </div>
                            <div class="bg-slate-50 dark:bg-gray-700  rounded-lg p-4 border border-slate-200">
                                <p class="text-text-white text-xs font-semibold mb-2">{{ __('CREATED_BY') }}
                                </p>
                                <p class="text-slate-400 text-lg font-bold">{{ $data->created_by }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}










    <div>

        {{-- Page Header --}}
        <div class="glass-card rounded-2xl p-4 lg:p-6 mb-6">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                <h2 class="text-xl lg:text-2xl font-bold text-text-primary">
                    {{ __('Rank') }}
                </h2>
                <div class="flex items-center gap-2">
                    <x-ui.button href="{{ route('admin.rm.rank.index') }}" class="w-auto! py-2!">
                        <flux:icon name="arrow-left"
                            class="w-4 h-4 stroke-text-btn-primary group-hover:stroke-text-btn-secondary" />
                        {{ __('Back') }}
                    </x-ui.button>
                </div>
            </div>
        </div>
        <div class="glass-card shadow-glass-card rounded-xl p-6 min-h-[500px]">


            {{-- Right Column --}}
            <div class="col-span-1 lg:col-span-2 p-4"> 

                <div class="bg-bg-primary rounded-2xl shadow-lg overflow-hidden border border-gray-500/20">

                    <!-- Old data Section -->
                    <div class="px-6 py-10">
                        <div class="space-y-10">
                            <!-- Profile + Status Section -->
                            <div class="flex flex-col lg:flex-row items-center lg:items-start gap-10">

                                <!-- Info Cards -->
                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 w-full">

                                    <div
                                        class="bg-slate-50 dark:bg-gray-700 rounded-2xl p-6 border border-slate-200 shadow-md ">
                                        <p class="text-text-white text-xs font-semibold mb-2">{{ __('dataNAME') }}</p>
                                        <p class="text-slate-400 text-lg font-bold ">{{ $data->name }}</p>
                                    </div>

                                    <div
                                        class="bg-slate-50 dark:bg-gray-700 rounded-2xl p-6 border border-slate-200 shadow-md ">
                                        <p class="text-text-white text-xs font-semibold mb-2">{{ __('dataSLUG') }}</p>
                                        <p class="text-slate-400 text-lg font-bold ">{{ $data->slug }}</p>
                                    </div>

                                    <div
                                        class="bg-slate-50 dark:bg-gray-700 rounded-2xl p-6 border border-slate-200 shadow-md ">
                                        <p class="text-text-white text-xs font-semibold mb-2">
                                            {{ __('MINIMUM POINTS') }}</p>
                                        <p class="text-slate-400 text-lg font-bold">{{ $data->minimum_points }}</p>
                                    </div>

                                    <div
                                        class="bg-slate-50 dark:bg-gray-700 rounded-2xl p-6 border border-slate-200 shadow-md ">
                                        <p class="text-text-white text-xs font-semibold mb-2">
                                            {{ __('MAXIMUM POINTS') }}</p>
                                        <p class="text-slate-400 text-lg font-bold">
                                            {{ $data->maximum_points ?? 'N/A' }}</p>
                                    </div>

                                    <div
                                        class="bg-slate-50 dark:bg-gray-700 rounded-2xl p-6 border border-slate-200 shadow-md">
                                        <p class="text-text-white text-xs font-semibold mb-2">{{ __('STATUS') }}</p>
                                        <p class="text-slate-400 text-lg font-bold">{{ $data->status ?? 'N/A' }}</p>
                                    </div>

                                    <div
                                        class="bg-slate-50 dark:bg-gray-700 rounded-2xl p-6 border border-slate-200 shadow-md">
                                        <p class="text-text-white text-xs font-semibold mb-2">
                                            {{ __('INITIAL ASSIGN') }}</p>
                                        <p class="text-slate-400 text-lg font-bold">
                                            {{ $data->initial_assign ?? 'N/A' }}</p>
                                    </div>

                                    <div
                                        class="bg-slate-50 dark:bg-gray-700 rounded-2xl p-6 border border-slate-200 shadow-md">
                                        <p class="text-text-white text-xs font-semibold mb-2">{{ __('language') }}
                                        </p>
                                        <p class="text-slate-400 text-lg font-bold">
                                            {{ $data->language_id === 1 ? 'Yes' : 'No' }}
                                        </p>
                                    </div>

                                    <div
                                        class="bg-slate-50 dark:bg-gray-700 rounded-2xl p-6 border border-slate-200 shadow-md">
                                        <p class="text-text-white text-xs font-semibold mb-2">{{ __('CREATED') }}
                                        </p>
                                        <p class="text-slate-400 text-lg font-bold">
                                            {{ $data->created_at_formatted ?? 'N/A' }}
                                        </p>
                                    </div>

                                    <div
                                        class="bg-slate-50 dark:bg-gray-700 rounded-2xl p-6 border border-slate-200 shadow-md">
                                        <p class="text-text-white text-xs font-semibold mb-2">{{ __('UPDATED') }}
                                        </p>
                                        <p class="text-slate-400 text-lg font-bold">
                                            {{ $data->updated_at_formatted ?? 'N/A' }}
                                        </p>
                                    </div>

                                    <div
                                        class="bg-slate-50 dark:bg-gray-700 rounded-2xl p-6 border border-slate-200 shadow-md">
                                        <p class="text-text-white text-xs font-semibold mb-2">{{ __('CREATED BY') }}
                                        </p>
                                        <p class="text-slate-400 text-lg font-bold">{{ $data->created_by ?? 'N/A' }}
                                        </p>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</div>
