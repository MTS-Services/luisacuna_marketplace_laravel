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

                                {{ $data->requires_delivery_time }} </p>
                        </div>

                        <div>
                            <p class="dark:text-slate-400 text-sm font-semibold mb-1">{{ __('URL') }}</p>
                            <p
                                class="font-mono text-sm bg-white px-3 py-2 rounded border dark:bg-gray-700 border-slate-200 truncate">
                                {{ $data->description }}</p>
                        </div>

                        <div>
                            <p class="dark:text-slate-400 text-sm font-semibold mb-1">{{ __('AUDIT BY') }}</p>
                            <p class=" text-sm bg-white px-3 py-2 rounded dark:bg-gray-700  border border-slate-200">
                                {{ $data->icon }}
                            </p>
                        </div>

                        <div>
                            <p class="dark:text-slate-400 text-sm font-semibold mb-1">{{ __('AUDIT DATE') }}</p>
                            <p
                                class=" font-mono text-sm bg-white dark:bg-gray-700  px-3 py-2 rounded border border-slate-200">
                                {{ $data->requires_delivery_time }}</p>

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

            {{-- Restored Date --}}
            <div class="col-span-1">
                <p class="text-gray-500 dark:text-gray-400">{{ __('Restored Date') }}</p>
                <p class="font-mono font-semibold text-gray-900 dark:text-white uppercase">
                    {{ $data->restored_at_formatted ?? 'N/A' }}
                </p>
            </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                            <div class="bg-slate-50 dark:bg-gray-700 rounded-lg p-4 border border-slate-200">
                                <p class="text-text-white text-xs font-semibold mb-2">{{ __('Name') }}</p>
                                 
                                <p class="text-slate-400 text-lg font-bold">{{ $data->name }}</p>
                            </div>

                            <div class="bg-slate-50 dark:bg-gray-700  rounded-lg p-4 border border-slate-200">
                                <p class="text-text-white text-xs font-semibold mb-2">{{ __('SLUG') }}</p>
                                <p class="text-slate-400 text-lg font-bold">{{ $data->slug }}</p>

                            </div>

                            <div class="bg-slate-50 dark:bg-gray-700  rounded-lg p-4 border border-slate-200">
                                <p class="text-text-white text-xs font-semibold mb-2">{{ __('CREATED_AT') }}</p>
                                <p class="text-slate-400 text-lg font-bold">{{ $data->created_at }}</p>
                            </div>

                            <div class="bg-slate-50 dark:bg-gray-700  rounded-lg p-4 border border-slate-200">
                                <p class="text-text-white text-xs font-semibold mb-2">{{ __('DESCRIPTION') }}
                                </p>
                                <p class="text-slate-400 text-lg font-bold">{{ $data->description }}</p>
                            </div>
                            <div class="bg-slate-50 dark:bg-gray-700  rounded-lg p-4 border border-slate-200">
                                <p class="text-text-white text-xs font-semibold mb-2">{{ __('ICON') }}
                                </p>
                                <p class="text-slate-400 text-lg font-bold">{{ $data->icon }}</p>
                            </div>
                            <div class="bg-slate-50 dark:bg-gray-700  rounded-lg p-4 border border-slate-200">
                                <p class="text-text-white text-xs font-semibold mb-2">{{ __('REQUIRES DELIVERY TIME') }}
                                </p>
                                <p class="text-slate-400 text-lg font-bold">{{ $data->requires_delivery_time }}</p>
                            </div>
                            <div class="bg-slate-50 dark:bg-gray-700  rounded-lg p-4 border border-slate-200">
                                <p class="text-text-white text-xs font-semibold mb-2">{{ __('REQUIRES SERVER INFO') }}
                                </p>
                                <p class="text-slate-400 text-lg font-bold">{{ $data->requires_server_info }}</p>
                            </div>
                            <div class="bg-slate-50 dark:bg-gray-700  rounded-lg p-4 border border-slate-200">
                                <p class="text-text-white text-xs font-semibold mb-2">{{ __('REQUIRES CHARACTER INFO') }}
                                </p>
                                <p class="text-slate-400 text-lg font-bold">{{ $data->requires_character_info }}</p>
                            </div>
                            <div class="bg-slate-50 dark:bg-gray-700  rounded-lg p-4 border border-slate-200">
                                <p class="text-text-white text-xs font-semibold mb-2">{{ __('MAX DELIVERY TIME') }}
                                </p>
                                <p class="text-slate-400 text-lg font-bold">{{ $data->max_delivery_time_hours }}</p>
                            </div>
                            <div class="bg-slate-50 dark:bg-gray-700  rounded-lg p-4 border border-slate-200">
                                <p class="text-text-white text-xs font-semibold mb-2">{{ __('COMMISSION RATE') }}
                                </p>
                                <p class="text-slate-400 text-lg font-bold">{{ $data->commission_rate }}</p>
                            </div>
                            <div class="bg-slate-50 dark:bg-gray-700  rounded-lg p-4 border border-slate-200">
                                <p class="text-text-white text-xs font-semibold mb-2">{{ __('Status') }}
                                </p>
                                <p class="text-slate-400 text-lg font-bold">{{ $data->status }}</p>
                            </div>
                            <div class="bg-slate-50 dark:bg-gray-700  rounded-lg p-4 border border-slate-200">
                                <p class="text-text-white text-xs font-semibold mb-2">{{ __('CREATED AT') }}
                                </p>
                                <p class="text-slate-400 text-lg font-bold">{{ $data->created_at }}</p>
                            </div>
                            <div class="bg-slate-50 dark:bg-gray-700  rounded-lg p-4 border border-slate-200">
                                <p class="text-text-white text-xs font-semibold mb-2">{{ __('UPDATED AT') }}
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
