<section>
    {{-- Page Header --}}
    <div class="glass-card rounded-2xl p-4 lg:p-6 mb-6">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <h2 class="text-xl lg:text-2xl font-bold text-text-black dark:text-text-white">
                {{ __('Feedback List') }}
            </h2>
            <div class="flex items-center gap-2 w-full sm:w-auto">
                <x-ui.button href="{{ route('admin.um.user.create') }}" class="w-auto py-2!">
                    <flux:icon name="user-plus"
                        class="w-4 h-4 stroke-text-btn-primary group-hover:stroke-text-btn-secondary" />
                    {{ __('Back') }}
                </x-ui.button>
            </div>
        </div>
    </div>

    {{-- Table Component --}}
    <x-ui.table :data="$datas" :columns="$columns" :actions="$actions" :types="$types" :selectedIds="$selectedIds"
        :mobileVisibleColumns="2" searchProperty="search" perPageProperty="perPage" :showBulkActions="false"
        emptyMessage="No users found. Create your first user to get started." />

    <div x-data="{ show: @entangle('showModal') }" x-show="show" x-cloak @keydown.escape.window="show = false"
        class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">

        {{-- Backdrop: Slightly darker for better focus --}}
        <div x-show="show" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" @click="$wire.closeModal()"
            class="fixed inset-0 bg-slate-900/60 backdrop-blur-md">
        </div>

        {{-- Modal Content --}}
        <div class="flex min-h-screen items-center justify-center p-4">
            <div x-show="show" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" @click.stop
                class="relative w-full max-w-5xl bg-white dark:bg-gray-900/50 rounded-2xl shadow-2xl border border-zinc-200 dark:border-zinc-800 overflow-hidden">

                {{-- Header: Added subtle border and better padding --}}
                <div class="flex items-center justify-between px-6 py-4 border-b border-zinc-100 dark:border-zinc-800">
                    <h3 class="text-lg font-semibold text-text-white tracking-tight">
                        {{ __('Feedback Details') }}
                    </h3>
                    <button @click="$wire.closeModal()"
                        class="p-2 rounded-full text-zinc-300 hover:bg-zinc-100 dark:hover:bg-zinc-800 hover:text-zinc-600 dark:hover:text-zinc-200 transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                {{-- Body --}}
                <div class="p-6">
                    @if ($selectedFeedback)
                        <div class="space-y-6">
                            <div>
                                <p class="text-text-white">{{ __('Order ID:') }} {{ $selectedFeedback->order->order_id }}</p>
                            </div>
                            <div class="flex items-center gap-2">
                                <p class="text-text-white">{{ __('Sender:') }}</p>
                                <a href="{{ route('profile', ['username' => $selectedFeedback->author->username]) }}"
                                    target="_blank"
                                    class="text-zinc-500 text-xs xxs:text-sm md:text-base truncate">{{ $selectedFeedback->author->username }}</a>
                            </div>
                            <div class="flex items-center gap-2">
                                <p>{{ __('Type:') }}</p>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full border-0 text-xs font-medium badge badge-soft {{ $selectedFeedback->type->color() }}">{{ $selectedFeedback->type->label() }}</span>
                            </div>
                            <div>
                                <label
                                    class="block text-xs font-bold uppercase tracking-wider text-zinc-500 dark:text-zinc-400 mb-2">
                                    {{ __('Message Content') }}
                                </label>
                                <div
                                    class="bg-white dark:bg-gray-900/50 rounded-xl border border-zinc-100 dark:border-zinc-700/50 p-5">
                                    <p class="text-text-white leading-relaxed text-sm">
                                        {{ $selectedFeedback->message }}
                                    </p>
                                </div>
                            </div>

                        </div>
                    @else
                        <div class="flex flex-col items-center justify-center py-10 text-zinc-400">
                            <p>{{ __('No feedback selected.') }}</p>
                        </div>
                    @endif
                </div>

                {{-- Footer: Clean and simple --}}
                <div
                    class="px-6 py-4 bg-white dark:bg-gray-900/50 border-t border-zinc-100 dark:border-zinc-800 flex justify-end">
                    <button @click="$wire.closeModal()"
                        class="px-5 py-2 text-sm font-medium text-text-white hover:bg-zinc-100 dark:hover:bg-gray-800 rounded-lg transition-colors border border-zinc-200 dark:border-zinc-700">
                        {{ __('Close') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>
