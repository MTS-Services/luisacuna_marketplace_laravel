<div>
    <div class="bg-bg-primary">
        <div>
            <div class="p-3 sm:p-4">
                <div class="flex items-center justify-between mb-3 sm:mb-4">
                    <h2 class="text-lg sm:text-xl md:text-2xl lg:text-3xl text-text-primary font-lato">
                        {{ __('Messages') }}
                        @if ($totalUnreadCount > 0)
                            <span
                                class="inline-flex items-center justify-center w-6 h-6 text-xs font-bold text-white bg-red-500 rounded-full">
                                {{ $totalUnreadCount }}
                            </span>
                        @endif
                    </h2>

                    {{-- Mobile Menu Toggle --}}
                    <button onclick="toggleMobileMenu()"
                        class="md:hidden bg-accent text-white px-3 py-2 rounded-lg text-xs font-medium flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                        {{ __('Conversations') }}
                    </button>
                </div>

                {{-- Filters --}}
                <div class="flex flex-col sm:flex-row items-center justify-between mb-3 gap-3 sm:gap-4">
                    <div
                        class="flex items-center gap-3 sm:gap-5 border border-zinc-500 px-3 py-1 w-full sm:w-auto justify-between rounded-md">
                        <span class="text-xs sm:text-sm text-text-secondary">{{ __('Unread message only') }}</span>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" wire:model.live="unreadOnly"
                                class="toggle before:bg-accent border-accent dark:checked:before:bg-white checked:before:bg-zinc-900 dark:checked:border-white checked:border-zinc-900">
                        </label>
                    </div>

                    <div class="relative w-full sm:w-40 md:w-44 lg:w-52 xl:w-70">
                        <select wire:model.live="categoryFilter"
                            class="bg-surface-card border border-border-primary py-1.5 rounded-lg w-full">
                            <option value="">{{ __('All') }}</option>
                            <option value="boosting">{{ __('Boosting') }}</option>
                            <option value="orders">{{ __('Orders') }}</option>
                            <option value="support">{{ __('Support') }}</option>
                            <option value="pre-purchase">{{ __('Pre-purchase') }}</option>
                        </select>
                    </div>
                </div>

                <button wire:click.prevent="markAllAsRead"
                    class="text-xs sm:text-sm text-pink-500 hover:text-pink-400 transition-colors">
                    {{ __('Mark all as read') }}
                </button>
            </div>

            <div class="flex flex-col md:flex-row h-auto md:h-[68vh] gap-2 px-3 sm:px-4 relative">
                {{-- Mobile Overlay --}}
                <div id="mobileOverlay" onclick="toggleMobileMenu()"
                    class="hidden fixed inset-0 bg-black bg-opacity-50 z-40 md:hidden"></div>

                {{-- Left Sidebar --}}
                <div id="messagesSidebar"
                    class="fixed md:static inset-y-0 left-0 transform -translate-x-full md:translate-x-0
                           transition-transform duration-300 ease-in-out z-30
                           w-full md:w-64 lg:w-72 xl:w-80 2xl:w-96
                           bg-bg-secondary rounded-lg flex flex-col md:mr-5 mb-1 md:mb-0 max-h-full md:max-h-full">

                    <div class="p-3 sm:p-4">
                        {{-- Mobile Close --}}
                        <div class="flex items-center justify-between mb-3 md:hidden">
                            <h3 class="text-text-primary font-semibold text-base">{{ __('Conversations') }}</h3>
                            <button onclick="toggleMobileMenu()" class="text-text-muted hover:text-text-primary">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>

                        {{-- Search --}}
                        <div class="mt-3 sm:mt-4">
                            <div class="relative">
                                <input type="text" wire:model.live.debounce.300ms="searchTerm"
                                    placeholder="{{ __('Search') }}"
                                    class="w-full dark:bg-zinc-50/10 bg-zinc-100 text-text-white px-3 sm:px-4 py-2 pr-10 rounded-lg focus:outline-none focus:ring-2 focus:ring-zinc-500 text-xs sm:text-sm">
                                <button class="absolute right-2 sm:right-3 top-1/2 -translate-y-1/2 text-zinc-400">
                                    <flux:icon name="search" class="w-4 h-4 sm:w-5 sm:h-5" />
                                </button>
                            </div>
                        </div>
                    </div>

                    {{-- Conversations List --}}
                    <div class="flex-1 overflow-y-auto custom-scrollbar" wire:loading.remove
                        wire:target="unreadOnly,searchTerm">
                        @forelse($this->conversations as $conversation)
                            @php
                                $otherParticipant = $conversation->participants->first()?->participant;
                                $lastMessage = $conversation->messages->first();
                            @endphp

                            @if ($otherParticipant)
                                {{-- ✅ Use conversation_uuid not id --}}
                                <div wire:click="selectConversation('{{ $conversation->conversation_uuid }}')"
                                    onclick="selectMessageMobile()"
                                    class="flex items-center gap-2 sm:gap-3 p-3 sm:p-4 hover:bg-bg-hover cursor-pointer border-b border-zinc-800 transition-colors
                                        {{ $selectedConversationUuid === $conversation->conversation_uuid ? 'dark:bg-zinc-800 bg-zinc-200' : '' }}"
                                    wire:loading.class="opacity-60"
                                    wire:target="selectConversation('{{ $conversation->conversation_uuid }}')">

                                    {{-- Avatar --}}
                                    @if ($otherParticipant->avatar)
                                        <img src="{{ auth_storage_url($otherParticipant->avatar) }}"
                                            alt="{{ $otherParticipant->full_name }}"
                                            class="w-8 h-8 sm:w-10 sm:h-10 rounded-full object-cover flex-shrink-0">
                                    @else
                                        <div
                                            class="w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-gradient-to-br from-accent to-accent-foreground flex items-center justify-center text-white font-semibold text-xs sm:text-sm flex-shrink-0">
                                            {{ strtoupper(substr($otherParticipant->full_name, 0, 2)) }}
                                        </div>
                                    @endif

                                    {{-- Content --}}
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center justify-between mb-1">
                                            <h4 class="text-text-primary font-semibold text-xs sm:text-sm truncate">
                                                {{ $otherParticipant->full_name }}
                                            </h4>
                                            <span class="text-[10px] sm:text-xs text-text-muted whitespace-nowrap ml-1">
                                                {{ $lastMessage?->created_at->diffForHumans() ?? '' }}
                                            </span>
                                        </div>

                                        {{-- Subject (order id) --}}
                                        @if ($conversation->subject)
                                            <p class="text-[9px] sm:text-[10px] text-accent truncate mb-0.5">
                                                {{ $conversation->subject }}
                                            </p>
                                        @endif

                                        <p class="text-text-secondary text-[10px] sm:text-xs truncate">
                                            {{ $lastMessage ? \Illuminate\Support\Str::limit($lastMessage->message_body, 30) : __('No messages yet') }}
                                        </p>
                                    </div>

                                    {{-- Unread Badge --}}
                                    @if ($conversation->unread_count > 0)
                                        <div
                                            class="w-5 h-5 bg-accent rounded-full flex items-center justify-center flex-shrink-0">
                                            <span
                                                class="text-white text-[10px] font-bold">{{ $conversation->unread_count }}</span>
                                        </div>
                                    @endif
                                </div>
                            @endif
                        @empty
                            <div class="p-4 text-center text-text-muted text-sm">
                                {{ __('No conversations found') }}
                            </div>
                        @endforelse
                    </div>

                    <div class="space-y-4 p-3 sm:p-4" wire:loading wire:target="unreadOnly, searchTerm">
                        @foreach (range(1, 4) as $i)
                            <div class="flex gap-4 animate-pulse">
                                <div class="w-10 h-10 bg-zinc-200 dark:bg-zinc-800 rounded-full"></div>
                                <div class="flex-1 space-y-2 py-1">
                                    <div class="flex items-center justify-between gap-2">
                                        <div class="h-3 bg-zinc-200 dark:bg-zinc-800 rounded w-1/4"></div>
                                        <div class="h-3 bg-zinc-200 dark:bg-zinc-800 rounded w-1/4"></div>
                                    </div>
                                    <div class="h-1 bg-zinc-200 dark:bg-zinc-800 rounded w-3/4"></div>
                                    <div class="h-1 bg-zinc-200 dark:bg-zinc-800 rounded w-3/4"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Right Side - Chat Area --}}
                <div class="flex-1 flex flex-col min-h-[50vh] md:min-h-[20vh] rounded-lg bg-bg-secondary">
                    <livewire:backend.user.chat.message :key="'message-' . ($selectedConversationId ?? 'empty')" />
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleMobileMenu() {
            const sidebar = document.getElementById('messagesSidebar');
            const overlay = document.getElementById('mobileOverlay');
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        }

        function selectMessageMobile() {
            if (window.innerWidth < 768) {
                toggleMobileMenu();
            }
        }
    </script>

    <script>
        const userId = {{ auth()->id() }};
        let conversationPollingInterval = null;

        // ====================================================
        // POLLING (comment out block below if using broadcasting)
        // ====================================================
        function startConversationPolling() {
            if (conversationPollingInterval) clearInterval(conversationPollingInterval);
            conversationPollingInterval = setInterval(() => {
                const component = Livewire.find('{{ $this->getId() }}');
                if (component) component.call('pollForConversationUpdates');
            }, 3000); // ✅ 3s is enough for sidebar - save resources
        }

        function stopConversationPolling() {
            if (conversationPollingInterval) {
                clearInterval(conversationPollingInterval);
                conversationPollingInterval = null;
            }
        }

        document.addEventListener('livewire:initialized', () => startConversationPolling());
        document.addEventListener('livewire:navigating', () => stopConversationPolling());

        document.addEventListener('visibilitychange', () => {
            document.hidden ? stopConversationPolling() : startConversationPolling();
        });
    </script>
</div>
