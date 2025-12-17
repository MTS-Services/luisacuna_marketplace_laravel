<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    {{-- Header Section --}}
    <div class="glass-card rounded-2xl p-6 mb-6">
        <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-4">
            {{-- Title & Description --}}
            <div class="flex-1">
                <div class="flex items-center gap-3 mb-2">
                    <div class="w-12 h-12 rounded-xl glass-card flex items-center justify-center shadow-lg">
                        <flux:icon name="bell" class="w-6 h-6 stroke-primary" />
                    </div>
                    <div>
                        <h1 class="text-2xl md:text-3xl font-bold text-text-primary">
                            {{ __('Notifications') }}
                        </h1>
                        <p class="text-sm text-text-muted">
                            {{ __('Manage all your notifications in one place') }}
                        </p>
                    </div>
                </div>
            </div>

            {{-- Stats & Actions --}}
            <div class="flex flex-wrap items-center gap-3">
                {{-- Unread Count Badge --}}
                <div class="px-4 py-2 bg-main rounded-xl border border-border">
                    <span class="text-text-secondary font-semibold text-sm">
                        <span wire:loading.remove wire:target="markAllAsRead,deleteAll,refresh">
                            {{ $this->unreadCount }}
                        </span>
                        <span wire:loading wire:target="markAllAsRead,deleteAll,refresh">
                            <flux:icon name="arrow-path" class="w-4 h-4 inline animate-spin" />
                        </span>
                        {{ __('unread') }}
                    </span>
                </div>

                {{-- Mark All Read --}}
                <x-ui.button wire:click="markAllAsRead" wire:loading.attr="disabled" :disabled="$this->unreadCount === 0"
                    variant="secondary" class="w-auto! px-4 py-2! rounded-lg" title="Mark all as read">
                    <flux:icon name="check-check"
                        class="w-4 h-4 inline mr-2 stroke-text-btn-secondary group-hover:stroke-text-btn-primary" />
                    <span class="hidden sm:inline text-text-btn-secondary group-hover:text-text-btn-primary">
                        {{ __('Mark All Read') }}
                    </span>
                </x-ui.button>

                {{-- Refresh --}}
                <x-ui.button wire:click="refresh" wire:loading.attr="disabled" variant="tertiary"
                    class="w-auto! py-2! rounded-xl" title="Refresh notifications">
                    <flux:icon name="arrow-path"
                        class="w-4 h-4 inline stroke-text-btn-primary group-hover:stroke-text-btn-tertiary"
                        wire:loading.class="animate-spin" wire:target="refresh" />
                </x-ui.button>
            </div>
        </div>
    </div>

    {{-- Filters Section --}}
    <div class="glass-card rounded-2xl p-6 mb-6">
        <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-4">
            {{-- Left Side Filters --}}
            <div class="flex flex-wrap items-center gap-3 flex-1">
                {{-- Filter Dropdown --}}
                <div class="flex items-center gap-2">
                    <label class="text-sm font-medium text-text-secondary hidden sm:block">{{ __('Filter') }}:</label>
                    <x-ui.select wire:model.live="filter">
                        <option value="all">{{ __('All Notifications') }}</option>
                        <option value="unread">{{ __('Unread Only') }}</option>
                        <option value="read">{{ __('Read Only') }}</option>
                    </x-ui.select>
                </div>

                {{-- Per Page --}}
                <div class="flex items-center gap-2">
                    <label class="text-sm font-medium text-text-secondary hidden sm:block">{{ __('Show') }}:</label>
                    <x-ui.select wire:model.live="perPage">
                        <option value="5">5</option>
                        <option value="15">15</option>
                        <option value="30">30</option>
                        <option value="50">50</option>
                    </x-ui.select>
                </div>
            </div>

            {{-- Right Side Info & Actions --}}
            <div class="flex items-center gap-3">
                {{-- Bulk Actions (show when items selected) --}}
                @if (count($selectedNotifications) > 0)
                    <div class="flex items-center gap-2 animate-fade-in">
                        <span class="text-sm font-medium text-text-secondary">
                            {{ count($selectedNotifications) }} {{ __('selected') }}
                        </span>
                        <button wire:click="deleteSelected"
                            wire:confirm="Are you sure you want to delete {{ count($selectedNotifications) }} selected notifications?"
                            class="px-3 py-1.5 bg-red-500/10 hover:bg-red-500/20 text-red-600 dark:text-red-400 rounded-lg transition-all duration-200 text-sm border border-red-500/20 hover:shadow-md">
                            <flux:icon name="trash" class="w-3.5 h-3.5 inline mr-1 stroke-red-500" />
                            {{ __('Delete Selected') }}
                        </button>
                    </div>
                @endif

                {{-- Results Info --}}
                <div class="text-sm text-text-muted">
                    <span class="font-medium text-text-primary">{{ $this->notifications->total() }}</span>
                    <span class="hidden sm:inline">{{ __('notifications') }}</span>
                    @if ($filter !== 'all')
                        <span class="ml-2 badge badge-soft badge-primary">
                            {{ ucfirst($filter) }}
                        </span>
                    @endif
                </div>
            </div>
        </div>

        {{-- Stats Bar --}}
        <div class="flex items-center gap-4 mt-4 pt-4 border-t border-border">
            <div class="flex items-center gap-2 text-sm">
                <span class="text-text-muted">{{ __('Total') }}:</span>
                <span class="font-semibold text-text-primary">{{ $this->stats['total'] }}</span>
            </div>
            <div class="w-px h-4 bg-border"></div>
            <div class="flex items-center gap-2 text-sm">
                <span class="text-text-muted">{{ __('Unread') }}:</span>
                <span class="font-semibold text-zinc-600 dark:text-zinc-400">{{ $this->stats['unread'] }}</span>
            </div>
            <div class="w-px h-4 bg-border"></div>
            <div class="flex items-center gap-2 text-sm">
                <span class="text-text-muted">{{ __('Read') }}:</span>
                <span
                    class="font-semibold text-secondary-600 dark:text-secondary-400">{{ $this->stats['read'] }}</span>
            </div>
        </div>
    </div>

    {{-- Loading Overlay --}}
    <div wire:loading.flex wire:target="filter,perPage"
        class="fixed inset-0 bg-black/20 backdrop-blur-sm z-50 items-center justify-center">
        <div class="bg-card rounded-2xl p-6 shadow-2xl border border-border">
            <flux:icon name="arrow-path" class="w-8 h-8 stroke-primary animate-spin mx-auto mb-3" />
            <p class="text-text-primary font-medium">{{ __('Loading notifications...') }}</p>
        </div>
    </div>

    {{-- Notifications List --}}
    <div class="glass-card rounded-2xl overflow-hidden">
        @if ($this->notifications->isEmpty())
            {{-- Empty State --}}
            <div class="p-12 text-center">
                <div
                    class="w-24 h-24 mx-auto mb-6 glass-card rounded-full flex items-center justify-center shadow-inner">
                    <flux:icon name="bell-slash" class="w-12 h-12 stroke-text-muted" />
                </div>
                <h3 class="text-xl font-semibold text-text-secondary mb-2">
                    {{ __('No notifications found') }}
                </h3>
                <p class="text-text-muted mb-4">
                    @if ($filter !== 'all')
                        {{ __('No notifications match the current filter.') }}
                    @else
                        {{ __("You don't have any notifications yet.") }}
                    @endif
                </p>
                @if ($filter !== 'all')
                    <x-ui.button wire:click="$set('filter', 'all')" class="w-auto! inline-flex! py-2!">
                        {{ __('View All Notifications') }}
                    </x-ui.button>
                @endif
            </div>
        @else
            {{-- Select All Checkbox (Desktop) --}}
            @if ($this->notifications->count() > 0)
                <div class="hidden sm:flex items-center gap-3 px-6 py-3 bg-hover border-b border-border">
                    <input type="checkbox" wire:model.live="selectAll" id="selectAll"
                        class="checkbox checkbox-sm rounded shadow-shadow-primary checkbox-accent">
                    <label class="text-sm font-medium text-text-secondary cursor-pointer select-none" for="selectAll">
                        {{ __('Select All on Page') }} ({{ $this->notifications->count() }})
                    </label>
                </div>
            @endif

            {{-- Notifications Items --}}
            <div class="divide-y divide-border">
                @foreach ($this->notifications as $notification)
                    @php
                        $isUnread = !$notification->statuses
                            ->where('actor_id', auth()->id())
                            ->where('read_at', '!=', null)
                            ->count();
                    @endphp
                    <div wire:key="notification-{{ $notification->id }}"
                        class="group relative hover:bg-hover transition-all duration-200 cursor-pointer {{ $isUnread ? 'bg-zinc-50/30 dark:bg-zinc-950/20' : '' }}">

                        {{-- Left Border for Unread --}}
                        @if ($isUnread)
                            <div
                                class="absolute left-0 top-0 bottom-0 w-1 bg-gradient-to-b from-zinc-500 to-secondary-500">
                            </div>
                        @endif

                        {{-- Action Link Overlay --}}
                        @if ($notification->action)
                            <a href="{{ $notification->action }}" target="_blank" rel="noopener noreferrer"
                                title="{{ $notification->data['title'] ?? 'Notification' }}"
                                class="absolute inset-0 z-0" wire:click="markAsRead('{{ $notification->id }}')">
                            </a>
                        @else
                            <div class="absolute inset-0 z-0" wire:click="markAsRead('{{ $notification->id }}')">
                            </div>
                        @endif

                        <div class="flex items-start gap-4 p-6 relative z-10 {{ $isUnread ? 'pl-8' : 'pl-6' }}">
                            {{-- Checkbox (visible on hover or selected) --}}
                            <div class="shrink-0 pt-1 opacity-0 group-hover:opacity-100 transition-opacity duration-200 {{ in_array($notification->id, $selectedNotifications) ? 'opacity-100' : '' }}"
                                onclick="event.stopPropagation()">
                                <input type="checkbox" wire:model.live="selectedNotifications"
                                    value="{{ $notification->id }}"
                                    class="checkbox checkbox-sm rounded shadow-shadow-primary checkbox-accent">
                            </div>

                            {{-- Icon --}}
                            <div class="relative shrink-0">
                                <div
                                    class="w-12 h-12 rounded-xl flex items-center justify-center shadow-shadow-primary glass-card">
                                    <flux:icon name="{{ $notification->data['icon'] ?? 'bell' }}"
                                        class="w-6 h-6 {{ $isUnread ? 'stroke-accent' : 'stroke-text-primary' }}" />
                                </div>

                                {{-- Unread Indicator --}}
                                @if ($isUnread)
                                    <span class="absolute -top-1 -right-1 w-3 h-3 bg-primary rounded-full">
                                        <span
                                            class="absolute inset-0 w-3 h-3 bg-primary rounded-full animate-ping"></span>
                                    </span>
                                @endif
                            </div>

                            {{-- Content --}}
                            <div class="flex-1 min-w-0">
                                <div class="flex items-start justify-between gap-4 mb-2">
                                    <div class="flex-1 min-w-0">
                                        <h3 class="text-base font-semibold text-text-primary mb-1 line-clamp-1">
                                            {{ $notification->data['title'] ?? __('Notification') }}
                                        </h3>
                                        @if ($notification->data['message'] ?? false)
                                            <p class="text-text-secondary text-sm mb-2 line-clamp-2">
                                                {{ $notification->data['message'] }}
                                            </p>
                                        @endif
                                        @if ($notification->data['description'] ?? false)
                                            <p class="text-text-muted text-xs line-clamp-1">
                                                {{ $notification->data['description'] }}
                                            </p>
                                        @endif
                                    </div>

                                    {{-- Action Buttons --}}
                                    <div class="flex items-center gap-2 shrink-0" onclick="event.stopPropagation()">
                                        @if ($isUnread)
                                            <button wire:click="markAsRead('{{ $notification->id }}')"
                                                wire:loading.attr="disabled"
                                                class="p-2 hover:bg-zinc-500/20 rounded-full transition-all duration-300 hover:scale-110 opacity-0 group-hover:opacity-100"
                                                title="{{ __('Mark as read') }}">
                                                <flux:icon name="check-line" class="w-5 h-5 stroke-accent" />
                                            </button>
                                        @else
                                            <button wire:click="markAsUnread('{{ $notification->id }}')"
                                                wire:loading.attr="disabled"
                                                class="p-2 hover:bg-primary/20 rounded-full transition-all duration-200 hover:scale-110 opacity-0 group-hover:opacity-100"
                                                title="{{ __('Mark as unread') }}">
                                                <flux:icon name="check-circle" class="w-5 h-5 stroke-primary" />
                                            </button>
                                        @endif

                                        <button wire:click="deleteNotification('{{ $notification->id }}')"
                                            wire:confirm="Are you sure you want to delete this notification?"
                                            wire:loading.attr="disabled"
                                            class="p-2 hover:bg-red-500/20 rounded-full transition-all duration-200 hover:scale-110 opacity-0 group-hover:opacity-100"
                                            title="{{ __('Delete notification') }}">
                                            <flux:icon name="trash"
                                                class="w-4 h-4 stroke-red-600 dark:stroke-red-400" />
                                        </button>
                                    </div>
                                </div>

                                {{-- Meta Information --}}
                                <div class="flex items-center flex-wrap gap-x-4 gap-y-2 text-xs text-text-muted mt-3">
                                    {{-- Time --}}
                                    <span class="flex items-center gap-1">
                                        <flux:icon name="clock" class="w-3.5 h-3.5" />
                                        {{ $notification->created_at->diffForHumans() }}
                                    </span>

                                    {{-- Type Badge --}}
                                    <span class="flex items-center gap-1">
                                        <flux:icon name="tag" class="w-3.5 h-3.5" />
                                        <span
                                            class="px-2 py-0.5 rounded-full text-xs font-medium badge badge-soft {{ $notification->type->color() }}">
                                            {{ ucfirst($notification->type->value) }}
                                        </span>
                                    </span>

                                    {{-- Sender --}}
                                    @if ($notification->sender)
                                        <span class="flex items-center gap-1">
                                            <flux:icon name="user" class="w-3.5 h-3.5" />
                                            {{ $notification->sender->name ?? __('System') }}
                                        </span>
                                    @else
                                        <span class="flex items-center gap-1">
                                            <flux:icon name="shield" class="w-3.5 h-3.5" />
                                            {{ __('System') }}
                                        </span>
                                    @endif

                                    {{-- Read Status --}}
                                    <span
                                        class="ml-auto flex items-center gap-1 font-medium {{ $isUnread ? 'text-text-primary' : 'text-accent' }}">
                                        <flux:icon name="{{ $isUnread ? 'exclamation-circle' : 'check-circle' }}"
                                            class="w-3.5 h-3.5 {{ $isUnread ? 'stroke-text-primary' : 'stroke-accent' }}" />
                                        {{ $isUnread ? __('Unread') : __('Read') }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    {{-- Pagination --}}
    @if (!$this->notifications->isEmpty())
        <div class="mt-6">
            {{ $this->notifications->links() }}
        </div>
    @endif

    @push('scripts')
        <script>
            // Auto-refresh notifications every 30 seconds
            setInterval(() => {
                @this.call('refreshNotifications');
            }, 30000);

            // Listen for real-time notification events
            window.addEventListener('notification-received', event => {
                @this.call('refreshNotifications');
            });
        </script>
    @endpush

    <style>
        @keyframes fade-in {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in {
            animation: fade-in 0.3s ease-out;
        }
    </style>
</div>
