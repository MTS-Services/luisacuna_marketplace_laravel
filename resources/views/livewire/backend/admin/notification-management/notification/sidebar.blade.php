<div x-data="{ openSidebarNotifications: @entangle('openSidebarNotifications').live }" x-show="openSidebarNotifications" x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 translate-x-full" x-transition:enter-end="opacity-100 translate-x-0"
    x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100 translate-x-0"
    x-transition:leave-end="opacity-0 translate-x-full"
    class="fixed right-0 top-0 h-full max-h-screen z-[60] py-4 pr-4 backdrop-blur-sm"
    @open-sidebar-notifications.window="openSidebarNotifications = true"
    @close-sidebar-notifications.window="openSidebarNotifications = false"
    @click.away="openSidebarNotifications = false; $dispatch('close-sidebar-notifications')" style="display: none;">

    <div class="w-96 glass-card overflow-hidden rounded-2xl h-full flex flex-col shadow-2xl border border-border">
        {{-- Header --}}
        <div class="shrink-0 flex items-center justify-between p-4 border-b border-border bg-header">
            <div class="flex items-center gap-2">
                <flux:icon name="bell-ring" class="w-5 h-5 stroke-primary" />
                <h3 class="text-lg font-bold text-text-primary">{{ __('Notifications') }}</h3>
            </div>
            <button @click="openSidebarNotifications = false; $dispatch('close-sidebar-notifications')"
                class="p-2 hover:bg-hover transition-colors rounded-lg group">
                <flux:icon name="x-mark"
                    class="w-5 h-5 stroke-text-muted group-hover:stroke-text-primary transition-colors" />
            </button>
        </div>

        {{-- Content --}}
        <div class="flex-1 overflow-y-auto custom-scrollbar">
            @if ($isLoading)
                {{-- Loading State --}}
                <div class="flex flex-col items-center justify-center h-full gap-3 p-8">
                    <div class="relative">
                        <div class="animate-spin rounded-full h-12 w-12 border-4 border-border border-t-primary"></div>
                        <div class="absolute inset-0 rounded-full border-4 border-transparent border-t-secondary animate-spin"
                            style="animation-duration: 0.7s;"></div>
                    </div>
                    <p class="text-text-muted text-sm">{{ __('Loading notifications...') }}</p>
                </div>
            @else
                <div class="divide-y divide-border">
                    @forelse ($notifications as $notification)
                        @php
                            $isUnread = !$notification->statuses
                                ->where('actor_id', admin()->id)
                                ->where('read_at', '!=', null)
                                ->count();
                        @endphp
                        <div wire:key="notification-sidebar-{{ $notification->id }}"
                            class="relative {{ $isUnread ? 'bg-zinc-50/30 dark:bg-zinc-950/20' : '' }}">

                            {{-- Left Border for Unread --}}
                            @if ($isUnread)
                                <div
                                    class="absolute left-0 top-0 bottom-0 w-1 bg-linear-to-b from-zinc-500 to-secondary-500">
                                </div>
                            @endif

                            {{-- Content Container --}}
                            <div class="group hover:bg-hover transition-all duration-200 p-4 {{ $isUnread ? 'pl-5' : 'pl-4' }}"
                                wire:click="markAsRead('{{ $notification->id }}')">

                                <div class="flex items-start gap-3">
                                    {{-- Icon --}}
                                    <div
                                        class="relative shrink-0 w-10 h-10 glass-card shadow-shadow-primary rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-200">
                                        <flux:icon name="{{ $notification->data['icon'] ?? 'bell' }}"
                                            class="w-5 h-5 {{ $isUnread ? 'stroke-accent' : 'stroke-text-primary' }}" />
                                        @if ($isUnread)
                                            <span class="absolute -top-1 -right-1 w-2.5 h-2.5 bg-primary rounded-full">
                                                <span
                                                    class="absolute inset-0 w-2.5 h-2.5 bg-primary rounded-full animate-ping"></span>
                                            </span>
                                        @endif
                                    </div>

                                    {{-- Content --}}
                                    <div class="flex-1 min-w-0">
                                        <p
                                            class="text-text-primary text-sm font-semibold mb-1 line-clamp-1 group-hover:text-primary transition-colors">
                                            {{ $notification->data['title'] ?? __('Notification') }}
                                        </p>
                                        @if ($notification->data['message'] ?? false)
                                            <p class="text-text-secondary text-xs line-clamp-2 mb-2">
                                                {{ $notification->data['message'] }}
                                            </p>
                                        @endif
                                        <div class="flex items-center justify-between gap-2">
                                            <span class="text-text-muted text-xs flex items-center gap-1">
                                                <flux:icon name="clock" class="w-3 h-3" />
                                                {{ $notification->created_at->diffForHumans() }}
                                            </span>
                                            @if ($isUnread)
                                                <span
                                                    class="text-xs font-medium text-zinc-600 dark:text-zinc-400 flex items-center gap-1">
                                                    <flux:icon name="exclamation-circle" class="w-3 h-3" />
                                                    {{ __('New') }}
                                                </span>
                                            @endif
                                        </div>

                                        {{-- Action Link (if exists) --}}
                                        @if ($notification->action)
                                            <a href="{{ $notification->action }}" target="_blank"
                                                rel="noopener noreferrer"
                                                class="mt-2 inline-flex items-center gap-1 text-xs text-primary hover:text-primary-hover transition-colors"
                                                onclick="event.stopPropagation()">
                                                <span>{{ __('View Details') }}</span>
                                                <flux:icon name="arrow-up-right" class="w-3 h-3" />
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        {{-- Empty State --}}
                        <div class="flex flex-col items-center justify-center py-16 px-6 text-center">
                            <div
                                class="w-20 h-20 mx-auto mb-4 glass-card rounded-full flex items-center justify-center shadow-inner">
                                <flux:icon name="bell-slash" class="w-10 h-10 stroke-text-muted" />
                            </div>
                            <h4 class="text-base font-semibold text-text-secondary mb-1">
                                {{ __('No notifications') }}
                            </h4>
                            <p class="text-sm text-text-muted">
                                {{ __("You're all caught up!") }}
                            </p>
                        </div>
                    @endforelse
                </div>
            @endif
        </div>

        {{-- Footer --}}
        @if (!$isLoading && $notifications->count() > 0)
            <div class="shrink-0 border-t border-border bg-header">
                <div class="flex items-center gap-2 p-4">
                    @php
                        $unreadCount = $notifications
                            ->filter(function ($n) {
                                return !$n->statuses
                                    ->where('actor_id', auth()->id())
                                    ->where('read_at', '!=', null)
                                    ->count();
                            })
                            ->count();
                    @endphp

                    @if ($unreadCount > 0)
                        <x-ui.button wire:click="markAllAsRead" wire:loading.attr="disabled"
                            class="w-auto! flex-1 py-2! rounded-lg text-sm" variant="secondary">
                            <flux:icon name="check-check" wire:loading.remove wire:target="markAllAsRead"
                                class="w-4 h-4 inline mr-1.5 stroke-text-btn-secondary group-hover:stroke-text-btn-primary" />
                            <flux:icon name="arrow-path" wire:loading wire:target="markAllAsRead"
                                class="w-4 h-4 inline mr-1.5 animate-spin stroke-text-btn-secondary group-hover:stroke-text-btn-primary" />
                            <span class="text-text-btn-secondary group-hover:text-text-btn-primary">
                                {{ __('Mark All Read') }}
                            </span>
                        </x-ui.button>
                    @endif

                    <x-ui.button href="{{ route('admin.notification.index') }}" wire:navigate
                        class="w-auto! {{ $unreadCount > 0 ? 'flex-1' : 'w-full' }} py-2! rounded-lg text-sm">
                        <flux:icon name="arrow-right" class="w-4 h-4 inline mr-1.5 stroke-text-btn-primary group-hover:stroke-text-btn-secondary" />
                        {{ __('View All') }}
                    </x-ui.button>
                </div>
            </div>
        @endif
    </div>
</div>

@push('scripts')
    <script>
        // Listen for real-time notifications
        window.addEventListener('notification-received', () => {
            Livewire.dispatch('fetchNotifications');
        });
    </script>
@endpush
