<div>
    {{-- Page Header --}}

    <div class="bg-bg-secondary w-full rounded">
        <div class="mx-auto">
            <div class="glass-card rounded-2xl p-4 lg:p-6 mb-6">
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                    <h2 class="text-xl lg:text-2xl font-bold text-text-black dark:text-text-white">
                        {{ __('Game Category Details') }}
                    </h2>
                    <div class="flex items-center gap-2 w-full sm:w-auto">
                        <x-ui.button href="{{ route('admin.gm.category.index') }}" class="w-auto py-2!">
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
                <div class="px-6 py-10">
                    <div class="space-y-10">
                        <!-- Profile + Status Section -->
                        <div class="flex flex-col lg:flex-row items-center lg:items-start gap-10">
                            <!-- Profile Image -->
                            <div
                                class="rounded-2xl bg-slate-50 dark:bg-gray-700 p-6 border border-slate-200 shadow-md flex-shrink-0">
                                <img class="w-48 h-48 rounded-full mx-auto mb-4 border-4 border-pink-200 object-cover"
                                    src="https://plus.unsplash.com/premium_photo-1664474619075-644dd191935f?ixlib=rb-4.1.0&amp;ixid=M3wxMjA3fDB8MHxzZWFyY2h8MXx8aW1hZ2V8ZW58MHx8MHx8fDA%3D&amp;fm=jpg&amp;q=60&amp;w=3000&amp;h=2000"
                                    alt="Profile">
                            </div>
                            <!-- Info Cards -->
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 w-full">
                                <div
                                    class="bg-slate-50 dark:bg-gray-700 rounded-2xl p-6 border border-slate-200 shadow-md ">
                                    <p class="text-text-white text-xs font-semibold mb-2">{{ __('NAME') }}</p>
                                    <p class="text-slate-400 text-lg font-bold ">{{ $data->name }}</p>
                                </div>

                                <div
                                    class="bg-slate-50 dark:bg-gray-700 rounded-2xl p-6 border border-slate-200 shadow-md ">
                                    <p class="text-text-white text-xs font-semibold mb-2">{{ __('SLUG') }}</p>
                                    <p class="text-slate-400 text-lg font-bold">{{ $data->slug }}</p>
                                </div>

                                <div
                                    class="bg-slate-50 dark:bg-gray-700 rounded-2xl p-6 border border-slate-200 shadow-md ">
                                    <p class="text-text-white text-xs font-semibold mb-2">{{ __('STATUS') }}</p>
                                    <p class="text-slate-400 text-lg font-bold">{{ $data->status ?? 'N/A' }}</p>
                                </div>

                                <div
                                    class="bg-slate-50 dark:bg-gray-700 rounded-2xl p-6 border border-slate-200 shadow-md">
                                    <p class="text-text-white text-xs font-semibold mb-2">{{ __('DESCRIPTION') }}</p>
                                    <p class="text-slate-400 text-lg font-bold">{{ $data->description ?? 'N/A' }}</p>
                                </div>
                                
                                <div
                                    class="bg-slate-50 dark:bg-gray-700 rounded-2xl p-6 border border-slate-200 shadow-md">
                                    <p class="text-text-white text-xs font-semibold mb-2">{{ __('META TITLE') }}</p>
                                    <p class="text-slate-400 text-lg font-bold">{{ $data->meta_title }}</p>
                                </div>

                                <div
                                    class="bg-slate-50 dark:bg-gray-700 rounded-2xl p-6 border border-slate-200 shadow-md">
                                    <p class="text-text-white text-xs font-semibold mb-2">{{ __('META DESCRIPTION') }}
                                    </p>
                                    <p class="text-slate-400 text-lg font-bold">{{ $data->meta_description ?? 'N/A' }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Data Grid Section -->
                          <div class="grid grid-cols-1 sm:grid-cols-4 gap-4 w-full">

                            <div
                                class="bg-slate-50 dark:bg-gray-700 rounded-2xl p-6 border border-slate-200 shadow-md ">
                                <p class="text-text-white text-xs font-semibold mb-2">{{ __('CREATED BY') }}</p>
                                <p class="text-slate-400 text-lg font-bold">{{ $data->created_at_formatted }}</p>
                            </div>

                            <div
                                class="bg-slate-50 dark:bg-gray-700 rounded-2xl p-6 border border-slate-200 shadow-md ">
                                <p class="text-text-white text-xs font-semibold mb-2">{{ __('IS FEATURED') }}</p>
                                <p class="text-slate-400 text-lg font-bold">{{ $data->is_featured === 1 ? 'Yes' : 'No' }}</p>
                            </div>

                            <div
                                class="bg-slate-50 dark:bg-gray-700 rounded-2xl p-6 border border-slate-200 shadow-md ">
                                <p class="text-text-white text-xs font-semibold mb-2">{{ __('CREATED AT') }}</p>
                                <p class="text-slate-400 text-lg font-bold break-all">{{ $data->created_at_formatted }}
                                </p>
                            </div>

                            <div
                                class="bg-slate-50 dark:bg-gray-700 rounded-2xl p-6 border border-slate-200 shadow-md ">
                                <p class="text-text-white text-xs font-semibold mb-2">{{ __('UPDATED AT') }}</p>
                                <p class="text-slate-400 text-lg font-bold">{{ $data->updated_at_formatted }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
