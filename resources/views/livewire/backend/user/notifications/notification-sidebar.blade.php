<div x-data="{
    UserNotificationShow: @entangle('UserNotificationShow').live
}" @user-notification-show.window="UserNotificationShow = true" x-show="UserNotificationShow"
    x-cloak @click.outside="UserNotificationShow = false" x-transition:enter="transition ease-out duration-100"
    x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100"
    x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100"
    x-transition:leave-end="transform opacity-0 scale-95" wire:init="fetchNotifications"
    class="absolute top-18 right-3 w-[90%] xs:w-3/4 md:max-w-[750px] dark:bg-bg-secondary bg-bg-primary rounded-2xl backdrop:blur-md z-10 shadow-lg overflow-hidden flex flex-col max-h-[75vh] p-10">

    {{-- Fixed Header --}}
    <div class="shrink-0 border-b border-zinc-600 mb-5">
        <div class="flex justify-between items-center">
            <h2 class="text-lg font-semibold text-text-white">{{ __('Notifications') }}</h2>
            <button @click="UserNotificationShow = false"
                class="text-text-secondary hover:text-gray-600 transition-colors">
                <flux:icon name="x-mark" class="w-5 h-5 stroke-current hover:stroke-pink-600" />
            </button>
        </div>
        <div>
            <button wire:click="markAllAsRead" wire:loading.attr="disabled" :disabled="@js($isLoading || $notifications->isEmpty())">
                <span wire:loading.remove wire:target="markAllAsRead"
                    class="text-sm text-pink-500 hover:text-text-hover">
                    {{ __('Mark all as read') }}
                </span>
                <span wire:loading wire:target="markAllAsRead" class="text-sm text-pink-500 hover:text-text-hover">
                    {{ __('Marking...') }}
                </span>
            </button>
        </div>
    </div>

    {{-- Scrollable Content --}}
    <div class="flex-1 overflow-y-auto">
        <div wire:loading.flex wire:target="fetchNotifications"
            class="flex-col items-center justify-center h-full gap-3 py-12">
            <div class="relative">
                <div class="animate-spin rounded-full h-12 w-12 border-4 border-zinc-700 border-t-pink-500"></div>
            </div>
            <p class="text-text-secondary text-sm">{{ __('Loading notifications...') }}</p>
        </div>

        <div wire:loading.remove wire:target="fetchNotifications">
            @if (!$isLoading)
                <div class="space-y-4">
                    @forelse ($notifications as $notification)
                        @php
                            $isUnread = !$notification->isRead(encrypt(user()->id), get_class(user()));
                        @endphp
                        <div wire:key="user-notification-{{ encrypt($notification->id) }}"
                            wire:click="markAsRead('{{ encrypt($notification->id) }}')"
                            class="flex gap-3 hover:bg-bg-hover rounded-xl p-3 transition-colors cursor-pointer {{ $isUnread ? 'bg-bg-hover/80' : '' }}">
                            <div class="shrink-0">
                                <div
                                    class="relative w-10 h-10 bg-zinc-200 dark:bg-zinc-300/10 rounded-full flex items-center justify-center">
                                    <flux:icon name="{{ $notification->data['icon'] ?? 'bell' }}"
                                        class="w-5 h-5 stroke-zinc-500" />
                                    @if ($isUnread)
                                        <span class="absolute -top-0.5 -right-0.5 w-2.5 h-2.5 bg-pink-500 rounded-full">
                                            <span
                                                class="absolute inset-0 w-2.5 h-2.5 bg-pink-500 rounded-full animate-ping"></span>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h3 class="font-semibold text-sm text-text-white line-clamp-1">
                                    {{ $notification->data['title'] ?? __('Notification') }}
                                </h3>
                                <p class="text-sm text-text-secondary/80 mt-1 line-clamp-3">
                                    {{ $notification->data['message'] ?? '' }}
                                </p>
                            </div>
                            <div class="shrink-0">
                                <span class="text-xs text-pink-500">
                                    {{ $notification->created_at->diffForHumans() }}
                                </span>
                            </div>
                        </div>
                    @empty
                        <div class="flex flex-col items-center justify-center py-16 text-center">
                            <div
                                class="w-16 h-16 bg-zinc-200 dark:bg-zinc-300/10 rounded-full flex items-center justify-center mb-4">
                                <flux:icon name="bell-slash" class="w-8 h-8 stroke-zinc-500" />
                            </div>
                            <h4 class="text-base font-semibold text-text-white mb-1">
                                {{ __('No notifications') }}
                            </h4>
                            <p class="text-sm text-text-secondary">
                                {{ __("You're all caught up!") }}
                            </p>
                        </div>
                    @endforelse
                </div>
            @endif
        </div>
    </div>

    {{-- Fixed Footer --}}
    <div wire:loading.remove wire:target="fetchNotifications">
        @if (!$isLoading && $notifications->count() > 0)
            <div class="shrink-0 pt-4 flex items-center justify-center">
                <x-ui.button href="{{ route('user.notifications') }}" wire:navigate class="py-2! max-w-80">
                    {{ __('View all') }}
                </x-ui.button>
            </div>
        @endif
    </div>
</div>

@push('scripts')
    <script>
        // Listen for real-time notifications
        window.addEventListener('notification-received', () => {
            Livewire.dispatch('notification-received');
        });
    </script>
@endpush
