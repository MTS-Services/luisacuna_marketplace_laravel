<div x-data="{
    show: @entangle('UserNotificationShow'),
    loading: false
}" x-show="show" x-cloak {{-- Instant Alpine Response --}}
    @user-notification-show.window="
        show = true; 
        loading = true; 
        $wire.openSidebar().then(() => { loading = false });
    "
    @click.outside="show = false; $wire.closeSidebar();" x-transition:enter="transition ease-out duration-200"
    x-transition:enter-start="opacity-0 scale-95 translate-y-[-10px]"
    x-transition:enter-end="opacity-100 scale-100 translate-y-0" x-transition:leave="transition ease-in duration-150"
    x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
    class="absolute top-18 right-3 w-[90%] xs:w-3/4 md:max-w-[550px] dark:bg-zinc-900 bg-white rounded-2xl z-50 shadow-2xl border border-zinc-200 dark:border-zinc-800 overflow-hidden flex flex-col max-h-[80vh]">

    {{-- Fixed Header --}}
    <div
        class="p-6 border-b border-zinc-100 dark:border-zinc-800 flex justify-between items-center bg-zinc-50/50 dark:bg-zinc-900/50">
        <div>
            <h2 class="text-xl font-bold text-zinc-900 dark:text-white">{{ __('Notifications') }}</h2>

            <div x-show="!loading">
                @if ($this->unreadCount > 0)
                    <button wire:click="markAllAsRead" class="mt-1 group">
                        <span wire:loading.remove wire:target="markAllAsRead"
                            class="text-xs text-pink-500 hover:text-pink-600 transition-colors">
                            {{ __('Mark all as read') }}
                        </span>
                        <span wire:loading wire:target="markAllAsRead" class="text-xs text-zinc-500 animate-pulse">
                            {{ __('Marking...') }}
                        </span>
                    </button>
                @endif
            </div>
        </div>

        <button @click.prevent="show = false; $wire.closeSidebar();"
            class="p-2 rounded-full hover:bg-zinc-200 dark:hover:bg-zinc-800 transition-colors">
            <flux:icon name="x-mark" class="w-5 h-5 text-zinc-500" />
        </button>
    </div>

    {{-- Content --}}
    <div class="flex-1 overflow-y-auto custom-scrollbar">

        {{-- SKELETON LOADING (Alpine Triggered) --}}
        <div x-show="loading" class="p-6 space-y-4">
            @foreach (range(1, 4) as $i)
                <div class="flex gap-4 animate-pulse">
                    <div class="w-10 h-10 bg-zinc-200 dark:bg-zinc-800 rounded-full"></div>
                    <div class="flex-1 space-y-2 py-1">
                        <div class="h-4 bg-zinc-200 dark:bg-zinc-800 rounded w-1/4"></div>
                        <div class="h-3 bg-zinc-200 dark:bg-zinc-800 rounded w-3/4"></div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- NOTIFICATION LIST --}}
        <div x-show="!loading">
            <div class="divide-y divide-zinc-50 dark:divide-zinc-800/50">
                @forelse ($this->notifications as $notification)
                    @php
                        $isUnread = !$notification->isRead(encrypt(user()->id), get_class(user()));
                    @endphp
                    <div wire:key="user-notif-{{ $notification->id }}"
                        wire:click="markAsRead('{{ encrypt($notification->id) }}')"
                        class="flex gap-4 p-4 hover:bg-zinc-50 dark:hover:bg-white/5 transition-all cursor-pointer {{ $isUnread ? 'bg-pink-50/30 dark:bg-pink-500/5' : '' }}">

                        <div class="shrink-0">
                            <div
                                class="relative w-10 h-10 bg-zinc-100 dark:bg-zinc-800 rounded-full flex items-center justify-center">
                                <flux:icon name="{{ $notification->data['icon'] ?? 'bell' }}"
                                    class="w-5 h-5 text-zinc-500" />
                                @if ($isUnread)
                                    <span
                                        class="absolute top-0 right-0 w-2.5 h-2.5 bg-pink-500 border-2 border-white dark:border-zinc-900 rounded-full"></span>
                                @endif
                            </div>
                        </div>

                        <div class="flex-1 min-w-0">
                            <div class="flex justify-between items-baseline mb-0.5">
                                <h3 class="text-sm font-semibold text-zinc-900 dark:text-zinc-100 truncate">
                                    {{ $notification->data['title'] ?? __('Notification') }}
                                </h3>
                                <span class="text-[10px] text-zinc-400 font-medium shrink-0">
                                    {{ $notification->created_at->diffForHumans(short: true) }}
                                </span>
                            </div>
                            <p class="text-xs text-zinc-500 dark:text-zinc-400 line-clamp-2">
                                {{ $notification->data['message'] ?? '' }}
                            </p>
                        </div>
                    </div>
                @empty
                    <div x-show="!loading && $wire.initialized"
                        class="flex flex-col items-center justify-center py-20 px-6 text-center">
                        <div
                            class="w-16 h-16 bg-zinc-100 dark:bg-zinc-800 rounded-full flex items-center justify-center mb-4">
                            <flux:icon name="bell-slash" class="w-8 h-8 text-zinc-400" />
                        </div>
                        <h4 class="text-zinc-900 dark:text-white font-medium">{{ __('No notifications') }}</h4>
                        <p class="text-sm text-zinc-500 mt-1">{{ __("You're all caught up!") }}</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Fixed Footer --}}
    <div x-show="!loading && $wire.initialized">
        @if ($this->notifications->isNotEmpty())
            <div
                class="p-4 border-t border-zinc-100 dark:border-zinc-800 bg-zinc-50/30 dark:bg-zinc-900/30 text-center">
                <a href="{{ route('user.notifications') }}" wire:navigate
                    class="text-sm font-semibold text-pink-500 hover:text-pink-600 transition-colors">
                    {{ __('View All Notifications') }}
                </a>
            </div>
        @endif
    </div>
</div>
