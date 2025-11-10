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
                        <x-ui.button href="{{ route('admin.gm.game.index') }}" class="w-auto py-2!">
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
                        <h2 class="text-lg font-bold text-text-secondary mb-6 flex items-center">
                            <span class="w-2 h-2 bg-amber-500 rounded-full mr-3"></span>
                            {{ __('Previous Values') }}
                        </h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                            <div class="bg-slate-50 dark:bg-gray-700 rounded-lg p-4 border border-slate-200">
                                <p class="text-text-white text-xs font-semibold mb-2">{{ __('ID') }}</p>

                                <p class="text-slate-400 text-lg font-bold">{{ $data->id }}</p>
                            </div>

                            <div class="bg-slate-50 dark:bg-gray-700  rounded-lg p-4 border border-slate-200">
                                <p class="text-text-white text-xs font-semibold mb-2">{{ __('USER_ID') }}</p>
                                <p class="text-slate-400 text-lg font-bold">{{ $data->user_id }}</p>
                            </div>

                            <div class="bg-slate-50 dark:bg-gray-700  rounded-lg p-4 border border-slate-200">
                                <p class="text-text-white text-xs font-semibold mb-2">{{ __('CURRENCY_ID') }}</p>
                                <p class="text-slate-400 text-lg font-bold">{{ $data->currency_id }}</p>
                            </div>

                            <div class="bg-slate-50 dark:bg-gray-700  rounded-lg p-4 border border-slate-200">
                                <p class="text-text-white text-xs font-semibold mb-2">{{ __('TOTAL_ORDERS_AS_BUYER') }}
                                </p>
                                <p class="text-slate-400 text-lg font-bold">{{ $data->total_orders_as_buyer }}</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
