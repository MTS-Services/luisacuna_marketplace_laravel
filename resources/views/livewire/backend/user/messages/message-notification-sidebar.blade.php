<div x-data="{
    show: @entangle('isOpen'),
    loading: false
}" x-show="show" x-cloak {{-- Instant Open --}}
    @user-message-notification-show.window="
        show = true; 
        loading = true; 
        $wire.openSidebar().then(() => { loading = false });
    "
    {{-- Instant Close on click outside --}} @click.outside="show = false; $wire.closeSidebar();"
    x-transition:enter="transition ease-out duration-200"
    x-transition:enter-start="opacity-0 scale-95 translate-y-[-10px]"
    x-transition:enter-end="opacity-100 scale-100 translate-y-0" x-transition:leave="transition ease-in duration-150"
    x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
    class="absolute top-18 right-3 w-[90%] xs:w-3/4 md:max-w-[550px] dark:bg-zinc-900 bg-white rounded-2xl z-50 shadow-2xl border border-zinc-200 dark:border-zinc-800 overflow-hidden flex flex-col max-h-[80vh]">
    <div
        class="p-6 border-b border-zinc-100 dark:border-zinc-800 flex justify-between items-center bg-zinc-50/50 dark:bg-zinc-900/50">
        <div>
            <h2 class="text-xl font-bold text-zinc-900 dark:text-white">{{ __('Messages') }}</h2>
            {{-- <div x-show="!loading">
                @if ($this->conversations->isNotEmpty())
                    <button wire:click="markAllAsRead" class="mt-1">
                        <span
                            class="text-xs text-pink-500 hover:text-pink-600 transition-colors">{{ __('Mark all as read') }}</span>
                    </button>
                @endif
            </div> --}}
        </div>

        {{-- INSTANT CLOSE BUTTON --}}
        <button @click.prevent="show = false; $wire.closeSidebar();"
            class="p-2 rounded-full hover:bg-zinc-200 dark:hover:bg-zinc-800 transition-colors">
            <flux:icon name="x-mark" class="w-5 h-5 text-zinc-500" />
        </button>
    </div>

    <div class="flex-1 overflow-y-auto custom-scrollbar">

        <div x-show="loading" class="p-6 space-y-4">
            @foreach (range(1, 3) as $i)
                <div class="flex gap-4 animate-pulse">
                    <div class="w-12 h-12 bg-zinc-200 dark:bg-zinc-800 rounded-full"></div>
                    <div class="flex-1 space-y-2 py-1">
                        <div class="h-4 bg-zinc-200 dark:bg-zinc-800 rounded w-1/3"></div>
                        <div class="h-3 bg-zinc-200 dark:bg-zinc-800 rounded w-3/4"></div>
                    </div>
                </div>
            @endforeach
        </div>

        <div x-show="!loading">
            @forelse($this->conversations as $conversation)
                @php
                    $otherParticipant = $conversation->participants->first()?->participant;
                    $lastMessage = $conversation->messages->first();
                @endphp

                <a wire:key="sidebar-conv-{{ $conversation->id }}"
                    href="{{ route('user.messages', ['conversation' => $conversation->conversation_uuid]) }}"
                    wire:navigate
                    class="flex items-center gap-4 p-4 hover:bg-zinc-50 dark:hover:bg-white/5 transition-all border-b border-zinc-50 dark:border-zinc-800/50 last:border-0">

                    <div class="relative shrink-0">
                        <img src="{{ auth_storage_url($otherParticipant->avatar) }}"
                            class="w-12 h-12 rounded-full object-cover ring-2 ring-white dark:ring-zinc-800"
                            alt="Avatar">
                    </div>

                    <div class="flex-1 min-w-0">
                        <div class="flex justify-between items-baseline mb-0.5">
                            <h3 class="text-sm font-semibold text-zinc-900 dark:text-zinc-100 truncate">
                                {{ $otherParticipant->full_name }}</h3>
                            <span class="text-[10px] text-zinc-400 font-medium">
                                {{ $lastMessage?->created_at->diffForHumans(short: true) }}
                            </span>
                        </div>
                        <p class="text-xs text-zinc-500 dark:text-zinc-400 line-clamp-1">
                            {{ $lastMessage?->message_body }}
                        </p>
                    </div>
                </a>
            @empty
                <div x-show="!loading && $wire.initialized"
                    class="flex flex-col items-center justify-center py-20 px-6 text-center">
                    <flux:icon name="chat-bubble-left-right" class="w-12 h-12 text-zinc-400 mb-4" />
                    <h4 class="text-zinc-900 dark:text-white font-medium">{{ __('No messages yet') }}</h4>
                </div>
            @endforelse
        </div>
    </div>

    <div x-show="!loading && $wire.initialized">
        @if ($this->conversations->count() > 0)
            <div
                class="p-4 border-t border-zinc-100 dark:border-zinc-800 bg-zinc-50/30 dark:bg-zinc-900/30 text-center">
                <a href="{{ route('user.messages') }}" wire:navigate
                    class="text-sm font-semibold text-pink-500 hover:text-pink-600 transition-colors">
                    {{ __('View All Conversations') }}
                </a>
            </div>
        @endif
    </div>
</div>
