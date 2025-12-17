<div x-data="{ openSidebarNotifications: @entangle('openSidebarNotifications').live }" x-show="openSidebarNotifications" x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 translate-x-full" x-transition:enter-end="opacity-100 translate-x-0"
    x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100 translate-x-0"
    x-transition:leave-end="opacity-0 translate-x-full"
    class="fixed right-0 top-0 h-full max-h-screen z-30 py-4 pr-4 backdrop-blur-sm"
    @open-sidebar-notifications.window="openSidebarNotifications = true"
    @close-sidebar-notifications.window="openSidebarNotifications = false"
    @click.away="openSidebarNotifications = false;$dispatch('close-sidebar-notifications')" style="display: none;">

    <div class="w-96 glass-card overflow-hidden rounded-2xl h-full flex flex-col">
        {{-- Header --}}
        <div class="shrink-0 flex items-center justify-between p-4 border-b border-border">
            <h3 class="text-xl font-bold text-text-primary">{{ __('Notifications') }}</h3>
            <button @click="openSidebarNotifications = false;$dispatch('close-sidebar-notifications')"
                class="p-2 bg-main transition-colors shadow-shadow-primary border-primary hover:border-primary-hover group cursor-pointer rounded-full">
                <flux:icon icon="x-mark" class="w-6 h-6 stroke-primary group-hover:stroke-primary-hover" />
            </button>
        </div>

        {{-- Content --}}
        <div class="flex-1 h-full px-4 py-2 overflow-y-auto custom-scrollbar">
            @if ($isLoading)
                {{-- Loading State --}}
                <div class="flex items-center justify-center h-full">
                    <div class="animate-spin rounded-full h-8 w-8 border-t-2 border-b-2 border-primary"></div>
                </div>
            @else
                <div class="space-y-4">
                    @forelse ($notifications as $notification)
                        @php
                            $isRead = $notification->statuses
                                ->where('actor_id', auth()->id())
                                ->where('read_at', '!=', null)
                                ->count();
                        @endphp
                        <div wire:key="notification-{{ $notification->id }}">
                            <a href="{{ route('admin.notification.show', encrypt($notification->id)) }}" wire:navigate
                                class="block group hover:bg-main/50 transition-colors rounded-lg p-3 -mx-3">
                                <div class="flex items-start gap-3">
                                    {{-- Icon --}}
                                    <div
                                        class="relative shrink-0 w-9 h-9 glass-card shadow-shadow-primary rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                                        <flux:icon icon="{{ $notification->data['icon'] ?? 'bell' }}"
                                            class="w-5 h-5 {{ $isRead ? 'stroke-text-primary' : 'stroke-primary' }}" />
                                        @if (!$isRead)
                                            <span class="absolute -top-1 -right-1 w-2 h-2 bg-primary rounded-full">
                                                <span
                                                    class="absolute inset-0 w-2 h-2 bg-primary rounded-full animate-ping"></span>
                                            </span>
                                        @endif
                                    </div>

                                    {{-- Content --}}
                                    <div class="flex-1 min-w-0">
                                        <p
                                            class="text-text-primary text-sm font-medium mb-1 line-clamp-1 group-hover:text-primary transition-colors">
                                            {{ $notification->data['title'] ?? __('Notification') }}
                                        </p>
                                        <p class="text-text-secondary text-xs line-clamp-2 mb-1">
                                            {{ $notification->data['message'] ?? '' }}
                                        </p>
                                        <span class="text-text-muted text-xs">
                                            {{ $notification->created_at->diffForHumans() }}
                                        </span>
                                    </div>
                                </div>
                            </a>

                        </div>
                    @empty
                        <div class="text-center py-8 text-text-primary">
                            {{ __('No notifications found') }}
                        </div>
                    @endforelse
                </div>
            @endif
        </div>

        {{-- Footer --}}
        @if (!$isLoading)
            <div class="shrink-0 flex items-center justify-between p-4 border-t border-border gap-2">
                @if ($notifications->count() > 0)
                    <x-ui.button wire:click="markAllAsRead" class="w-auto! py-1! rounded-md" variant="tertiary">
                        {{ __('Mark All As Read') }}
                    </x-ui.button>
                @endif
                <x-ui.button href="{{ route('admin.notification.index') }}" class="w-auto! py-1! rounded-md">
                    {{ __('See All') }}
                </x-ui.button>
            </div>
        @endif
    </div>
</div>
