<section class="space-y-4 sm:space-y-6">
    <div x-transition:enter="transition ease-out duration-100"
        class="bg-bg-secondary backdrop:blur-md z-100 transition-all duration-300 min-h-auto text-text-white shadow-lg p-4 sm:p-6 lg:p-8 rounded-2xl">
        <div class="max-w-4xl mx-auto space-y-6 sm:space-y-8">
            @if (!$notification && !$notFound)
                {{-- Loading State --}}
                <div class="bg-bg-secondary rounded-2xl p-6 sm:p-10 text-center border border-zinc-700">
                    <div class="animate-spin rounded-full h-10 w-10 sm:h-12 sm:w-12 border-4 border-zinc-700 border-t-pink-500 mx-auto mb-4"></div>
                    <p class="text-sm sm:text-base text-text-white font-medium">
                        {{ __('Loading notification details...') }}
                    </p>
                </div>
            @elseif($notFound)
                {{-- Error State --}}
                <div class="bg-bg-secondary rounded-2xl p-6 sm:p-10 text-center border border-zinc-700 space-y-4">
                    <div class="w-14 h-14 sm:w-16 sm:h-16 bg-bg-info rounded-full flex items-center justify-center mx-auto mb-2 border border-zinc-700">
                        <flux:icon name="triangle-alert" class="w-7 h-7 sm:w-8 sm:h-8 text-pink-500" />
                    </div>
                    <h2 class="text-xl sm:text-2xl font-bold text-text-white">
                        {{ __('Notification Not Found') }}
                    </h2>
                    <p class="text-sm sm:text-base text-text-secondary max-w-md mx-auto">
                        {{ __('The notification you\'re looking for does not exist or may have been removed.') }}
                    </p>
                    <div class="pt-4">
                        <a href="{{ route('user.notifications') }}"
                            class="inline-flex items-center justify-center gap-2 w-full sm:w-auto px-6 py-3 rounded-lg bg-pink-500 hover:bg-pink-600 text-white text-sm font-medium transition-colors">
                            <flux:icon name="arrow-left" class="w-4 h-4" />
                            <span>{{ __('Back to notifications') }}</span>
                        </a>
                    </div>
                </div>
            @else
                @php
                    $data = $notification->data ?? [];
                    $additional = $notification->additional ?? [];
                @endphp

                {{-- Header Section --}}
                <div class="flex flex-col lg:flex-row lg:items-start justify-between gap-5 sm:gap-6">
                    {{-- Title and Badges --}}
                    <div class="space-y-3">
                        <h1 class="text-xl sm:text-2xl md:text-3xl font-semibold text-text-white">
                            {{ __('Notification Details') }}
                        </h1>
                        <div class="flex flex-wrap items-center gap-2 sm:gap-3 text-xs sm:text-sm text-text-secondary">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-bg-info text-pink-400 border border-zinc-700">
                                <flux:icon name="tag" class="w-3.5 h-3.5" />
                                <span class="font-medium">{{ ucfirst($notification->type->value) }}</span>
                            </span>
                            <span class="flex items-center gap-1.5 bg-bg-secondary px-3 py-1 rounded-full border border-zinc-700">
                                <flux:icon name="clock" class="w-3.5 h-3.5" />
                                <span>
                                    {{ optional($notification->created_at)->diffForHumans() }}
                                </span>
                            </span>
                        </div>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="flex flex-col sm:flex-row flex-wrap gap-3 w-full lg:w-auto mt-2 lg:mt-0">
                        @if ($notification->action)
                            <x-ui.button variant="primary" href="{{ $notification->action }}" target="_blank"
                                rel="noopener noreferrer"
                                class="w-full sm:w-auto! py-2.5! rounded-lg justify-center flex items-center gap-2">
                                <span class="text-text-btn-primary group-hover:text-text-btn-secondary">{{ __('Action') }}</span>
                                <flux:icon name="arrow-up-right" class="w-4 h-4 stroke-text-btn-primary group-hover:stroke-text-btn-secondary" />
                            </x-ui.button>
                        @endif

                        <x-ui.button variant="tertiary"
                            wire:click="deleteNotification('{{ encrypt($notification->id) }}')"
                            wire:loading.attr="disabled" wire:loading.class="opacity-50 cursor-not-allowed"
                            wire:loading.remove.class="opacity-100 cursor-pointer"
                            wire:loading.remove.target="deleteNotification"
                            class="w-full sm:w-auto! py-2.5! rounded-lg sm:rounded-full justify-center flex items-center gap-2">
                            <flux:icon name="trash" wire:loading.remove wire:target="deleteNotification"
                                class="w-4 h-4 stroke-text-btn-primary group-hover:stroke-text-btn-tertiary" />
                            <flux:icon name="arrow-path" wire:loading wire:target="deleteNotification"
                                class="w-4 h-4 animate-spin stroke-text-btn-primary group-hover:stroke-text-btn-tertiary" />
                            <span class="sm:hidden text-text-btn-primary">{{ __('Delete') }}</span>
                        </x-ui.button>

                        <x-ui.button href="{{ route('user.notifications') }}"
                            class="w-full sm:w-auto! py-2.5! rounded-lg justify-center flex items-center gap-2"
                            variant="secondary">
                            <flux:icon name="bell-alert" class="w-4 h-4 stroke-text-btn-secondary group-hover:stroke-text-btn-primary" />
                            <span class="text-text-btn-secondary group-hover:text-text-btn-primary">{{ __('Back') }}</span>
                        </x-ui.button>
                    </div>
                </div>

                {{-- Main Content Cards --}}
                <div class="space-y-4 sm:space-y-6">
                    {{-- Icon, Title, Summary --}}
                    <div class="flex flex-col sm:flex-row items-center sm:items-start gap-4 sm:gap-6 bg-bg-secondary border border-zinc-700 rounded-2xl p-5 sm:p-6 text-center sm:text-left">
                        <div class="shrink-0">
                            <div class="relative w-16 h-16 sm:w-16 sm:h-16 bg-bg-info border border-zinc-700 rounded-full flex items-center justify-center">
                                <flux:icon name="{{ $data['icon'] ?? 'bell' }}" class="w-7 h-7 sm:w-8 sm:h-8 text-pink-400" />
                            </div>
                        </div>

                        <div class="flex-1 min-w-0 space-y-2 sm:space-y-3 w-full">
                            <h2 class="text-lg sm:text-xl md:text-2xl font-semibold text-text-white break-words">
                                {{ $data['title'] ?? __('Notification') }}
                            </h2>
                            @if ($data['message'] ?? false)
                                <p class="text-sm sm:text-base text-text-secondary leading-relaxed">
                                    {{ $data['message'] }}
                                </p>
                            @endif
                        </div>
                    </div>

                    {{-- Description --}}
                    @if ($data['description'] ?? false)
                        <div class="bg-bg-secondary border border-zinc-700 rounded-2xl p-5 sm:p-6">
                            <h3 class="text-base sm:text-lg font-semibold text-text-white mb-2 sm:mb-3">
                                {{ __('Description') }}
                            </h3>
                            <p class="text-sm sm:text-base text-text-secondary leading-relaxed break-words">
                                {{ $data['description'] }}
                            </p>
                        </div>
                    @endif

                    {{-- Additional Information --}}
                    @if (!empty($additional) && is_array($additional))
                        <div class="bg-bg-secondary border border-zinc-700 rounded-2xl p-5 sm:p-6">
                            <h3 class="text-base sm:text-lg font-semibold text-text-white mb-4">
                                {{ __('Additional Information') }}
                            </h3>
                            <div class="space-y-3 sm:space-y-0 sm:grid sm:grid-cols-1 sm:gap-0">
                                @foreach ($additional as $key => $value)
                                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-1 sm:gap-4 py-2 sm:py-3 {{ !$loop->last ? 'border-b border-zinc-700/50' : '' }}">
                                        <p class="col-span-1 text-sm font-medium text-text-secondary">
                                            {{ ucfirst(str_replace('_', ' ', (string) $key)) }}
                                        </p>
                                        <p class="col-span-1 sm:col-span-2 text-sm text-text-white break-words">
                                            @if (is_array($value))
                                                {{ json_encode($value) }}
                                            @else
                                                {{ (string) $value }}
                                            @endif
                                        </p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            @endif
        </div>
    </div>
</section>