<div class="flex flex-col h-full relative">

    {{-- ✅ SKELETON LOADER - shows instantly while conversation loads --}}
    <div id="conversationSkeleton" class="hidden flex-col h-full animate-pulse">
        {{-- Skeleton Header --}}
        <div class="p-3 sm:p-4 flex items-center bg-zinc-500 rounded-t-lg gap-3">
            <div class="w-10 h-10 rounded-full bg-zinc-600 flex-shrink-0"></div>
            <div class="flex-1">
                <div class="h-4 bg-zinc-600 rounded w-32 mb-2"></div>
                <div class="h-3 bg-zinc-700 rounded w-20"></div>
            </div>
        </div>
        {{-- Skeleton Messages --}}
        <div class="flex-1 p-4 space-y-4 overflow-hidden">
            <div class="flex items-end gap-2 flex-row-reverse">
                <div class="h-10 bg-zinc-700 rounded-2xl rounded-tr-none w-48"></div>
            </div>
            <div class="flex items-end gap-2">
                <div class="w-8 h-8 rounded-full bg-zinc-600"></div>
                <div class="h-10 bg-zinc-700 rounded-2xl rounded-tl-none w-64"></div>
            </div>
            <div class="flex items-end gap-2 flex-row-reverse">
                <div class="h-10 bg-zinc-700 rounded-2xl rounded-tr-none w-40"></div>
            </div>
            <div class="flex items-end gap-2">
                <div class="w-8 h-8 rounded-full bg-zinc-600"></div>
                <div class="h-14 bg-zinc-700 rounded-2xl rounded-tl-none w-72"></div>
            </div>
        </div>
        {{-- Skeleton Input --}}
        <div class="p-4 border-t border-zinc-700">
            <div class="h-10 bg-zinc-700 rounded-lg w-full"></div>
        </div>
    </div>

    @if ($conversation)
        {{-- ✅ CHAT HEADER --}}
        <div class="p-3 sm:p-4 flex items-center bg-zinc-500 rounded-t-lg justify-between flex-shrink-0">
            <div class="flex items-center gap-2 sm:gap-3">
                @if ($otherParticipant)
                    <div class="bg-bg-primary dark:bg-bg-secondary rounded-full p-0.5 relative">
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
                        {{-- Online indicator placeholder --}}
                        <span
                            class="absolute bottom-0 right-0 w-2.5 h-2.5 bg-green-500 rounded-full border-2 border-zinc-500"></span>
                    </div>

                    <div>
                        <h3 class="text-gray-50 font-semibold text-sm sm:text-base leading-tight">
                            {{ $otherParticipant->full_name }}
                        </h3>
                        @if ($conversation->subject)
                            <p class="text-gray-100 text-[10px] sm:text-xs leading-tight">{{ $conversation->subject }}</p>
                        @else
                            <p class="text-gray-100 text-xs sm:text-sm">{{ __('Available') }}</p>
                        @endif
                    </div>
                @endif
            </div>

            {{-- Load more button (top) --}}
            @if ($hasMoreMessages)
                <button wire:click="loadMoreMessages"
                    class="text-xs text-accent hover:underline px-2 py-1 rounded transition-colors">
                    {{ __('Load older messages') }}
                </button>
            @endif
        </div>

        {{-- ✅ MESSAGES AREA --}}
        <div class="flex-1 overflow-y-auto custom-scrollbar p-3 sm:p-4 md:p-6 space-y-4 sm:space-y-5"
            id="messagesContainer" data-conversation-id="{{ $conversation->id }}">

            @forelse($messages as $msg)
                @php
                    $cloudinaryService = app(\App\Services\Cloudinary\CloudinaryService::class);
                    $isMine = $msg->sender_id == auth()->id();
                    $sender = $msg->sender;
                @endphp

                <div class="message-item" data-message-id="{{ $msg->id }}">

                    @if ($isMine)
                        {{-- ===================== MY MESSAGE ===================== --}}
                        <div class="flex items-end gap-2 sm:gap-3 flex-row-reverse">
                            <div class="flex flex-col gap-1 max-w-[75%] sm:max-w-md items-end">

                                @if ($msg->attachments && $msg->attachments->count() > 0)
                                    @foreach ($msg->attachments as $attachment)
                                        @php $fileUrl = $cloudinaryService->getUrlFromPublicId($attachment->file_path); @endphp
                                        <div class="relative mb-1">
                                            @if (in_array($attachment->attachment_type->value, ['image', 'photo']))
                                                <img src="{{ storage_url($attachment->file_path) }}"
                                                    wire:click="ShowAttachemntImage('{{ $fileUrl }}')"
                                                    alt="Image"
                                                    class="rounded-lg max-w-full max-h-64 object-cover cursor-pointer hover:opacity-90 transition-opacity" />
                                            @else
                                                <a href="{{ $fileUrl }}"
                                                    class="flex items-center gap-2 bg-bg-hover px-3 py-2 rounded-lg text-text-primary text-xs">
                                                    📎 {{ basename($fileUrl) }}
                                                </a>
                                            @endif
                                            <a href="{{ $fileUrl }}" download
                                                class="absolute top-1 right-1 bg-black bg-opacity-50 text-white px-2 py-1 text-xs rounded hover:bg-opacity-70 transition-opacity">
                                                ⬇
                                            </a>
                                        </div>
                                    @endforeach
                                @endif

                                @if ($msg->message_body)
                                    <div
                                        class="bg-gradient-to-r from-accent to-accent-foreground text-white px-3 sm:px-4 py-2 sm:py-3 rounded-2xl rounded-tr-none relative group">
                                        <p class="text-xs sm:text-sm break-words whitespace-pre-wrap">
                                            {{ $msg->message_body }}</p>

                                        {{-- Delete button --}}
                                        <button type="button" wire:click="deleteMessage({{ $msg->id }})"
                                            wire:confirm="Delete this message?"
                                            class="absolute -left-7 top-1/2 -translate-y-1/2 opacity-0 group-hover:opacity-100 transition-opacity text-red-400 hover:text-red-600">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </div>
                                @endif

                                <span class="text-[10px] sm:text-xs text-text-muted flex items-center gap-1">
                                    {{ $msg->created_at->format('M d, h:i A') }}
                                    @if ($msg->readReceipts && $msg->readReceipts->where('reader_id', '!=', auth()->id())->count() > 0)
                                        <span class="text-blue-400 font-bold">✓✓</span>
                                    @else
                                        <span class="text-zinc-500">✓</span>
                                    @endif
                                </span>
                            </div>
                        </div>
                    @else
                        {{-- ===================== THEIR MESSAGE ===================== --}}

                        @if ($sender)
                            {{-- Regular user message --}}
                            <div class="flex items-end gap-2 sm:gap-3">
                                @if ($sender->avatar)
                                    <img src="{{ auth_storage_url($sender->avatar) }}" alt="{{ $sender->full_name }}"
                                        class="w-8 h-8 sm:w-10 sm:h-10 rounded-full object-cover flex-shrink-0 border-2 border-zinc-600 self-end" />
                                @else
                                    <div
                                        class="w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-gradient-to-br from-accent to-accent-foreground border-2 border-zinc-600 flex items-center justify-center text-white font-semibold text-xs sm:text-sm flex-shrink-0 self-end">
                                        {{ strtoupper(substr($sender->full_name ?? 'U', 0, 2)) }}
                                    </div>
                                @endif

                                <div class="flex flex-col gap-1 max-w-[75%] sm:max-w-md">
                                    @if ($msg->attachments && $msg->attachments->count() > 0)
                                        @foreach ($msg->attachments as $attachment)
                                            @php $fileUrl = $cloudinaryService->getUrlFromPublicId($attachment->file_path); @endphp
                                            <div class="relative mb-1">
                                                @if (in_array($attachment->attachment_type->value, ['image', 'photo']))
                                                    <img src="{{ storage_url($attachment->file_path) }}"
                                                        wire:click="ShowAttachemntImage('{{ $fileUrl }}')"
                                                        alt="Image"
                                                        class="rounded-lg max-w-full max-h-64 object-cover cursor-pointer hover:opacity-90 transition-opacity" />
                                                @else
                                                    <a href="{{ $fileUrl }}"
                                                        class="flex items-center gap-2 bg-bg-hover px-3 py-2 rounded-lg text-text-primary text-xs">
                                                        📎 {{ basename($fileUrl) }}
                                                    </a>
                                                @endif
                                                <a href="{{ $fileUrl }}" download
                                                    class="absolute top-1 right-1 bg-black bg-opacity-50 text-white px-2 py-1 text-xs rounded hover:bg-opacity-70">
                                                    ⬇
                                                </a>
                                            </div>
                                        @endforeach
                                    @endif

                                    @if ($msg->message_body)
                                        <div
                                            class="bg-bg-hover text-text-primary px-3 sm:px-4 py-2 sm:py-3 rounded-2xl rounded-tl-none">
                                            <p class="text-xs sm:text-sm break-words whitespace-pre-wrap">
                                                {{ $msg->message_body }}</p>
                                        </div>
                                    @endif

                                    <span class="text-[10px] sm:text-xs text-text-muted">
                                        {{ $msg->created_at->format('M d, h:i A') }}
                                    </span>
                                </div>
                            </div>
                        @else
                            {{-- ===== SYSTEM / ORDER NOTIFICATION MESSAGE ===== --}}
                            <div class="flex justify-center my-3">
                                <div
                                    class="bg-bg-info border-l-4 border-accent rounded-xl px-4 py-3 w-full max-w-lg shadow-sm">
                                    @if ($msg->metadata && isset($msg->metadata['order_uid']))
                                        <p
                                            class="text-[10px] text-text-muted uppercase tracking-wider mb-1 font-medium">
                                            {{ __('Order Notification') }}
                                        </p>
                                    @endif

                                    @if ($msg->message_body)
                                        <p class="text-xs sm:text-sm text-text-primary break-words">
                                            {{ $msg->message_body }}</p>
                                    @endif

                                    @if ($msg->metadata && isset($msg->metadata['order_status']))
                                        <span
                                            class="inline-block mt-2 text-[10px] px-2 py-0.5 rounded-full bg-accent/20 text-accent font-medium">
                                            {{ ucfirst($msg->metadata['order_status']) }}
                                        </span>
                                    @endif

                                    <p class="text-[10px] sm:text-xs text-text-muted text-right mt-1">
                                        {{ $msg->created_at->format('M d, h:i A') }}
                                    </p>
                                </div>
                            </div>
                        @endif
                    @endif
                </div>
            @empty
                <div class="flex items-center justify-center h-full text-text-muted text-sm py-10">
                    <div class="text-center">
                        <svg class="w-12 h-12 mx-auto mb-3 text-zinc-600" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                        </svg>
                        <p class="text-sm">{{ __('No messages yet. Start the conversation!') }}</p>
                    </div>
                </div>
            @endforelse
        </div>

        {{-- Scroll to bottom FAB --}}
        <div id="scrollToBottomBtn"
            class="hidden absolute bottom-24 right-4 bg-accent text-white p-2.5 rounded-full shadow-xl cursor-pointer hover:bg-accent/90 transition-all z-10 flex items-center gap-1"
            onclick="scrollToBottom(true)">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M19 14l-7 7m0 0l-7-7m7 7V3" />
            </svg>
            <span id="newMessageCount"
                class="hidden bg-red-500 text-white text-[10px] font-bold rounded-full min-w-[18px] h-[18px] flex items-center justify-center px-1">0</span>
        </div>

        {{-- ===== IMAGE OVERLAY MODAL ===== --}}
        @if ($showImageOverlay && $selectedImageUrl)
            <div class="fixed inset-0 bg-black bg-opacity-90 z-50 flex items-center justify-center p-4"
                wire:click="closeImageOverlay">
                <button type="button" wire:click="closeImageOverlay"
                    class="absolute top-4 right-4 text-white hover:text-gray-300 z-50 bg-black/50 rounded-full p-1.5 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>

                <div class="relative max-w-7xl max-h-full" wire:click.stop>
                    <img src="{{ $selectedImageUrl }}" alt="Full size image"
                        class="max-w-full max-h-[90vh] object-contain cursor-zoom-in transition-transform duration-200"
                        id="zoomableImage" onclick="toggleZoom(event)">

                    <a href="{{ $selectedImageUrl }}" download
                        class="absolute bottom-4 right-4 bg-white text-gray-800 px-4 py-2 rounded-lg hover:bg-gray-100 flex items-center gap-2 text-sm font-medium">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                        </svg>
                        {{ __('Download') }}
                    </a>
                </div>
            </div>
        @endif

        {{-- ===== MESSAGE INPUT ===== --}}
        <div class="p-3 sm:p-4 border-t border-zinc-700 flex-shrink-0">
            <form wire:submit.prevent="sendMessage">
                {{-- Media previews --}}
                @if ($media)
                    <div class="flex flex-wrap gap-2 mb-2">
                        @if (is_array($media))
                            @foreach ($media as $index => $file)
                                <div class="relative inline-block">
                                    <img src="{{ $file->temporaryUrl() }}"
                                        class="w-14 h-14 rounded-lg object-cover border border-zinc-600" />
                                    <button type="button" wire:click="removeMedia({{ $index }})"
                                        class="absolute -top-1.5 -right-1.5 bg-red-500 text-white rounded-full w-5 h-5 flex items-center justify-center text-xs hover:bg-red-600 leading-none">
                                        ×
                                    </button>
                                </div>
                            @endforeach
                        @else
                            <div class="relative inline-block">
                                <img src="{{ $media->temporaryUrl() }}"
                                    class="w-14 h-14 rounded-lg object-cover border border-zinc-600" />
                                <button type="button" wire:click="$set('media', null)"
                                    class="absolute -top-1.5 -right-1.5 bg-red-500 text-white rounded-full w-5 h-5 flex items-center justify-center text-xs hover:bg-red-600 leading-none">
                                    ×
                                </button>
                            </div>
                        @endif
                    </div>
                @endif

                <div class="flex items-end gap-2 sm:gap-3">
                    <div class="flex-1 relative">
                        <textarea wire:model="message" wire:keydown.enter.prevent="sendMessage" id="messageInput" rows="1"
                            placeholder="{{ __('Type a message...') }}"
                            class="w-full bg-bg-hover text-text-white px-3 sm:px-4 py-2 sm:py-3 pr-20 rounded-xl border border-zinc-700 focus:outline-none focus:ring-2 focus:ring-accent resize-none text-xs sm:text-sm transition-colors"
                            style="min-height: 42px; max-height: 120px;" @if ($isLoading) disabled @endif></textarea>

                        <div
                            class="absolute right-2 sm:right-3 bottom-2.5 sm:bottom-3 flex items-center gap-1.5 sm:gap-2">
                            {{-- Attach file --}}
                            <label
                                class="cursor-pointer text-text-muted hover:text-accent transition-colors p-1 rounded">
                                <input type="file" wire:model="media" class="hidden"
                                    accept="image/*,video/*,audio/*,.pdf,.doc,.docx" multiple>
                                <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                                </svg>
                            </label>

                            {{-- Send --}}
                            <button type="submit"
                                class="text-accent hover:text-accent/80 transition-colors disabled:opacity-40 p-1 rounded"
                                @if ($isLoading || (empty(trim($message)) && !$media)) disabled @endif>
                                @if ($isLoading)
                                    <svg class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10"
                                            stroke="currentColor" stroke-width="4" />
                                        <path class="opacity-75" fill="currentColor"
                                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z" />
                                    </svg>
                                @else
                                    <svg class="w-5 h-5 -rotate-45" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                                    </svg>
                                @endif
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    @else
        {{-- ===== NO CONVERSATION SELECTED ===== --}}
        <div class="flex-1 flex items-center justify-center text-text-muted" id="emptyState">
            <div class="text-center px-4">
                <div class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-zinc-800 flex items-center justify-center">
                    <svg class="w-8 h-8 text-zinc-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                    </svg>
                </div>
                <p class="text-sm font-medium text-text-secondary">{{ __('Select a conversation to start chatting') }}
                </p>
                <p class="text-xs text-text-muted mt-1">{{ __('Choose from your conversations on the left') }}</p>
            </div>
        </div>
    @endif
</div>

@script
    <script>
        let isUserAtBottom = true;
        let newMessageCount = 0;
        let intersectionObserver = null;
        let scrollTimeout = null;
        let pollingInterval = null;
        let lastMessageId = null;
        let isZoomed = false;

        // ─── Scroll helpers ───────────────────────────────────────────────
        function scrollToBottom(smooth = false) {
            const container = document.getElementById('messagesContainer');
            if (!container) return;
            container.scrollTo({
                top: container.scrollHeight,
                behavior: smooth ? 'smooth' : 'instant'
            });
            isUserAtBottom = true;
            newMessageCount = 0;
            updateNewMessageCount();
            document.getElementById('scrollToBottomBtn')?.classList.add('hidden');
        }

        function handleScroll() {
            const container = document.getElementById('messagesContainer');
            if (!container) return;
            clearTimeout(scrollTimeout);
            scrollTimeout = setTimeout(() => {
                const dist = container.scrollHeight - container.scrollTop - container.clientHeight;
                isUserAtBottom = dist < 100;
                @this.set('isUserAtBottom', isUserAtBottom);
                const btn = document.getElementById('scrollToBottomBtn');
                if (btn) {
                    (!isUserAtBottom && newMessageCount > 0) ? btn.classList.remove('hidden'): btn.classList.add(
                        'hidden');
                    if (isUserAtBottom) {
                        newMessageCount = 0;
                        updateNewMessageCount();
                    }
                }
            }, 100);
        }

        function updateNewMessageCount() {
            const badge = document.getElementById('newMessageCount');
            if (!badge) return;
            if (newMessageCount > 0) {
                badge.textContent = newMessageCount;
                badge.classList.remove('hidden');
            } else {
                badge.classList.add('hidden');
            }
        }

        // ─── Intersection observer for read receipts ──────────────────────
        function initIntersectionObserver() {
            intersectionObserver?.disconnect();
            const container = document.getElementById('messagesContainer');
            if (!container) return;

            intersectionObserver = new IntersectionObserver((entries) => {
                const ids = [];
                entries.forEach(e => {
                    if (e.isIntersecting && e.intersectionRatio >= 0.5) {
                        const id = e.target.dataset.messageId;
                        if (id) ids.push(parseInt(id));
                    }
                });
                if (ids.length) @this.call('markVisibleMessagesAsRead', ids);
            }, {
                root: container,
                threshold: [0.5]
            });

            document.querySelectorAll('.message-item').forEach(el => intersectionObserver.observe(el));
        }

        // ─── Skeleton loader ──────────────────────────────────────────────
        function showSkeleton() {
            const sk = document.getElementById('conversationSkeleton');
            if (sk) {
                sk.classList.remove('hidden');
                sk.classList.add('flex');
            }
        }

        function hideSkeleton() {
            const sk = document.getElementById('conversationSkeleton');
            if (sk) {
                sk.classList.add('hidden');
                sk.classList.remove('flex');
            }
        }

        // ─── Polling ──────────────────────────────────────────────────────
        function startPolling() {
            stopPolling();
            pollingInterval = setInterval(() => {
                @this.call('pollForNewMessages').then((res) => {
                    if (res?.hasNewMessages && res.senderId !== {{ auth()->id() }}) {
                        playNotificationSound();
                        if (!isUserAtBottom) {
                            newMessageCount += res.newMessageCount || 1;
                            updateNewMessageCount();
                            document.getElementById('scrollToBottomBtn')?.classList.remove('hidden');
                        }
                    }
                });
            }, 800); // ✅ 800ms is smooth enough without hammering the server
        }

        function stopPolling() {
            if (pollingInterval) {
                clearInterval(pollingInterval);
                pollingInterval = null;
            }
        }

        function playNotificationSound() {
            try {
                const a = new Audio('/sounds/notification.mp3');
                a.volume = 0.3;
                a.play().catch(() => {});
            } catch {}
        }

        // ─── Livewire events ──────────────────────────────────────────────

        // ✅ Show skeleton instantly when a conversation is clicked
        Livewire.on('conversation-loading', () => {
            showSkeleton();
            stopPolling();
            newMessageCount = 0;
            isUserAtBottom = true;
            updateNewMessageCount();
        });

        Livewire.on('conversation-selected', (data) => {
            const conversationId = data[0]?.conversationId || data[0];
            lastMessageId = null;
            if (conversationId) startPolling();
        });

        Livewire.on('conversation-loaded', () => {
            hideSkeleton();
            setTimeout(() => {
                scrollToBottom(false);
                initIntersectionObserver();

                const container = document.getElementById('messagesContainer');
                if (container) {
                    container.removeEventListener('scroll', handleScroll);
                    container.addEventListener('scroll', handleScroll, {
                        passive: true
                    });
                }

                const lastMsg = document.querySelector('.message-item:last-child');
                if (lastMsg) lastMessageId = parseInt(lastMsg.dataset.messageId);

                // Auto-focus input
                document.getElementById('messageInput')?.focus();
            }, 50);
        });

        Livewire.on('scroll-to-bottom', () => {
            setTimeout(() => scrollToBottom(true), 50);
        });

        Livewire.on('check-scroll-position', () => {
            if (isUserAtBottom) {
                setTimeout(() => {
                    scrollToBottom(true);
                    initIntersectionObserver();
                }, 50);
            } else {
                setTimeout(() => initIntersectionObserver(), 50);
            }
        });

        Livewire.on('messages-updated', () => {
            const lastMsg = document.querySelector('.message-item:last-child');
            if (lastMsg) lastMessageId = parseInt(lastMsg.dataset.messageId);
        });

        Livewire.on('maintain-scroll-position', () => {
            // Preserve scroll when loading older messages
            const container = document.getElementById('messagesContainer');
            if (container) {
                const oldHeight = container.scrollHeight;
                setTimeout(() => {
                    container.scrollTop = container.scrollHeight - oldHeight;
                }, 0);
            }
        });

        Livewire.on('image-overlay-closed', () => {
            isZoomed = false;
        });

        // ─── Cleanup ──────────────────────────────────────────────────────
        document.addEventListener('livewire:navigating', () => {
            stopPolling();
            intersectionObserver?.disconnect();
            const container = document.getElementById('messagesContainer');
            container?.removeEventListener('scroll', handleScroll);
        });

        document.addEventListener('visibilitychange', () => {
            const container = document.getElementById('messagesContainer');
            if (document.hidden) {
                stopPolling();
            } else if (container?.dataset.conversationId) {
                startPolling();
            }
        });

        // ─── Image zoom ───────────────────────────────────────────────────
        window.toggleZoom = function(e) {
            const img = e.target;
            isZoomed = !isZoomed;
            img.style.transform = isZoomed ? 'scale(2)' : 'scale(1)';
            img.style.cursor = isZoomed ? 'zoom-out' : 'zoom-in';
        };

        // ─── Auto-resize textarea ─────────────────────────────────────────
        document.addEventListener('input', (e) => {
            if (e.target.id === 'messageInput') {
                e.target.style.height = 'auto';
                e.target.style.height = Math.min(e.target.scrollHeight, 120) + 'px';
            }
        });

        // Init on first render if already in a conversation
        setTimeout(() => {
            if (document.getElementById('messagesContainer')) {
                scrollToBottom(false);
                initIntersectionObserver();
                const container = document.getElementById('messagesContainer');
                container?.addEventListener('scroll', handleScroll, {
                    passive: true
                });
            }
        }, 100);
    </script>
@endscript
