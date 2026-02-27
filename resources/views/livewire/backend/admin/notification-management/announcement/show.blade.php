<div x-data="{
    modalShow: @entangle('announcementDetailModalShow').live,
    loading: @entangle('isLoading').live,
    hasData: @entangle('hasData').live,
}"
    @announcement-detail-modal-open.window="
    modalShow = true;
    loading = true;
    hasData = false;
">
    {{-- Overlay --}}
    <div x-show="modalShow" x-transition.opacity @click="modalShow = false; $wire.closeModal()"
        class="fixed inset-0 z-40 bg-black/60 backdrop-blur-sm" style="display: none;">
    </div>

    {{-- Modal --}}
    <div x-show="modalShow" x-transition x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4"
        style="display: none;">

        <div @click.stop
            class="bg-main w-full max-w-3xl rounded-2xl shadow-2xl border border-white/10 flex flex-col overflow-hidden">

            {{-- ── FIXED HEADER ── --}}
            <div class="flex items-center justify-between px-5 sm:px-7 py-4 border-b border-white/10 shrink-0">
                <div class="flex items-center gap-3">
                    <span
                        class="w-9 h-9 rounded-xl glass-card flex items-center justify-center shadow-shadow-primary shrink-0">
                        <flux:icon name="megaphone" class="w-5 h-5 text-pink-400" />
                    </span>
                    <div>
                        <h2 class="text-base sm:text-lg font-bold text-text-white leading-tight">
                            {{ __('Announcement Details') }}
                        </h2>
                        <p class="text-xs text-text-muted">{{ __('View full announcement information') }}</p>
                    </div>
                </div>
                <button wire:click="closeModal" @click="modalShow = false"
                    class="text-text-muted hover:text-text-white hover:bg-white/10 p-2 rounded-lg transition-all duration-200 shrink-0">
                    <flux:icon name="x-mark" class="w-5 h-5" />
                </button>
            </div>

            {{-- ── BODY ── --}}
            <div class="overflow-y-auto max-h-[80vh]">

                {{-- LOADING --}}
                <div x-show="loading" x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                    class="flex flex-col items-center justify-center gap-5 py-16 px-8">
                    <div class="relative w-14 h-14">
                        <div class="absolute inset-0 rounded-full border-4 border-white/10"></div>
                        <div
                            class="absolute inset-0 rounded-full border-4 border-t-transparent border-l-transparent border-r-zinc-400 border-b-zinc-200 animate-spin">
                        </div>
                    </div>
                    <div class="text-center space-y-1">
                        <p class="text-text-white font-semibold tracking-wide">{{ __('Loading announcement details') }}
                        </p>
                        <p class="text-text-muted text-sm animate-pulse">{{ __('Please wait a moment…') }}</p>
                    </div>
                </div>

                {{-- NOT FOUND --}}
                <div x-show="!loading && !hasData" x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                    class="flex flex-col items-center justify-center text-center gap-4 py-16 px-8">
                    <div
                        class="w-14 h-14 bg-bg-info rounded-full flex items-center justify-center border border-zinc-700">
                        <flux:icon name="triangle-alert" class="w-7 h-7 text-pink-500" />
                    </div>
                    <div class="space-y-1.5">
                        <h3 class="text-lg font-bold text-text-white">{{ __('Announcement Not Found') }}</h3>
                        <p class="text-sm text-text-secondary max-w-sm">
                            {{ __('The announcement you are looking for does not exist or may have been removed.') }}
                        </p>
                    </div>
                </div>

                {{-- DATA --}}
                @if ($data)
                    @php
                        $notification = $data;
                        $payload = $notification->data ?? [];
                        $additional = $notification->additional ?? [];
                    @endphp

                    <div x-show="!loading && hasData" x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                        class="p-5 sm:p-7 space-y-5">

                        {{-- Meta badges --}}
                        <div class="flex flex-wrap items-center gap-2">
                            <span
                                class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-bg-info text-pink-400 border border-zinc-700 text-xs font-medium">
                                <flux:icon name="tag" class="w-3.5 h-3.5" />
                                {{ ucfirst($notification->type->value ?? 'announcement') }}
                            </span>
                            <span
                                class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-bg-secondary border border-zinc-700 text-xs text-text-secondary">
                                <flux:icon name="clock" class="w-3.5 h-3.5" />
                                {{ optional($notification->created_at)->diffForHumans() }}
                            </span>
                            @if ($notification->action)
                                <div class="ml-auto">
                                    <x-ui.button variant="primary" href="{{ $notification->action }}" target="_blank"
                                        rel="noopener noreferrer"
                                        class="hidden sm:inline-flex w-auto! py-1.5! px-3! rounded-lg items-center gap-1.5 text-sm">
                                        <span
                                            class="text-text-btn-primary group-hover:text-text-btn-secondary">{{ __('Open Link') }}</span>
                                        <flux:icon name="arrow-up-right"
                                            class="w-3.5 h-3.5 stroke-text-btn-primary group-hover:stroke-text-btn-secondary" />
                                    </x-ui.button>
                                </div>
                            @endif
                        </div>

                        {{-- Title + Message --}}
                        <div class="glass-card rounded-2xl p-5 sm:p-6 flex items-start gap-4">
                            <div
                                class="w-11 h-11 rounded-xl glass-card flex items-center justify-center shrink-0 shadow-shadow-primary">
                                <flux:icon name="{{ $payload['icon'] ?? 'megaphone' }}"
                                    class="w-5 h-5 text-pink-400" />
                            </div>
                            <div class="flex-1 min-w-0 space-y-1.5">
                                <h3 class="text-base sm:text-lg font-semibold text-text-white break-words">
                                    {{ $payload['title'] ?? __('Announcement') }}
                                </h3>
                                @if ($payload['message'] ?? false)
                                    <p class="text-sm text-text-secondary leading-relaxed">{{ $payload['message'] }}
                                    </p>
                                @endif
                            </div>
                        </div>

                        {{-- Description --}}
                        @if ($payload['description'] ?? false)
                            <div class="glass-card rounded-2xl p-5 sm:p-6">
                                <h4 class="text-sm font-semibold text-text-white mb-2">{{ __('Description') }}</h4>
                                <p class="text-sm text-text-secondary leading-relaxed break-words">
                                    {{ $payload['description'] }}</p>
                            </div>
                        @endif

                        {{-- Sender / Receiver --}}
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="glass-card rounded-2xl p-5 space-y-2">
                                <h4
                                    class="text-xs font-semibold text-text-muted uppercase tracking-wider flex items-center gap-1.5">
                                    <flux:icon name="user-circle" class="w-3.5 h-3.5" />
                                    {{ __('Sender') }}
                                </h4>
                                <p class="text-sm text-text-white">
                                    <strong>{{ __('Name') }}: </strong>
                                    {{ $notification->sender->name ?? ($notification->sender->full_name ?? __('Unknown')) }}
                                </p>
                                @if ($notification->sender?->role?->name)
                                    <p class="text-sm text-text-secondary">
                                        <strong>{{ __('Role') }}: </strong>
                                        {{ $notification->sender->role->name }}
                                    </p>
                                @endif
                            </div>

                            <div class="glass-card rounded-2xl p-5 space-y-2">
                                <h4
                                    class="text-xs font-semibold text-text-muted uppercase tracking-wider flex items-center gap-1.5">
                                    <flux:icon name="user-group" class="w-3.5 h-3.5" />
                                    {{ __('Receiver') }}
                                </h4>
                                @if ($notification->receiver)
                                    <div class="space-y-1">
                                        <p class="text-sm text-text-white">
                                            <strong>{{ __('Name') }}: </strong>
                                            {{ $notification?->receiver?->name ?? ($notification?->receiver?->full_name ?? __('Unknown')) }}
                                        </p>
                                        @if ($notification->receiver?->role?->name)
                                            <p class="text-sm text-text-secondary">
                                                <strong>{{ __('Role') }}: </strong>
                                                {{ $notification?->receiver?->role?->name ?? __('Unknown') }}
                                            </p>
                                        @elseif($notification->receiver?->username)
                                            <p class="text-sm text-text-secondary">
                                                <strong>{{ __('Username') }}: </strong>
                                                {{ $notification?->receiver?->username ?? __('Unknown') }}
                                            </p>
                                        @endif
                                    </div>
                                @else
                                    <p class="text-sm text-text-secondary">
                                        {{ __('Broadcast to all applicable recipients') }}</p>
                                @endif
                            </div>
                        </div>

                        {{-- Additional Info --}}
                        @if (!empty($additional) && is_array($additional))
                            <div class="glass-card rounded-2xl p-5 sm:p-6">
                                <h4 class="text-sm font-semibold text-text-white mb-3">
                                    {{ __('Additional Information') }}</h4>
                                <div>
                                    @foreach ($additional as $key => $value)
                                        <div
                                            class="grid grid-cols-3 gap-4 py-2.5 {{ !$loop->last ? 'border-b border-zinc-700/50' : '' }}">
                                            <p class="col-span-1 text-xs font-medium text-text-muted">
                                                {{ ucfirst(str_replace('_', ' ', (string) $key)) }}
                                            </p>
                                            <p class="col-span-2 text-sm text-text-white wrap-break-word">
                                                {{ is_array($value) ? json_encode($value) : (string) $value }}
                                            </p>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        {{-- Action Button --}}
                        @if ($notification->action)
                            <div class="flex justify-end pt-1 pb-2">
                                <x-ui.button variant="primary" href="{{ $notification->action }}" target="_blank"
                                    rel="noopener noreferrer"
                                    class="w-full sm:w-auto! py-2.5! rounded-lg justify-center flex items-center gap-2">
                                    <span
                                        class="text-text-btn-primary group-hover:text-text-btn-secondary">{{ __('Open Related Page') }}</span>
                                    <flux:icon name="arrow-up-right"
                                        class="w-4 h-4 stroke-text-btn-primary group-hover:stroke-text-btn-secondary" />
                                </x-ui.button>
                            </div>
                        @endif

                    </div>
                @endif

            </div>{{-- end body --}}
        </div>{{-- end card --}}
    </div>{{-- end modal --}}
</div>
