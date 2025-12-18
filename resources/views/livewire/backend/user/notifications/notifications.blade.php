<div class="space-y-6">

    <div x-transition:enter="transition ease-out duration-100"
        class="bg-bg-secondary backdrop:blur-md z-100 transition-all duration-300 min-h-screen text-text-text-white shadow-lg p-4 sm:p-8 md:p-12 lg:p-16 xl:p-20 rounded-2xl">

        <div class="mb-2">
            <!-- Header -->
            <div>
                <div class="block sm:flex gap-2 sm:gap-4 mb-4 sm:mb-10 items-center justify-start">
                    <div class="flex justify-between items-center mb-3 sm:mb-0">
                        <h2 class="text-xl sm:text-3xl font-semibold text-text-white">{{ __('Notifications') }}</h2>
                    </div>
                    <div class="flex gap-2">
                        <button wire:click="$set('filter', 'all')"
                            class="text-sm text-text-white px-2.5 py-1.5 sm:px-5 sm:py-2.5 rounded transition-colors {{ $filter === 'all' ? 'bg-pink-500' : 'bg-bg-info hover:bg-zinc-700' }}">
                            {{ __('All') }}
                        </button>
                        <button wire:click="$set('filter', 'unread')"
                            class="text-sm text-text-white px-2.5 py-1.5 sm:px-5 sm:py-2.5 rounded transition-colors {{ $filter === 'unread' ? 'bg-pink-500' : 'bg-bg-info hover:bg-zinc-700' }}">
                            {{ __('Unread') }}
                        </button>
                        <button wire:click="$set('filter', 'read')"
                            class="text-sm text-text-white px-2.5 py-1.5 sm:px-5 sm:py-2.5 rounded transition-colors {{ $filter === 'read' ? 'bg-pink-500' : 'bg-bg-info hover:bg-zinc-700' }}">
                            {{ __('Read') }}
                        </button>
                    </div>
                </div>

                {{-- Loading Overlay --}}
                <div wire:loading.flex wire:target="filter,perPage"
                    class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 items-center justify-center">
                    <div class="bg-bg-secondary rounded-2xl p-6 shadow-2xl border border-zinc-700">
                        <div
                            class="animate-spin rounded-full h-12 w-12 border-4 border-zinc-700 border-t-pink-500 mx-auto mb-3">
                        </div>
                        <p class="text-text-white font-medium">{{ __('Loading notifications...') }}</p>
                    </div>
                </div>

                <!-- Notification List -->
                @if ($this->notifications->isEmpty())
                    <div class="flex flex-col items-center justify-center py-20 text-center">
                        <div class="w-24 h-24 bg-bg-info rounded-full flex items-center justify-center mb-6">
                            <flux:icon name="bell-slash" class="w-12 h-12 text-zinc-400" />
                        </div>
                        <h3 class="text-xl font-semibold text-text-white mb-2">
                            {{ __('No notifications found') }}
                        </h3>
                        <p class="text-text-secondary mb-4">
                            @if ($filter !== 'all')
                                {{ __('No notifications match the current filter.') }}
                            @else
                                {{ __("You don't have any notifications yet.") }}
                            @endif
                        </p>
                        @if ($filter !== 'all')
                            <button wire:click="$set('filter', 'all')"
                                class="px-6 py-2.5 bg-pink-500 hover:bg-pink-600 text-white rounded-lg transition-colors">
                                {{ __('View All Notifications') }}
                            </button>
                        @endif
                    </div>
                @else
                    <div class="space-y-2 overflow-y-auto pr-1">
                        @foreach ($this->notifications as $notification)
                            @php
                                $isUnread = !$notification->isRead(encrypt(user()->id), get_class(user()));
                            @endphp

                            <div wire:key="notification-{{ encrypt($notification->id) }}"
                                class="group flex flex-col sm:flex-row gap-2 md:gap-4 hover:bg-zinc-800/50 rounded-xl p-4 transition-colors {{ $isUnread ? 'bg-bg-info' : '' }}">

                                <div class="flex gap-2 md:gap-4 flex-1"
                                    wire:click="markAsRead('{{ encrypt($notification->id) }}')">
                                    <div class="shrink-0">
                                        {{-- Notification icon --}}
                                        <div
                                            class="relative w-10 h-10 bg-bg-info rounded-full flex items-center justify-center">
                                            <flux:icon name="{{ $notification->data['icon'] ?? 'bell' }}"
                                                class="w-5 h-5 text-zinc-400" />
                                            @if ($isUnread)
                                                <span
                                                    class="absolute -top-0.5 -right-0.5 w-2.5 h-2.5 bg-pink-500 rounded-full">
                                                    <span
                                                        class="absolute inset-0 w-2.5 h-2.5 bg-pink-500 rounded-full animate-ping"></span>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h3 class="font-semibold text-sm sm:text-base text-text-white line-clamp-1">
                                            {{ $notification->data['title'] ?? __('Notification') }}
                                        </h3>
                                        <p
                                            class="text-sm text-text-white dark:text-zinc-200/60 mt-1 leading-relaxed line-clamp-4">
                                            {{ $notification->data['message'] ?? '' }}
                                        </p>
                                        @if ($notification->action)
                                            <a href="{{ $notification->action }}" target="_blank"
                                                rel="noopener noreferrer"
                                                class="mt-2 inline-flex items-center gap-1 text-xs text-pink-500 hover:text-pink-600 transition-colors"
                                                wire:click="markAsRead('{{ encrypt($notification->id) }}')">
                                                <span>{{ __('View Details') }}</span>
                                                <flux:icon name="arrow-up-right" class="w-3 h-3" />
                                            </a>
                                        @endif
                                    </div>
                                </div>

                                <div class="flex items-start justify-between sm:flex-col sm:items-end gap-2">
                                    <span class="text-xs text-pink-500 whitespace-nowrap">
                                        {{ $notification->created_at->diffForHumans() }}
                                    </span>

                                    {{-- Action Buttons --}}
                                    <div class="flex items-center gap-2 opacity-0 group-hover:opacity-100 transition-opacity"
                                        onclick="event.stopPropagation()">
                                        @if ($isUnread)
                                            <button wire:click="markAsRead('{{ encrypt($notification->id) }}')"
                                                wire:loading.attr="disabled"
                                                class="p-1.5 hover:bg-zinc-700 rounded-lg transition-colors"
                                                title="{{ __('Mark as read') }}">
                                                <flux:icon name="check-check" class="w-4 h-4 text-green-500" />
                                            </button>
                                        {{-- @else
                                            <button wire:click="markAsUnread('{{ encrypt($notification->id) }}')"
                                                wire:loading.attr="disabled"
                                                class="p-1.5 hover:bg-zinc-700 rounded-lg transition-colors"
                                                title="{{ __('Mark as unread') }}">
                                                <flux:icon name="check-line" class="w-4 h-4 text-zinc-400" />
                                            </button> --}}
                                        @endif

                                        <button wire:click="deleteNotification('{{ encrypt($notification->id) }}')"
                                            wire:confirm="Are you sure you want to delete this notification?"
                                            wire:loading.attr="disabled"
                                            class="p-1.5 hover:bg-red-500/20 rounded-lg transition-colors"
                                            title="{{ __('Delete notification') }}">
                                            <flux:icon name="trash" class="w-4 h-4 text-red-500" />
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Pagination --}}
    @if (!$this->notifications->isEmpty())
        <div class="mt-6">
            {{ $this->notifications->links() }}
        </div>
    @endif

</div>

@push('scripts')
    <script>
        // Auto-refresh notifications every 30 seconds
        setInterval(() => {
            Livewire.dispatch('refreshNotifications');
        }, 30000);

        // Listen for real-time notification events
        window.addEventListener('notification-received', event => {
            Livewire.dispatch('refreshNotifications');
        });
    </script>
@endpush
