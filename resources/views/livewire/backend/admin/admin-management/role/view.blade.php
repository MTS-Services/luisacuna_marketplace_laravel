<div>
    {{-- Page Header --}}

    <div class="bg-bg-secondary w-full rounded">
        <div class="mx-auto">
            <div class="glass-card rounded-2xl p-4 lg:p-6 mb-6">
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                    <h2 class="text-xl lg:text-2xl font-bold text-text-black dark:text-text-white">
                        {{ __('Audit Log Details') }}
                    </h2>
                    <div class="flex items-center gap-2 w-full sm:w-auto">
                        <x-ui.button href="{{ route('admin.alm.audit.index') }}" class="w-auto py-2!">
                            <flux:icon name="arrow-left"
                                class="w-4 h-4 stroke-text-btn-primary group-hover:stroke-text-btn-secondary" />
                            {{ __('Back') }}
                        </x-ui.button>
                    </div>
                </div>
            </div>
            <!-- Main Card -->
            <div class="bg-bg-primary rounded-2xl shadow-lg overflow-hidden border border-gray-500/20">
                <!-- Event Header Section -->
                <div class="dark:bg-bg-container1 bg-bg-secondary px-8 py-8">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                        <div>
                            <p class="text-blue-400 text-sm font-semibold mb-2">{{ __('Event') }}</p>

                            <p class="text-text-white text-2xl font-bold">{{ $data->event }}</p>
                        </div>

                        <div>
                            <p class="text-blue-400 text-sm font-semibold mb-2">{{ __('AUDITABLE') }}</p>
                            <p class="text-text-white font-mono text-lg">{{ $data->auditable_type }}</p>
                        </div>

                        <div>
                            <p class="text-blue-400 text-sm font-semibold mb-2">{{ __('IP ADDRESS') }}</p>
                            <p class="text-text-white font-mono text-lg">{{ $data->ip_address }}</p>
                        </div>

                        <div>
                            <p class="text-blue-400 text-sm font-semibold mb-2">{{ __('USER AGENT') }}</p>
                            <p class="text-text-white text-lg font-semibold">{{ $data->user_agent }}</p>
                        </div>
                    </div>
                </div>

                <!-- Metadata Section -->
                <div class="border-b border-gray-300 px-8 py-6 bg-bg-primary">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">

                        <div>
                            <p class="dark:text-slate-400 text-sm font-semibold mb-1">{{ __('TAG') }}</p>
                            <p
                                class=" font-mono text-sm dark:bg-gray-700  bg-white px-3 py-2 rounded border border-slate-200">

                                {{ $data->tags }} </p>
                        </div>

                        <div>
                            <p class="dark:text-slate-400 text-sm font-semibold mb-1">{{ __('URL') }}</p>
                            <p
                                class="font-mono text-sm bg-white px-3 py-2 rounded border dark:bg-gray-700 border-slate-200 truncate">
                                {{ $data->url }}</p>
                        </div>

                        <div>
                            <p class="dark:text-slate-400 text-sm font-semibold mb-1">{{ __('AUDIT BY') }}</p>
                            <p class=" text-sm bg-white px-3 py-2 rounded dark:bg-gray-700  border border-slate-200">
                                {{ $data->auditable_id }}
                            </p>
                        </div>

                        <div>
                            <p class="dark:text-slate-400 text-sm font-semibold mb-1">{{ __('AUDIT DATE') }}</p>
                            <p
                                class=" font-mono text-sm bg-white dark:bg-gray-700  px-3 py-2 rounded border border-slate-200">
                                {{ $data->created_at_formatted }}</p>

                        </div>
                    </div>
                </div>

                <!-- Old Data Section -->
                <div class="px-8 py-8">
                    <div class="mb-10">
                        <h2 class="text-lg font-bold text-text-secondary mb-6 flex items-center">
                            <span class="w-2 h-2 bg-amber-500 rounded-full mr-3"></span>
                            {{ __('Previous Values') }}
                        </h2>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                            <div class="bg-slate-50 dark:bg-gray-700 rounded-lg p-4 border border-slate-200">
                                <p class="text-text-white text-xs font-semibold mb-2">{{ __('Name') }}</p>

                                <p class="text-slate-400 text-lg font-bold">{{ $data->name }}</p>
                            </div>

                            <div class="bg-slate-50 dark:bg-gray-700  rounded-lg p-4 border border-slate-200">
                                <p class="text-text-white text-xs font-semibold mb-2">{{ __('GUARD_NAME') }}</p>
                                <p class="text-slate-400 text-lg font-bold">{{ $data->guard_name }}</p>

                            </div>

                            <div class="bg-slate-50 dark:bg-gray-700  rounded-lg p-4 border border-slate-200">
                                <p class="text-text-white text-xs font-semibold mb-2">{{ __('CREATED_AT') }}</p>
                                <p class="text-slate-400 text-lg font-bold">{{ $data->created_at }}</p>
                            </div>

                            <div class="bg-slate-50 dark:bg-gray-700  rounded-lg p-4 border border-slate-200">
                                <p class="text-text-white text-xs font-semibold mb-2">{{ __('UPDATED_AT') }}
                                </p>
                                <p class="text-slate-400 text-lg font-bold">{{ $data->updated_at }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
