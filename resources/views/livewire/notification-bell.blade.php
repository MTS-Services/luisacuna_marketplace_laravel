<div class="relative" x-data="notificationBell" x-init="init({{ auth()->id() }}, 'users')" @click.away="$wire.showDropdown = false">

    <!-- Notification Bell Button -->
    <button wire:click="toggleDropdown"
        class="relative p-2 text-gray-600 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 rounded-full">

        <!-- Bell Icon (SVG) -->
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
        </svg>

        <!-- Unread Badge -->
        @if ($unreadCount > 0)
            <span
                class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white transform translate-x-1/2 -translate-y-1/2 bg-red-600 rounded-full">
                {{ $unreadCount > 99 ? '99+' : $unreadCount }}
            </span>
        @endif
    </button>

    <!-- Dropdown Menu -->
    @if ($showDropdown)
        <div
            class="absolute right-0 z-50 mt-2 w-80 bg-white rounded-lg shadow-xl border border-gray-200 max-h-96 overflow-hidden">

            <!-- Header -->
            <div class="flex items-center justify-between px-4 py-3 border-b border-gray-200 bg-gray-50">
                <h3 class="text-lg font-semibold text-gray-900">Notifications</h3>
                @if ($unreadCount > 0)
                    <button wire:click="markAllAsRead" class="text-sm text-blue-600 hover:text-blue-800 font-medium">
                        Mark all read
                    </button>
                @endif
            </div>

            <!-- Notifications List -->
            <div class="overflow-y-auto max-h-80">
                @forelse($notifications as $notification)
                    <div wire:key="notification-{{ $notification['id'] }}"
                        class="px-4 py-3 border-b border-gray-100 hover:bg-gray-50 cursor-pointer transition {{ is_null($notification['read_at']) ? 'bg-blue-50' : '' }}"
                        wire:click="markAsRead('{{ $notification['id'] }}')">

                        <div class="flex items-start gap-3">
                            <!-- Icon -->
                            <div class="flex-shrink-0 mt-1">
                                @php
                                    $iconColors = [
                                        'success' => 'bg-green-100 text-green-600',
                                        'warning' => 'bg-yellow-100 text-yellow-600',
                                        'error' => 'bg-red-100 text-red-600',
                                        'info' => 'bg-blue-100 text-blue-600',
                                    ];
                                    $type = $notification['data']['type'] ?? 'info';
                                    $colorClass = $iconColors[$type] ?? $iconColors['info'];
                                @endphp
                                <div class="w-8 h-8 {{ $colorClass }} rounded-full flex items-center justify-center">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        @if ($type === 'success')
                                            <path fill-rule="evenodd"
                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                clip-rule="evenodd" />
                                        @elseif($type === 'warning')
                                            <path fill-rule="evenodd"
                                                d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                                clip-rule="evenodd" />
                                        @elseif($type === 'error')
                                            <path fill-rule="evenodd"
                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                                clip-rule="evenodd" />
                                        @else
                                            <path fill-rule="evenodd"
                                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                                clip-rule="evenodd" />
                                        @endif
                                    </svg>
                                </div>
                            </div>

                            <!-- Content -->
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900">
                                    {{ $notification['data']['title'] }}
                                </p>
                                <p class="text-sm text-gray-600 mt-1">
                                    {{ $notification['data']['message'] }}
                                </p>
                                <p class="text-xs text-gray-400 mt-1">
                                    {{ \Carbon\Carbon::parse($notification['created_at'])->diffForHumans() }}
                                </p>
                            </div>

                            <!-- Unread Indicator -->
                            @if (is_null($notification['read_at']))
                                <div class="flex-shrink-0">
                                    <div class="w-2 h-2 bg-blue-600 rounded-full"></div>
                                </div>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="px-4 py-12 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                        </svg>
                        <p class="mt-2 text-sm text-gray-500">No notifications yet</p>
                    </div>
                @endforelse
            </div>

            <!-- Footer -->
            @if (count($notifications) > 0)
                <div class="px-4 py-3 bg-gray-50 text-center border-t border-gray-200">
                    <a href="{{ route('notifications.index') }}"
                        class="text-sm text-blue-600 hover:text-blue-800 font-medium">
                        View all notifications
                    </a>
                </div>
            @endif
        </div>
    @endif
</div>

@script
    <script>
        Alpine.data('notificationBell', () => ({
            init(userId, guardType) {
                // Listen for notifications on the private channel
                window.Echo.private(`${guardType}.${userId}`)
                    .notification((notification) => {
                        console.log('Notification received:', notification);

                        // Trigger Livewire event to reload notifications
                        this.$wire.dispatch('notification-received');

                        // Show browser notification
                        this.showBrowserNotification(notification);

                        // Optional: Play sound
                        this.playNotificationSound();
                    });
            },

            showBrowserNotification(notification) {
                if ('Notification' in window && Notification.permission === 'granted') {
                    new Notification(notification.title, {
                        body: notification.message,
                        icon: '/favicon.ico',
                        badge: '/favicon.ico',
                        tag: 'notification-' + Date.now()
                    });
                }
            },

            playNotificationSound() {
                // Optional: Add notification sound
                // const audio = new Audio('/sounds/notification.mp3');
                // audio.play().catch(e => console.log('Sound play failed:', e));
            }
        }));
    </script>
@endscript
