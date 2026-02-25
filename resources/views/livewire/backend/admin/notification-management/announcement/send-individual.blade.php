<div x-data="{ open: false }" @individual-announcement-modal-show.window="open = true"
    @individual-announcement-modal-close.window="open = false; $wire.call('resetForm')"
    @keydown.escape.window="if(open) { open = false; $wire.call('resetForm'); }">

    <!-- Overlay -->
    <div x-show="open" x-cloak x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
        @click="open = false; $wire.call('resetForm')" class="fixed inset-0 z-50 bg-black/60 backdrop-blur-sm"></div>

    <!-- Modal -->
    <div x-show="open" x-cloak x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95" class="fixed inset-0 z-50 flex items-center justify-center p-4">

        <div @click.stop
            class="bg-white dark:bg-gray-900 rounded-2xl shadow-2xl max-w-2xl w-full relative overflow-hidden max-h-[90vh] flex flex-col">

            <!-- Header with gradient -->
            <div class="bg-linear-to-r from-primary to-accent px-8 py-6 relative shrink-0">
                <button @click="open = false; $wire.call('resetForm')"
                    class="absolute top-4 right-4 text-white/80 hover:text-white text-2xl transition p-2 rounded-lg glass-card">
                    <flux:icon name="x-mark" class="w-6 h-6 stroke-current" />
                </button>
                <h2 class="text-2xl font-bold text-white flex items-center gap-3">
                    <span
                        class="bg-linear-to-r from-zinc-900 to-zinc-800 flex items-center justify-center p-2 rounded-xl">
                        <flux:icon name="user-plus" class="w-7 h-7 stroke-white" />
                    </span>
                    {{ __('Send Individual Announcement') }}
                </h2>
            </div>

            <!-- Content - Scrollable -->
            <div class="p-6 overflow-y-auto flex-1">

                {{-- ─── Step 1: Choose Admin or User ─────────────────────────────────── --}}
                @if ($step === 1)
                    <p class="text-zinc-600 dark:text-zinc-400 mb-6">
                        {{ __('Choose who will receive this announcement.') }}
                    </p>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                        {{-- Admin card --}}
                        <div x-data="{ loading: false }" class="relative">
                            <button type="button"
                                @click="loading = true"
                                wire:click="setRecipientTypeAdmin"
                                wire:loading.attr="disabled"
                                :disabled="loading"
                                class="group w-full relative flex flex-col items-center justify-center p-8 rounded-2xl border-2 border-zinc-200 dark:border-zinc-700 hover:border-primary hover:bg-primary/5 dark:hover:bg-primary/10 transition-all duration-200 text-left">

                                {{-- Icon (hidden while loading) --}}
                                <span :class="loading ? 'opacity-0' : 'opacity-100'"
                                    class="flex items-center justify-center w-16 h-16 rounded-xl bg-primary/10 text-primary mb-4 group-hover:scale-110 transition-all">
                                    <flux:icon name="shield-check" class="w-8 h-8 stroke-current" />
                                </span>

                                {{-- Spinner (shown while loading) --}}
                                <span x-show="loading"
                                    class="absolute inset-0 flex items-center justify-center rounded-2xl bg-white/70 dark:bg-gray-900/70 z-10">
                                    <svg class="animate-spin h-7 w-7 text-primary" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                </span>

                                <span :class="loading ? 'opacity-0' : 'opacity-100'" class="text-lg font-semibold text-zinc-900 dark:text-white transition-opacity">{{ __('Admin') }}</span>
                                <span :class="loading ? 'opacity-0' : 'opacity-100'" class="text-sm text-zinc-500 dark:text-zinc-400 mt-1 transition-opacity">{{ __('Send to an administrator') }}</span>
                            </button>
                        </div>

                        {{-- User card --}}
                        <div x-data="{ loading: false }" class="relative">
                            <button type="button"
                                @click="loading = true"
                                wire:click="setRecipientTypeUser"
                                wire:loading.attr="disabled"
                                :disabled="loading"
                                class="group w-full relative flex flex-col items-center justify-center p-8 rounded-2xl border-2 border-zinc-200 dark:border-zinc-700 hover:border-accent hover:bg-accent/5 dark:hover:bg-accent/10 transition-all duration-200 text-left">

                                {{-- Icon (hidden while loading) --}}
                                <span :class="loading ? 'opacity-0' : 'opacity-100'"
                                    class="flex items-center justify-center w-16 h-16 rounded-xl bg-accent/10 text-accent mb-4 group-hover:scale-110 transition-all">
                                    <flux:icon name="user" class="w-8 h-8 stroke-current" />
                                </span>

                                {{-- Spinner (shown while loading) --}}
                                <span x-show="loading"
                                    class="absolute inset-0 flex items-center justify-center rounded-2xl bg-white/70 dark:bg-gray-900/70 z-10">
                                    <svg class="animate-spin h-7 w-7 text-accent" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                </span>

                                <span :class="loading ? 'opacity-0' : 'opacity-100'" class="text-lg font-semibold text-zinc-900 dark:text-white transition-opacity">{{ __('User') }}</span>
                                <span :class="loading ? 'opacity-0' : 'opacity-100'" class="text-sm text-zinc-500 dark:text-zinc-400 mt-1 transition-opacity">{{ __('Send to a platform user') }}</span>
                            </button>
                        </div>

                    </div>
                @endif

                {{-- ─── Step 2: Search and select recipient ──────────────────────────── --}}
                @if ($step === 2)
                    {{-- Alpine state: track which row was clicked --}}
                    <div x-data="{ selectingId: null }" class="space-y-4">

                        <div class="flex items-center justify-between gap-4">
                            <x-ui.label value="{{ __('Select recipient') }}" class="mb-0" />
                            <x-ui.button type="button" variant="tertiary" class="w-auto! py-1!"
                                wire:click="backToStepOne">
                                <flux:icon name="arrow-path" wire:loading wire:target="backToStepOne"
                                    class="w-4 h-4 stroke-text-btn-primary group-hover:stroke-text-btn-tertiary animate-spin" />
                                <flux:icon name="arrow-left" wire:loading.remove wire:target="backToStepOne"
                                    class="w-4 h-4 stroke-text-btn-primary group-hover:stroke-text-btn-tertiary" />
                                <span wire:loading.remove wire:target="backToStepOne"
                                    class="text-text-btn-primary group-hover:text-text-btn-tertiary">{{ __('Back') }}</span>
                                <span wire:loading wire:target="backToStepOne"
                                    class="text-text-btn-primary group-hover:text-text-btn-tertiary">{{ __('Backing...') }}</span>
                            </x-ui.button>
                        </div>

                        {{-- Search input --}}
                        <div class="relative">
                            <x-ui.input type="text"
                                placeholder="{{ $recipientType === 'admin' ? __('Search admins by name or email...') : __('Search users by name, username or email...') }}"
                                wire:model.live.debounce.300ms="recipientSearch"
                                class="w-full pr-10" />

                            {{-- Animated search icon while typing/loading --}}
                            <div class="pointer-events-none absolute inset-y-0 right-3 flex items-center">
                                <svg wire:loading wire:target="recipientSearch"
                                    class="animate-spin h-4 w-4 text-primary"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                <flux:icon wire:loading.remove wire:target="recipientSearch"
                                    name="magnifying-glass" class="w-4 h-4 text-zinc-400 stroke-current" />
                            </div>
                        </div>

                        <x-ui.input-error :messages="$errors->get('receiver')" />

                        {{-- Results list --}}
                        <div class="border border-zinc-200 dark:border-zinc-700 rounded-xl overflow-hidden max-h-80 overflow-y-auto">

                            {{-- Skeleton rows — shown while searching --}}
                            <div wire:loading wire:target="recipientSearch" class="divide-y divide-zinc-100 dark:divide-zinc-800 w-full">
                                @foreach(range(1, 4) as $skeleton)
                                    <div class="flex items-center gap-3 px-4 py-3 animate-pulse ">
                                        <div class="shrink-0 w-10 h-10 rounded-full bg-zinc-200 dark:bg-zinc-700"></div>
                                        <div class="flex-1 space-y-2">
                                            <div class="h-3.5 bg-zinc-200 dark:bg-zinc-700 rounded w-2/5"></div>
                                            <div class="h-3 bg-zinc-100 dark:bg-zinc-800 rounded w-3/5"></div>
                                        </div>
                                        <div class="w-4 h-4 bg-zinc-100 dark:bg-zinc-800 rounded shrink-0"></div>
                                    </div>
                                @endforeach
                            </div>

                            {{-- Actual results (hidden while skeleton is showing) --}}
                            <div wire:loading.remove wire:target="recipientSearch">
                                @forelse ($recipients as $item)
                                    @php
                                        $itemId = $item->getKey();
                                        $name =
                                            $item->full_name ??
                                            trim(($item->first_name ?? '') . ' ' . ($item->last_name ?? '')) ?:
                                            $item->email ?? (string) $itemId;
                                        $sub = $item->email ?? ($item->phone ?? '');
                                    @endphp

                                    {{--
                                        Per-row loading:
                                        - @click sets selectingId to this row's id (Alpine only)
                                        - The overlay uses x-show="selectingId === id" — no wire:loading, so it
                                          won't bleed into other rows
                                    --}}
                                    <div class="relative border-b border-zinc-100 dark:border-zinc-800 last:border-b-0">

                                        <button type="button"
                                            @click="selectingId = {{ $itemId }}"
                                            wire:click="selectRecipient({{ $itemId }}, '{{ $recipientType }}')"
                                            wire:loading.attr="disabled"
                                            :disabled="selectingId !== null"
                                            class="w-full flex items-center gap-3 px-4 py-3 text-left hover:bg-zinc-100 dark:hover:bg-zinc-800/80 transition-colors"
                                            :class="selectingId !== null && selectingId !== {{ $itemId }} ? 'opacity-40' : ''">

                                            <span class="shrink-0 w-10 h-10 rounded-full bg-primary/10 text-primary flex items-center justify-center">
                                                <flux:icon name="user" class="w-5 h-5 stroke-current" />
                                            </span>
                                            <div class="min-w-0 flex-1">
                                                <span class="block font-medium text-zinc-900 dark:text-white truncate">{{ $name }}</span>
                                                @if ($sub)
                                                    <span class="block text-sm text-zinc-500 dark:text-zinc-400 truncate">{{ $sub }}</span>
                                                @endif
                                            </div>

                                            {{-- Arrow → spinner swap, scoped to this row --}}
                                            <flux:icon name="chevron-right"
                                                x-show="selectingId !== {{ $itemId }}"
                                                class="w-5 h-5 text-zinc-400 shrink-0" />

                                            <svg x-show="selectingId === {{ $itemId }}"
                                                x-cloak
                                                class="animate-spin h-5 w-5 text-primary shrink-0"
                                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                            </svg>
                                        </button>

                                    </div>
                                @empty
                                    <div class="px-4 py-8 text-center text-zinc-500 dark:text-zinc-400">
                                        <flux:icon name="magnifying-glass" class="w-10 h-10 mx-auto mb-2 opacity-50" />
                                        <p>{{ $recipientSearch !== '' ? __('No results found.') : __('Type to search.') }}</p>
                                    </div>
                                @endforelse
                            </div>

                        </div>
                    </div>
                @endif

                {{-- ─── Step 3: Announcement form ────────────────────────────────────── --}}
                @if ($step === 3)
                    <div class="space-y-4">
                        <div class="flex items-center justify-between gap-4 mb-4">
                            <p class="text-zinc-600 dark:text-zinc-400">
                                {{ __('Sending to') }}: <strong class="text-zinc-900 dark:text-white">{{ $receiver_name }}</strong>
                            </p>
                            <x-ui.button type="button" variant="tertiary" class="w-auto! py-1!"
                                wire:click="backToStepTwo">
                                <flux:icon name="arrow-path" wire:loading wire:target="backToStepTwo"
                                    class="w-4 h-4 stroke-text-btn-primary group-hover:stroke-text-btn-tertiary animate-spin" />
                                <flux:icon name="arrow-left" wire:loading.remove wire:target="backToStepTwo"
                                    class="w-4 h-4 stroke-text-btn-primary group-hover:stroke-text-btn-tertiary" />
                                <span wire:loading.remove wire:target="backToStepTwo"
                                    class="text-text-btn-primary group-hover:text-text-btn-tertiary">{{ __('Change recipient') }}</span>
                                <span wire:loading wire:target="backToStepTwo"
                                    class="text-text-btn-primary group-hover:text-text-btn-tertiary">{{ __('Changing recipient...') }}</span>
                            </x-ui.button>
                        </div>

                        <form wire:submit="save" class="space-y-4">
                            <div>
                                <x-ui.label value="Redirect / Action Url (Optional)" class="mb-1" />
                                <x-ui.input placeholder="https://example.com" wire:model="form.action" type="url" />
                                <x-ui.input-error :messages="$errors->get('form.action')" />
                            </div>
                            <div>
                                <x-ui.label value="Title" class="mb-1" />
                                <x-ui.input type="text" placeholder="{{ __('Title') }}" wire:model="form.title" />
                                <x-ui.input-error :messages="$errors->get('form.title')" />
                            </div>
                            <div>
                                <x-ui.label value="Message" class="mb-1" />
                                <x-ui.textarea placeholder="{{ __('Message') }}" wire:model="form.message" rows="4" />
                                <x-ui.input-error :messages="$errors->get('form.message')" />
                            </div>

                            <div class="flex items-center justify-end gap-4 pt-4 border-t">
                                <x-ui.button type="button" wire:click="resetForm" variant="tertiary" class="w-auto! py-2!">
                                    <flux:icon name="x-circle"
                                        class="w-4 h-4 stroke-text-btn-primary group-hover:stroke-text-btn-tertiary" />
                                    <span wire:loading.remove wire:target="resetForm"
                                        class="text-text-btn-primary group-hover:text-text-btn-tertiary">{{ __('Reset') }}</span>
                                    <span wire:loading wire:target="resetForm"
                                        class="text-text-btn-primary group-hover:text-text-btn-tertiary">{{ __('Resetting...') }}</span>
                                </x-ui.button>
                                <x-ui.button class="w-auto! py-2!" type="submit">
                                    <flux:icon name="paper-airplane"
                                        class="w-4 h-4 stroke-text-btn-primary group-hover:stroke-text-btn-secondary"
                                        wire:loading.remove wire:target="save" />
                                    <span wire:loading.remove wire:target="save"
                                        class="text-text-btn-primary group-hover:text-text-btn-secondary">{{ __('Send') }}</span>
                                    <span wire:loading wire:target="save"
                                        class="text-text-btn-primary group-hover:text-text-btn-secondary inline-flex items-center gap-1">
                                        <svg class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                        {{ __('Sending...') }}
                                    </span>
                                </x-ui.button>
                            </div>
                        </form>
                    </div>
                @endif

            </div>
        </div>
    </div>

    <style>
        [x-cloak] { display: none !important; }
    </style>
</div>