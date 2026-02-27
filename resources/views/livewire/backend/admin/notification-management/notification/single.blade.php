<section>
    <div class="glass-card rounded-2xl p-4 sm:p-6 lg:p-8">
        <div class="max-w-4xl mx-auto space-y-6 sm:space-y-8">
            @if (!$notification && !$notFound)
                {{-- Loading State --}}
                <div class="glass-card rounded-2xl p-6 sm:p-8 text-center">
                    <div
                        class="w-12 h-12 sm:w-16 sm:h-16 border-4 border-primary border-t-transparent rounded-full animate-spin mx-auto mb-4">
                    </div>
                    <p class="text-text-primary">{{ __('Loading notification details...') }}</p>
                </div>
            @elseif($notFound)
                {{-- Error State --}}
                <div class="glass-card rounded-2xl p-6 sm:p-8 text-center">
                    <div
                        class="w-16 h-16 bg-red-100 dark:bg-red-900/30 rounded-full flex items-center justify-center mx-auto mb-4">
                        <flux:icon name="triangle-alert" class="w-8 h-8 stroke-red-500" />
                    </div>
                    <h2 class="text-lg sm:text-xl font-bold text-black dark:text-white mb-2">
                        {{ __('Notification Not Found') }}
                    </h2>
                    <p class="text-sm sm:text-base text-gray-600 dark:text-gray-300 mb-6">
                        {{ __('The notification you\'re looking for doesn\'t exist or has been removed.') }}
                    </p>
                    <div class="flex flex-col sm:flex-row gap-3 justify-center">
                        <x-ui.button href="{{ route('admin.notification.index') }}"
                            class="w-full sm:w-auto! py-2.5! rounded-lg justify-center">
                            <flux:icon name="arrow-left"
                                class="w-4 h-4 stroke-text-btn-primary group-hover:stroke-text-btn-secondary" />
                            {{ __('View All Notifications') }}
                        </x-ui.button>
                        <x-ui.button href="{{ route('admin.dashboard') }}"
                            class="w-full sm:w-auto! py-2.5! rounded-lg justify-center" variant="tertiary">
                            <flux:icon name="layout-dashboard"
                                class="w-4 h-4 stroke-text-btn-primary group-hover:stroke-text-btn-tertiary" />
                            {{ __('Go to Dashboard') }}
                        </x-ui.button>
                    </div>
                </div>
            @else
                @php
                    $data = $notification->data ?? [];
                    $additional = $notification->additional ?? [];
                @endphp

                {{-- Header --}}
                <div class="glass-card rounded-2xl p-4 sm:p-6">
                    <div class="flex flex-col gap-3">
                        <h1 class="text-xl sm:text-2xl font-bold text-text-primary">
                            {{ __('Notification Details') }}
                        </h1>
                        <div class="flex items-center gap-2 sm:gap-4 flex-wrap text-xs sm:text-sm text-text-muted">
                            <span class="badge badge-soft {{ $notification->type->color() ?? 'badge-primary' }}">
                                {{ ucfirst($notification->type->value) }}
                            </span>
                            <span class="flex items-center gap-1.5">
                                <flux:icon name="clock" class="w-3.5 h-3.5 sm:w-4 sm:h-4" />
                                <span>
                                    {{ optional($notification->created_at)->format('d M Y - h:i A') }}
                                </span>
                            </span>
                            @if ($notification->sender)
                                <span class="flex items-center gap-1.5">
                                    <flux:icon name="user" class="w-3.5 h-3.5 sm:w-4 sm:h-4" />
                                    <span>{{ $notification->sender->name ?? __('System') }}</span>
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Notification Content --}}
                <div class="glass-card rounded-2xl overflow-hidden">
                    <div class="p-4 sm:p-6 md:p-8 space-y-6 sm:space-y-8">
                        {{-- Icon and Status --}}
                        <div class="flex flex-col sm:flex-row items-center gap-4 sm:gap-6">
                            <div class="relative shrink-0">
                                <div
                                    class="relative w-10 h-10 sm:w-12 sm:h-12 glass-card shadow-shadow-primary rounded-full flex items-center justify-center">
                                    <flux:icon name="{{ $data['icon'] ?? 'bell' }}"
                                        class="w-5 h-5 sm:w-6 sm:h-6 stroke-primary" />
                                </div>
                            </div>

                            <div class="flex-1 min-w-0 space-y-2 sm:space-y-3 w-full">
                                <h2 id="notification-title"
                                    class="text-lg sm:text-xl md:text-2xl font-bold text-text-primary wrap-break-word">
                                    {{ $data['title'] ?? __('Notification') }}
                                </h2>
                                {{-- @if ($data['message'] ?? false)
                                    <p class="text-sm sm:text-base text-text-muted leading-relaxed">
                                        {{ $data['message'] }}
                                    </p>
                                @endif --}}
                            </div>
                        </div>

                        {{-- Message --}}
                        @if ($data['message'] ?? false)
                            <div>
                                <h3 class="text-base sm:text-lg font-semibold text-text-primary mb-2 sm:mb-3">
                                    {{ __('Message') }}
                                </h3>
                                <div
                                    class="bg-main shadow-shadow-primary rounded-xl p-4 sm:p-6 text-sm sm:text-base text-text-muted leading-relaxed break-words">
                                    {{ $data['message'] }}
                                </div>
                            </div>
                        @endif

                        {{-- Description --}}
                        @if ($data['description'] ?? false)
                            <div>
                                <h3 class="text-base sm:text-lg font-semibold text-text-primary mb-2 sm:mb-3">
                                    {{ __('Description') }}
                                </h3>
                                <div
                                    class="bg-main shadow-shadow-primary rounded-xl p-4 sm:p-6 text-sm sm:text-base text-text-muted leading-relaxed break-words">
                                    {{ $data['description'] }}
                                </div>
                            </div>
                        @endif

                        {{-- Additional Information --}}
                        @if (!empty($additional) && is_array($additional))
                            <div>
                                <h3 class="text-base sm:text-lg font-semibold text-text-primary mb-2 sm:mb-3">
                                    {{ __('Additional Information') }}
                                </h3>
                                <div class="bg-gray-50 dark:bg-gray-800/50 rounded-xl p-4 sm:p-6 flex flex-col gap-3">
                                    @foreach ($additional as $key => $value)
                                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-1 sm:gap-2">
                                            <p class="col-span-1 text-sm font-medium text-text-secondary">
                                                {{ ucfirst(str_replace('_', ' ', (string) $key)) }}:
                                            </p>
                                            <p class="col-span-1 sm:col-span-2 text-sm text-text-muted break-words">
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

                    {{-- Actions Footer --}}
                    <div
                        class="bg-gray-50 dark:bg-gray-800/30 px-4 sm:px-6 md:px-8 py-4 sm:py-6 border-t border-gray-200 dark:border-gray-700">
                        <div
                            class="flex flex-col lg:flex-row items-stretch lg:items-center justify-between gap-4 sm:gap-6">

                            {{-- Left: action URL + mark-unread + delete --}}
                            <div class="w-full lg:w-auto flex flex-col sm:flex-row flex-wrap gap-3">
                                @if ($notification->action)
                                    <x-ui.button href="{{ $notification->action }}" target="_blank" :wire='false'
                                        rel="noopener noreferrer"
                                        class="w-full sm:w-auto! py-2.5! rounded-lg justify-center">
                                        <flux:icon name="arrow-up-right"
                                            class="w-4 h-4 stroke-text-btn-primary group-hover:stroke-text-btn-secondary" />
                                        {{ __('Open Related Page') }}
                                    </x-ui.button>
                                @endif

                                {{-- Mark as Unread --}}
                                <x-ui.button wire:click="markAsUnread" wire:loading.attr="disabled"
                                    class="w-full sm:w-auto! py-2.5! rounded-lg justify-center flex items-center gap-2"
                                    variant="secondary" title="{{ __('Mark as unread') }}">
                                    <flux:icon name="check-line" wire:loading.remove wire:target="markAsUnread"
                                        class="w-4 h-4 stroke-text-btn-secondary group-hover:stroke-text-btn-primary" />
                                    <flux:icon name="arrow-path" wire:loading wire:target="markAsUnread"
                                        class="w-4 h-4 animate-spin stroke-text-btn-secondary group-hover:stroke-text-btn-primary" />
                                    <span class="text-text-btn-secondary group-hover:text-text-btn-primary">
                                        {{ __('Mark as Unread') }}
                                    </span>
                                </x-ui.button>

                                {{-- Delete --}}
                                <x-ui.button wire:click="deleteNotification" wire:loading.attr="disabled"
                                    wire:confirm="{{ __('Are you sure you want to delete this notification?') }}"
                                    class="w-full sm:w-auto! py-2.5! rounded-lg justify-center flex items-center gap-2"
                                    variant="tertiary" title="{{ __('Delete notification') }}">
                                    <flux:icon name="trash" wire:loading.remove wire:target="deleteNotification"
                                        class="w-4 h-4 stroke-text-btn-primary group-hover:stroke-text-btn-tertiary" />
                                    <flux:icon name="arrow-path" wire:loading wire:target="deleteNotification"
                                        class="w-4 h-4 animate-spin stroke-text-btn-primary group-hover:stroke-text-btn-tertiary" />
                                    <span class="text-text-btn-primary group-hover:text-text-btn-tertiary">
                                        {{ __('Delete') }}
                                    </span>
                                </x-ui.button>
                            </div>

                            {{-- Right: back to list --}}
                            <div
                                class="w-full lg:w-auto pt-4 lg:pt-0 border-t border-gray-200 dark:border-gray-700 lg:border-t-0">
                                <x-ui.button href="{{ route('admin.notification.index') }}"
                                    class="w-full sm:w-auto! py-2.5! rounded-lg justify-center" variant="secondary">
                                    <flux:icon name="bell-alert"
                                        class="w-4 h-4 stroke-text-btn-secondary group-hover:stroke-text-btn-primary" />
                                    {{ __('See All Notifications') }}
                                </x-ui.button>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</section>
