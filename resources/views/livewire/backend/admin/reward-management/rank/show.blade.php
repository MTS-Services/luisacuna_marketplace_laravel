<div class="p-4 lg:p-8">
    {{-- Page Header --}}
    <div class="glass-card rounded-2xl p-4 lg:p-6 mb-6">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <h2 class="text-xl lg:text-2xl font-bold text-text-black dark:text-text-white">
                {{ __('Rank Details') }}
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

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        {{-- Left Column: Profile Card (The "Hero" element) --}}
        <div class="lg:col-span-1">
            <div
                class="bg-white dark:bg-gray-900 rounded-[2.5rem] p-10 shadow-[0_20px_50px_rgba(0,0,0,0.05)] border border-gray-100 dark:border-gray-800 flex flex-col items-center text-center sticky top-10">
                <div class="relative mb-8">
                    <div
                        class="w-40 h-40 rounded-[2rem] overflow-hidden bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-800 dark:to-gray-900 flex items-center justify-center border-[6px] border-white dark:border-gray-800 shadow-inner">
                        <img src="{{ storage_url($data->icon) }}" alt="{{ $data->name }}"
                            class="w-28 h-28 object-contain drop-shadow-2xl">
                    </div>
                    <span
                        class="absolute -bottom-1 -right-1 px-4 py-1.5 rounded-2xl text-[10px] font-black uppercase tracking-tighter shadow-lg {{ $data->status === 'active' ? 'bg-emerald-500 text-white' : 'bg-rose-500 text-white' }}">
                        {{ $data->status }}
                    </span>
                </div>

                <h3 class="text-3xl font-black text-gray-900 dark:text-white mb-1">{{ $data->name }}</h3>
                <p class="text-xs font-bold text-primary tracking-[0.2em] uppercase opacity-70 mb-8">{{ $data->slug }}
                </p>

                <div class="w-full grid grid-cols-2 gap-6 p-6 rounded-3xl bg-gray-50 dark:bg-gray-800/50">
                    <div class="text-left border-r border-gray-200 dark:border-gray-700">
                        <p class="text-[10px] uppercase tracking-widest text-gray-400 font-bold mb-1">
                            {{ __('Min Points') }}</p>
                        <p class="text-xl font-black text-gray-800 dark:text-white">
                            {{ number_format($data->minimum_points ?? 0) }}</p>
                    </div>
                    <div class="text-left pl-4">
                        <p class="text-[10px] uppercase tracking-widest text-gray-400 font-bold mb-1">
                            {{ __('Max Points') }}</p>
                        <p class="text-xl font-black text-gray-800 dark:text-white">
                            {{ $data->maximum_points ? number_format($data->maximum_points) : '∞' }}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Right Column: Audit & Logs (Clean & Structured) --}}
        <div class="lg:col-span-2 space-y-8">
            <div
                class="bg-white dark:bg-gray-900 rounded-[2rem] shadow-sm border border-gray-100 dark:border-gray-800 overflow-hidden">
                <div class="px-8 py-6 border-b border-gray-50 dark:border-gray-800 flex items-center gap-3">
                    <div class="w-2 h-6 bg-primary rounded-full"></div>
                    <h4 class="font-bold text-lg text-gray-800 dark:text-white">{{ __('Timeline & Audit Trail') }}</h4>
                </div>

                <div class="p-8 grid grid-cols-1 md:grid-cols-2 gap-10">
                    {{-- Created Info --}}
                    <div class="flex items-start gap-4 group">
                        <div
                            class="p-3 bg-blue-50 dark:bg-blue-500/10 rounded-2xl text-blue-600 transition-colors group-hover:bg-blue-600 group-hover:text-white">
                            <flux:icon name="calendar" class="w-6 h-6" />
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 font-bold uppercase tracking-tighter mb-1">
                                {{ __('Date Created') }}</p>
                            <p class="text-base font-bold text-gray-700 dark:text-gray-200">
                                {{ $data->created_at_formatted ?? 'N/A' }}</p>
                            <p class="text-xs text-gray-400 mt-1 italic">Action by: <span
                                    class="text-blue-500 font-semibold">{{ $data->creater_admin->name ?? 'System' }}</span>
                            </p>
                        </div>
                    </div>

                    {{-- Updated Info --}}
                    <div class="flex items-start gap-4 group">
                        <div
                            class="p-3 bg-amber-50 dark:bg-amber-500/10 rounded-2xl text-amber-600 transition-colors group-hover:bg-amber-600 group-hover:text-white">
                            <flux:icon name="pencil-square" class="w-6 h-6" />
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 font-bold uppercase tracking-tighter mb-1">
                                {{ __('Last Modified') }}</p>
                            <p class="text-base font-bold text-gray-700 dark:text-gray-200">
                                {{ $data->updated_at_formatted ?? 'N/A' }}</p>
                            <p class="text-xs text-gray-400 mt-1 italic">Action by: <span
                                    class="text-amber-500 font-semibold">{{ $data->updater_admin->name ?? 'N/A' }}</span>
                            </p>
                        </div>
                    </div>

                    {{-- Baki Conditional Sections (Delete/Restore) gulao eibhabe update koro --}}
                </div>
            </div>
        </div>
    </div>
</div>
