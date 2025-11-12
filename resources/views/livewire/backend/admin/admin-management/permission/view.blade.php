<div>
    {{-- Page Header --}}

    <div class="glass-card rounded-2xl p-4 lg:p-6 mb-6">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <h2 class="text-xl lg:text-2xl font-bold text-text-primary">
                {{ __('Permission Details') }}
            </h2>
            <div class="flex items-center gap-2">
                <x-ui.button href="{{ route('admin.am.permission.index') }}" class="w-auto! py-2!">
                    <flux:icon name="arrow-left"
                        class="w-4 h-4 stroke-text-btn-primary group-hover:stroke-text-btn-secondary" />
                    {{ __('Back') }}
                </x-ui.button>
            </div>
        </div>
    </div>

    <div class="glass-card shadow-glass-card rounded-xl p-6 ">

        {{-- Right Column --}}
        <div class="col-span-1 lg:col-span-2 p-4">
            <div class="bg-bg-primary rounded-2xl shadow-lg overflow-hidden border border-gray-500/20">
                <!-- Old Data Section -->
                <div class="px-6 py-10">
                    <div class="space-y-10">
                        <!-- Profile + Status Section -->
                        <div class="flex flex-col lg:flex-row items-center lg:items-start gap-10">
                            <!-- Info Cards -->
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 w-full">

                                <div
                                    class="bg-slate-50 dark:bg-gray-700 rounded-2xl p-6 border border-slate-200 shadow-md ">
                                    <p class="text-text-white text-xs font-semibold mb-2">{{ __('PREFIX') }}</p>
                                    <p class="text-slate-400 text-lg font-bold">{{ $data->prefix ?? 'N/A' }}</p>
                                </div>

                                 <div
                                    class="bg-slate-50 dark:bg-gray-700 rounded-2xl p-6 border border-slate-200 shadow-md ">
                                    <p class="text-text-white text-xs font-semibold mb-2">{{ __('GUARD') }}</p>
                                    <p class="text-slate-400 text-lg font-bold">{{ $data->guard_name ?? 'N/A' }}</p>
                                </div>

                                <div
                                    class="bg-slate-50 dark:bg-gray-700 rounded-2xl p-6 border border-slate-200 shadow-md ">

                                    <p class="text-text-white text-xs font-semibold mb-2">{{ __('NAME') }}</p>
                                    <p class="text-slate-400 text-lg font-bold ">{{ $data->name }}</p>
                                </div>

                                <div
                                    class="bg-slate-50 dark:bg-gray-700 rounded-2xl p-6 border border-slate-200 shadow-md">
                                    <p class="text-text-white text-xs font-semibold mb-2">{{ __('CREATED AT') }}</p>
                                    <p class="text-slate-400 text-lg font-bold">{{ $data->created_at_formatted ?? 'N/A' }}
                                    </p>
                                </div>

                                <div
                                    class="bg-slate-50 dark:bg-gray-700 rounded-2xl p-6 border border-slate-200 shadow-md">
                                    <p class="text-text-white text-xs font-semibold mb-2">{{ __('UPDATED AT') }}</p>
                                    <p class="text-slate-400 text-lg font-bold">{{ $data->updated_at_formatted ?? 'N/A' }}</p>
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
