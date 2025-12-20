<div class="flex flex-col h-full">
    @if ($conversation)
        {{-- Chat Header --}}
        <div class="p-3 sm:p-4 flex items-center bg-zinc-50/10 rounded-t-lg justify-between">
            <div class="flex items-center gap-2 sm:gap-3">
                @if ($otherParticipant)
                    @if ($otherParticipant->avatar)
                        <img src="{{ storage_url($otherParticipant->avatar) }}" alt="{{ $otherParticipant->full_name }}"
                            class="w-8 h-8 sm:w-10 sm:h-10 rounded-full object-cover flex-shrink-0">
                    @else
                        <div
                            class="w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-gradient-to-br from-accent to-accent-foreground flex items-center justify-center text-white font-semibold text-xs sm:text-sm flex-shrink-0">
                            {{ strtoupper(substr($otherParticipant->full_name, 0, 2)) }}
                        </div>
                    @endif

                    <div>
                        <h3 class="text-text-primary font-semibold text-sm sm:text-base">
                            {{ $otherParticipant->full_name }}
                        </h3>
                        <p class="text-text-secondary text-xs sm:text-sm">{{ __('Available') }}</p>
                    </div>
                @endif
            </div>
        </div>

        {{-- Messages Area --}}
        <div class="flex-1 overflow-y-auto custom-scrollbar p-3 sm:p-4 md:p-6 space-y-4 sm:space-y-6"
            id="messagesContainer" data-conversation-id="{{ $conversation->id }}">

            @forelse($messages as $msg)
                <div class="message-item" data-message-id="{{ $msg->id }}">
                    @if ($msg->sender_id == auth()->id())
                        {{-- Current User Message --}}
                        <div class="flex items-start gap-2 sm:gap-3 flex-row-reverse">
                            @if (auth()->user()->avatar)
                                <img src="{{ auth_storage_url(auth()->user()->avatar) }}"
                                    alt="{{ auth()->user()->full_name }}"
                                    class="w-8 h-8 sm:w-10 sm:h-10 rounded-full object-cover flex-shrink-0">
                            @else
                                <div
                                    class="w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-gradient-to-br from-accent to-accent-foreground flex items-center justify-center text-white font-semibold text-xs sm:text-sm flex-shrink-0">
                                    {{ strtoupper(substr(auth()->user()->full_name, 0, 2)) }}
                                </div>
                            @endif

                            <div class="flex flex-col gap-1 sm:gap-2 max-w-[75%] sm:max-w-md items-end">
                                {{-- Attachments --}}
                                @if ($msg->attachments && $msg->attachments->count() > 0)
                                    @foreach ($msg->attachments as $attachment)
                                        <div class="relative mb-2">
                                            @if (in_array($attachment->attachment_type->value, ['image', 'photo']))
                                                <img src="{{ asset('storage/' . $attachment->file_path) }}"
                                                    class="rounded-lg max-w-full max-h-64 object-cover">
                                            @else
                                                <a href="{{ asset('storage/' . $attachment->file_path) }}"
                                                    class="flex items-center gap-2 bg-bg-hover px-3 py-2 rounded-lg text-text-primary text-xs">
                                                    📎 {{ basename($attachment->file_path) }}
                                                </a>
                                            @endif

                                            <a href="{{ asset('storage/' . $attachment->file_path) }}" download
                                                class="absolute top-1 right-1 bg-black bg-opacity-50 text-white px-2 py-1 text-xs rounded hover:bg-opacity-70">
                                                ⬇
                                            </a>
                                        </div>
                                    @endforeach
                                @endif

                                {{-- Message Body --}}
                                @if ($msg->message_body)
                                    <div
                                        class="bg-gradient-to-r from-accent to-accent-foreground text-white px-3 sm:px-4 py-2 sm:py-3 rounded-2xl rounded-tr-none relative group">
                                        <p class="text-xs sm:text-sm break-words">{{ $msg->message_body }}</p>

                                        {{-- Message options --}}
                                        <button wire:click="deleteMessage({{ $msg->id }})"
                                            class="absolute -left-8 top-1/2 -translate-y-1/2 opacity-0 group-hover:opacity-100 transition-opacity text-red-500 hover:text-red-700">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                </path>
                                            </svg>
                                        </button>
                                    </div>
                                @endif

                                <span class="text-[10px] sm:text-xs text-text-muted">
                                    {{ $msg->created_at->format('M d, Y h:i A') }}
                                    @if ($msg->readReceipts && $msg->readReceipts->where('reader_id', '!=', auth()->id())->count() > 0)
                                        <span class="text-blue-500">✓✓</span>
                                    @else
                                        <span class="text-gray-400">✓</span>
                                    @endif
                                </span>
                            </div>
                        </div>
                    @else
                        {{-- Other User Message --}}
                        <div class="flex items-start gap-2 sm:gap-3">
                            @php
                                $sender = $msg->sender;
                            @endphp

                            @if ($sender && $sender->avatar)
                                <img src="{{ storage_url($sender->avatar) }}" alt="{{ $sender->full_name }}"
                                    class="w-8 h-8 sm:w-10 sm:h-10 rounded-full object-cover flex-shrink-0">
                            @else
                                <div
                                    class="w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-gradient-to-br from-accent to-accent-foreground flex items-center justify-center text-white font-semibold text-xs sm:text-sm flex-shrink-0">
                                    {{ $sender ? strtoupper(substr($sender->full_name, 0, 2)) : 'S' }}
                                </div>
                            @endif

                            <div class="flex flex-col gap-1 sm:gap-2 max-w-[75%] sm:max-w-md">
                                {{-- Attachments --}}
                                @if ($msg->attachments && $msg->attachments->count() > 0)
                                    @foreach ($msg->attachments as $attachment)
                                        <div class="relative mb-2">
                                            @if (in_array($attachment->attachment_type->value, ['image', 'photo']))
                                                <img src="{{ asset('storage/' . $attachment->file_path) }}"
                                                    class="rounded-lg max-w-full max-h-64 object-cover">
                                            @else
                                                <a href="{{ asset('storage/' . $attachment->file_path) }}"
                                                    class="flex items-center gap-2 bg-bg-hover px-3 py-2 rounded-lg text-text-primary text-xs">
                                                    📎 {{ basename($attachment->file_path) }}
                                                </a>
                                            @endif

                                            <a href="{{ asset('storage/' . $attachment->file_path) }}" download
                                                class="absolute top-1 right-1 bg-black bg-opacity-50 text-white px-2 py-1 text-xs rounded hover:bg-opacity-70">
                                                ⬇
                                            </a>
                                        </div>
                                    @endforeach
                                @endif

                                {{-- Message Body --}}
                                @if ($msg->message_body)
                                    <div
                                        class="bg-bg-hover text-text-primary px-3 sm:px-4 py-2 sm:py-3 rounded-2xl rounded-tl-none">
                                        <p class="text-xs sm:text-sm break-words">{{ $msg->message_body }}</p>
                                    </div>
                                @endif

                                <span class="text-[10px] sm:text-xs text-text-muted">
                                    {{ $msg->created_at->format('M d, Y h:i A') }}
                                </span>
                            </div>
                        </div>
                    @endif
                </div>
            @empty
                <div class="flex items-center justify-center h-full text-text-muted text-sm">
                    {{ __('No messages yet. Start the conversation!') }}
                </div>
            @endforelse
        </div>

        {{-- Scroll to bottom button (shown when user scrolls up) --}}
        <div id="scrollToBottomBtn"
            class="hidden absolute bottom-24 right-8 bg-accent text-white p-3 rounded-full shadow-lg cursor-pointer hover:bg-accent-foreground transition-colors z-10"
            onclick="scrollToBottom(true)">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3">
                </path>
            </svg>
            <span id="newMessageCount"
                class="hidden absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full w-6 h-6 flex items-center justify-center">0</span>
        </div>

        {{-- Message Input --}}
        <div class="p-3 sm:p-4 border-t border-zinc-700">
            <form wire:submit.prevent="sendMessage">
                <div class="flex items-end gap-2 sm:gap-3">
                    <div class="flex-1 relative">
                        <textarea wire:model="message" wire:keydown.enter.prevent="sendMessage" rows="1"
                            placeholder="{{ __('Type a message...') }}"
                            class="w-full bg-bg-hover text-text-white px-3 sm:px-4 py-2 sm:py-3 pr-12 sm:pr-14 rounded-lg border border-zinc-700 focus:outline-none focus:ring-2 focus:ring-accent resize-none text-xs sm:text-sm"
                            style="min-height: 40px; max-height: 120px;" @if ($isLoading) disabled @endif></textarea>

                        <div class="absolute right-2 sm:right-3 bottom-3 sm:bottom-4 flex items-center gap-1 sm:gap-2">
                            <label class="cursor-pointer text-text-muted hover:text-text-primary transition-colors">
                                <input type="file" wire:model="media" class="hidden"
                                    accept="image/*,video/*,audio/*,.pdf,.doc,.docx" multiple>
                                <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13">
                                    </path>
                                </svg>
                            </label>

                            <button type="submit"
                                class="text-text-muted hover:text-text-primary transition-colors disabled:opacity-50"
                                @if ($isLoading) disabled @endif>
                                @if ($isLoading)
                                    <svg class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10"
                                            stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor"
                                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                        </path>
                                    </svg>
                                @else
                                    <svg class="w-5 h-5 -rotate-45" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                    </svg>
                                @endif
                            </button>
                        </div>
                    </div>
                </div>

                @if ($media)
                    <div class="mt-2 flex flex-wrap gap-2">
                        @if (is_array($media))
                            @foreach ($media as $index => $file)
                                <div class="relative inline-block">
                                    <span class="text-xs text-text-secondary bg-bg-hover px-2 py-1 rounded">
                                        {{ $file->getClientOriginalName() }}
                                    </span>
                                    <button type="button" wire:click="$set('media.{{ $index }}', null)"
                                        class="absolute -top-1 -right-1 bg-red-500 text-white rounded-full w-4 h-4 flex items-center justify-center text-xs">
                                        ×
                                    </button>
                                </div>
                            @endforeach
                        @else
                            <div class="relative inline-block">
                                <span class="text-xs text-text-secondary bg-bg-hover px-2 py-1 rounded">
                                    {{ $media->getClientOriginalName() }}
                                </span>
                                <button type="button" wire:click="$set('media', null)"
                                    class="absolute -top-1 -right-1 bg-red-500 text-white rounded-full w-4 h-4 flex items-center justify-center text-xs">
                                    ×
                                </button>
                            </div>
                        @endif
                    </div>
                @endif
            </form>
        </div>
    @else
        {{-- No Conversation Selected --}}
        <div class="flex-1 flex items-center justify-center text-text-muted">
            <div class="text-center">
                <svg class="w-16 h-16 mx-auto mb-3 text-zinc-600" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                </svg>
                <p class="text-sm">{{ __('Select a conversation to start chatting') }}</p>
            </div>
        </div>
    @endif
</div>

@script
    <script>
        let conversationChannel = null;
        let isUserAtBottom = true;
        let newMessageCount = 0;
        let intersectionObserver = null;
        let scrollTimeout = null;

        // Initialize Intersection Observer for read receipts
        function initIntersectionObserver() {
            if (intersectionObserver) {
                intersectionObserver.disconnect();
            }

            const container = document.getElementById('messagesContainer');
            if (!container) return;

            intersectionObserver = new IntersectionObserver((entries) => {
                const visibleMessageIds = [];

                entries.forEach(entry => {
                    if (entry.isIntersecting && entry.intersectionRatio >= 0.5) {
                        const messageId = entry.target.dataset.messageId;
                        if (messageId) {
                            visibleMessageIds.push(parseInt(messageId));
                        }
                    }
                });

                if (visibleMessageIds.length > 0) {
                    $wire.call('markVisibleMessagesAsRead', visibleMessageIds);
                }
            }, {
                root: container,
                threshold: [0.5], // Message must be 50% visible
                rootMargin: '0px'
            });

            // Observe all message items
            document.querySelectorAll('.message-item').forEach(item => {
                intersectionObserver.observe(item);
            });
        }

        // Track scroll position
        function handleScroll() {
            const container = document.getElementById('messagesContainer');
            if (!container) return;

            clearTimeout(scrollTimeout);
            scrollTimeout = setTimeout(() => {
                const scrollTop = container.scrollTop;
                const scrollHeight = container.scrollHeight;
                const clientHeight = container.clientHeight;
                const distanceFromBottom = scrollHeight - scrollTop - clientHeight;

                // User is at bottom if within 100px
                isUserAtBottom = distanceFromBottom < 100;

                // Update Livewire component
                $wire.call('updateScrollPosition', isUserAtBottom);

                // Show/hide scroll to bottom button
                const btn = document.getElementById('scrollToBottomBtn');
                if (btn) {
                    if (!isUserAtBottom && newMessageCount > 0) {
                        btn.classList.remove('hidden');
                    } else {
                        btn.classList.add('hidden');
                        newMessageCount = 0;
                        updateNewMessageCount();
                    }
                }
            }, 150);
        }

        // Scroll to bottom function
        function scrollToBottom(smooth = false) {
            const container = document.getElementById('messagesContainer');
            if (!container) return;

            container.scrollTo({
                top: container.scrollHeight,
                behavior: smooth ? 'smooth' : 'auto'
            });

            isUserAtBottom = true;
            newMessageCount = 0;
            updateNewMessageCount();
            document.getElementById('scrollToBottomBtn')?.classList.add('hidden');
        }

        // Update new message count badge
        function updateNewMessageCount() {
            const countBadge = document.getElementById('newMessageCount');
            if (countBadge) {
                if (newMessageCount > 0) {
                    countBadge.textContent = newMessageCount;
                    countBadge.classList.remove('hidden');
                } else {
                    countBadge.classList.add('hidden');
                }
            }
        }

        // Play notification sound
        function playNotificationSound() {
            try {
                const audio = new Audio('/sounds/notification.mp3');
                audio.volume = 0.3;
                audio.play().catch(e => console.log('Audio blocked'));
            } catch (e) {
                console.log('Notification sound error:', e);
            }
        }

        // Listen for conversation selection
        Livewire.on('conversation-selected', (data) => {
            const conversationId = data.conversationId || data[0]?.conversationId || data[0];

            // Leave previous channel
            if (conversationChannel) {
                window.Echo.leave(conversationChannel);
            }

            // Reset state
            newMessageCount = 0;
            isUserAtBottom = true;
            updateNewMessageCount();

            // Join new conversation channel
            if (conversationId) {
                conversationChannel = `conversation.${conversationId}`;

                console.log('🔌 Joining channel:', conversationChannel);

                // window.Echo.private(conversationChannel)
                //     .listen('.message.sent', (event) => {
                //         console.log('📨 New message received:', event);

                //         // Dispatch to Livewire
                //         $wire.dispatch('new-message-received', { messageData: event });

                //         // Play sound if not from current user
                //         if (event.sender_id !== {{ auth()->id() }}) {
                //             playNotificationSound();

                //             // If user is not at bottom, increment count
                //             if (!isUserAtBottom) {
                //                 newMessageCount++;
                //                 updateNewMessageCount();
                //                 document.getElementById('scrollToBottomBtn')?.classList.remove('hidden');
                //             }
                //         }
                //     });

                window.Echo.private(conversationChannel)
                    .listen('.message.sent', (event) => {
                        console.log('📨 New message received:', event);

                        // ✅ Fixed dispatch
                        $wire.dispatch('new-message-received', {
                            messageData: event
                        });

                        if (event.sender_id !== {{ auth()->id() }}) {
                            // playNotificationSound();

                            if (!isUserAtBottom) {
                                newMessageCount++;
                                updateNewMessageCount();
                                document.getElementById('scrollToBottomBtn')?.classList.remove('hidden');
                            }
                        }
                    });
            }
        });

        // Listen for conversation loaded
        Livewire.on('conversation-loaded', () => {
            setTimeout(() => {
                scrollToBottom(false);
                initIntersectionObserver();

                // Attach scroll listener
                const container = document.getElementById('messagesContainer');
                if (container) {
                    container.removeEventListener('scroll', handleScroll);
                    container.addEventListener('scroll', handleScroll);
                }
            }, 100);
        });

        // Listen for scroll to bottom event
        Livewire.on('scroll-to-bottom', () => {
            setTimeout(() => scrollToBottom(true), 100);
        });

        // Listen for check scroll position
        Livewire.on('check-scroll-position', () => {
            // If user is at bottom, auto-scroll to new message
            if (isUserAtBottom) {
                setTimeout(() => {
                    scrollToBottom(true);
                    initIntersectionObserver(); // Re-observe after new messages
                }, 100);
            } else {
                // User is scrolled up, just re-observe
                setTimeout(() => initIntersectionObserver(), 100);
            }
        });

        // Cleanup on navigation
        document.addEventListener('livewire:navigating', () => {
            if (conversationChannel) {
                window.Echo.leave(conversationChannel);
            }
            if (intersectionObserver) {
                intersectionObserver.disconnect();
            }
            const container = document.getElementById('messagesContainer');
            if (container) {
                container.removeEventListener('scroll', handleScroll);
            }
        });

        // Initialize on load
        document.addEventListener('livewire:init', () => {
            setTimeout(() => {
                if (document.getElementById('messagesContainer')) {
                    initIntersectionObserver();
                }
            }, 500);
        });
    </script>
@endscript
