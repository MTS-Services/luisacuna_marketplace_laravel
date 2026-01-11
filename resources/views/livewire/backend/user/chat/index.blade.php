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

                    <!-- Mobile Menu Toggle Button -->
                    <button onclick="toggleMobileMenu()"
                        class="md:hidden bg-accent text-white px-3 py-2 rounded-lg text-xs font-medium flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                        {{ __('Conversations') }}
                    </button>
                </div>

                <!-- Filters -->
                <div class="flex flex-col sm:flex-row items-center justify-between mb-3 gap-3 sm:gap-4">
                    <div
                        class="flex items-center gap-3 sm:gap-5 border border-zinc-500 px-3 py-1 w-full sm:w-auto justify-between rounded-md">
                        <span class="text-xs sm:text-sm text-text-secondary">{{ __('Unread message only') }}</span>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" wire:model.live="unreadOnly" class="sr-only peer">
                            <div
                                class="w-7 h-4 bg-zinc-700 rounded-full peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-accent transition-colors
                                peer-checked:bg-accent after:content-[''] after:absolute after:top-[2px] after:left-[2px]
                                after:bg-white after:rounded-full after:h-3 after:w-3 after:transition-all
                                peer-checked:after:translate-x-4">
                            </div>
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

                <!-- Mark all as read -->
                <a href="#" wire:click.prevent="markAllAsRead"
                    class="text-xs sm:text-sm text-pink-500 hover:text-pink-400 transition-colors">
                    {{ __('Mark all as read') }}
                </a>
            </div>

            <div class="flex flex-col md:flex-row h-auto md:h-[68vh] gap-2 px-3 sm:px-4 relative">
                {{-- Mobile Overlay --}}
                <div id="mobileOverlay" onclick="toggleMobileMenu()"
                    class="hidden fixed inset-0 bg-black bg-opacity-50 z-40 md:hidden"></div>

                {{-- Left Sidebar - Messages List --}}
                <div id="messagesSidebar"
                    class="fixed md:static inset-y-0 left-0 transform -translate-x-full md:translate-x-0 transition-transform duration-300 ease-in-out z-30 w-full md:w-64 lg:w-72 xl:w-80 2xl:w-96 bg-bg-secondary rounded-lg flex flex-col md:mr-5 mb-1 md:mb-0 max-h-full md:max-h-full">

                    <div class="p-3 sm:p-4">
                        {{-- Close Button for Mobile --}}
                        <div class="flex items-center justify-between mb-3 md:hidden">
                            <h3 class="text-text-primary font-semibold text-base">{{ __('Conversations') }}</h3>
                            <button onclick="toggleMobileMenu()" class="text-text-muted hover:text-text-primary">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"></path>
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
                                    <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    {{-- Conversations List --}}
                    <div class="flex-1 overflow-y-auto custom-scrollbar">
                        @forelse($this->conversations as $conversation)
                            @php
                                $otherParticipant = $conversation->participants->first()?->participant;
                                $lastMessage = $conversation->messages->first();
                            @endphp

                            @if ($otherParticipant)
                                <div wire:click="selectConversation({{ $conversation->id }})" onclick="selectMessage()"
                                    class="flex items-center gap-2 sm:gap-3 p-3 sm:p-4 hover:bg-bg-hover cursor-pointer border-b border-zinc-800 
                                        {{ $selectedConversationId == $conversation->id ? 'dark:bg-zinc-800 bg-zinc-200' : '' }} transition-colors">

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
                                            <span class="text-[10px] sm:text-xs text-text-muted">
                                                {{ $lastMessage?->created_at->diffForHumans() ?? '' }}
                                            </span>
                                        </div>
                                        <p class="text-text-secondary text-[10px] sm:text-xs truncate">
                                            {{ $lastMessage ? \Illuminate\Support\Str::limit($lastMessage->message_body, 30) : 'No messages yet' }}
                                        </p>
                                    </div>

                                    {{-- Unread Count --}}
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
                </div>

                {{-- Right Side - Chat Area --}}
                <div class="flex-1 flex flex-col min-h-[50vh] md:min-h-[20vh] rounded-lg bg-bg-secondary">
                    <livewire:backend.user.chat.message :key="'message-' . $selectedConversationId" />
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

        function selectMessage() {
            if (window.innerWidth < 768) {
                toggleMobileMenu();
            }
        }
    </script>

    @script
        <script>
            const userId = {{ auth()->id() }};
            let conversationPollingInterval = null;

            console.log('👤 User ID:', userId);

            // ====================================================
            // METHOD 1: WITH BROADCASTING (PUSHER/REVERB) START
            // ====================================================
            // Uncomment this block to use WebSocket broadcasting for conversation updates
            /*
            console.log('🔌 Listening on user channel with Broadcasting:', `user.${userId}`);

            window.Echo.private(`user.${userId}`)
                .listen('.conversation.updated', (event) => {
                    console.log('🔔 Conversation updated via WebSocket:', event);

                    // Refresh conversations list
                    $wire.$refresh();
                });

            // Cleanup
            document.addEventListener('livewire:navigating', () => {
                window.Echo.leave(`user.${userId}`);
            });
            */

            // ====================================================
            // METHOD 1: WITH BROADCASTING (PUSHER/REVERB) END
            // ====================================================

            // ====================================================
            // METHOD 2: WITHOUT BROADCASTING (POLLING) START
            // ====================================================
            // Comment this block if using broadcasting above
            console.log('🔄 Starting conversation polling for user:', userId);

            function startConversationPolling() {
                if (conversationPollingInterval) {
                    clearInterval(conversationPollingInterval);
                }

                // Poll every 500 milliseconds for conversation list updates
                conversationPollingInterval = setInterval(() => {
                    const component = Livewire.find('{{ $this->getId() }}');
                    if (component) {
                        component.call('pollForConversationUpdates');
                    }
                }, 500); // Poll every 500 milliseconds
            }

            function stopConversationPolling() {
                if (conversationPollingInterval) {
                    clearInterval(conversationPollingInterval);
                    conversationPollingInterval = null;
                }
            }

            // Start polling when page loads
            document.addEventListener('livewire:initialized', () => {
                startConversationPolling();
            });

            // Stop polling when navigating away
            document.addEventListener('livewire:navigating', () => {
                stopConversationPolling();
            });

            // Pause polling when tab is not visible (saves resources)
            document.addEventListener('visibilitychange', () => {
                if (document.hidden) {
                    stopConversationPolling();
                } else {
                    startConversationPolling();
                }
            });

            // ====================================================
            // METHOD 2: WITHOUT BROADCASTING (POLLING) END
            // ====================================================
        </script>
    @endscript
</div>
