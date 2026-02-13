<div class="flex flex-col h-full bg-main">
    @if ($conversation)
        {{-- ═══════════════════════════════════════════════════════════
             HEADER
        ═══════════════════════════════════════════════════════════ --}}
        <div class="flex-shrink-0 p-4 border-b border-gray-200 dark:border-gray-700 bg-bg-secondary dark:bg-bg-primary">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    {{-- Participants Avatars --}}
                    <div class="flex -space-x-2">
                        @foreach ($participants->take(3) as $participant)
                            @if ($participant['avatar'])
                                <img src="{{ storage_url($participant['avatar']) }}" alt="{{ $participant['name'] }}"
                                    class="w-9 h-9 rounded-full border-2 border-white dark:border-gray-800 ring-1 ring-gray-200 dark:ring-gray-700"
                                    title="{{ $participant['name'] }}">
                            @else
                                <div class="w-9 h-9 rounded-full border-2 border-white dark:border-gray-800
                                            {{ $participant['is_admin'] ? 'bg-purple-500' : 'bg-gradient-to-br from-primary-500 to-primary-600' }}
                                            flex items-center justify-center text-white text-xs font-bold"
                                    title="{{ $participant['name'] }}">
                                    {{ strtoupper(substr($participant['name'], 0, 2)) }}
                                </div>
                            @endif
                        @endforeach
                    </div>

                    <div>
                        <h3 class="text-sm font-semibold text-text-primary">
                            {{ $participants->pluck('name')->implode(', ') }}
                        </h3>
                        <p class="text-xs text-text-muted">
                            {{ $participants->count() }} participant{{ $participants->count() !== 1 ? 's' : '' }}
                            @if ($hasJoined)
                                • <span class="text-green-500">You're in this conversation</span>
                            @endif
                        </p>
                    </div>
                </div>

                {{-- Join Button --}}
                @if (!$hasJoined)
                    <button wire:click="joinConversation" wire:loading.attr="disabled"
                        class="px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white text-xs font-medium rounded-lg transition-colors
                               disabled:opacity-50 disabled:cursor-not-allowed flex items-center gap-2">
                        <svg wire:loading wire:target="joinConversation" class="w-3.5 h-3.5 animate-spin" fill="none"
                            viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                stroke-width="4" />
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z" />
                        </svg>
                        <span>Join Conversation</span>
                    </button>
                @endif
            </div>
        </div>

        {{-- ═══════════════════════════════════════════════════════════
             MESSAGES AREA
        ═══════════════════════════════════════════════════════════ --}}
        <div id="adminMessagesContainer"
            class="flex-1 overflow-y-auto p-4 space-y-3 bg-bg-optional dark:bg-bg-primary min-h-0
                   scrollbar-thin scrollbar-track-transparent scrollbar-thumb-gray-300 dark:scrollbar-thumb-gray-700"
            data-conversation-id="{{ $conversation->id }}">

            @forelse($messages as $msg)
                @php
                    $cs = app(\App\Services\Cloudinary\CloudinaryService::class);
                    $isAdmin = $msg->sender_type === 'App\Models\Admin';
                    $sender = $msg->sender;
                @endphp

                <div class="message-item flex items-end gap-2 {{ $isAdmin ? 'flex-row-reverse' : '' }}"
                    data-message-id="{{ $msg->id }}">

                    {{-- Avatar --}}
                    @if ($sender?->avatar)
                        <img src="{{ storage_url($sender->avatar) }}"
                            alt="{{ $sender->full_name ?? ($sender->name ?? 'User') }}"
                            class="w-7 h-7 rounded-full flex-shrink-0 self-end ring-2 ring-gray-200 dark:ring-gray-700">
                    @else
                        <div
                            class="w-7 h-7 rounded-full flex-shrink-0 self-end
                                    {{ $isAdmin ? 'bg-purple-500' : 'bg-gradient-to-br from-blue-500 to-purple-600' }}
                                    flex items-center justify-center text-white text-xs font-bold">
                            {{ $sender ? strtoupper(substr($sender->full_name ?? ($sender->name ?? 'U'), 0, 2)) : 'S' }}
                        </div>
                    @endif

                    <div class="flex flex-col gap-1 max-w-[70%] {{ $isAdmin ? 'items-end' : 'items-start' }}">
                        {{-- Sender Name --}}
                        <div class="text-[10px] text-text-secondary">
                            <span class="font-medium">{{ $sender->full_name ?? ($sender->name ?? 'System') }}</span>
                            @if ($isAdmin)
                                <span class="text-purple-500 dark:text-purple-400 font-semibold">• Admin</span>
                            @endif
                        </div>

                        {{-- Attachments --}}
                        @if ($msg->attachments && $msg->attachments->count() > 0)
                            @foreach ($msg->attachments as $att)
                                @php $url = $cs->getUrlFromPublicId($att->file_path); @endphp
                                <div class="relative group mb-0.5">
                                    @if (in_array($att->attachment_type->value ?? '', ['image', 'photo']))
                                        <img src="{{ storage_url($att->file_path) }}" alt="Image"
                                            class="rounded-lg max-w-[200px] max-h-48 object-cover shadow-sm
                                                   {{ $isAdmin ? 'rounded-tr-none' : 'rounded-tl-none' }}" />
                                    @elseif(in_array($att->attachment_type->value ?? '', ['video']))
                                        <video src="{{ $url }}" controls
                                            class="rounded-lg max-w-[200px] max-h-40 {{ $isAdmin ? 'rounded-tr-none' : 'rounded-tl-none' }}"></video>
                                    @elseif(in_array($att->attachment_type->value ?? '', ['audio']))
                                        <audio src="{{ $url }}" controls class="max-w-xs"></audio>
                                    @else
                                        <a href="{{ $url }}" target="_blank"
                                            class="flex items-center gap-2 bg-bg-secondary dark:bg-bg-primary border border-bg-optional dark:border-bg-secondary
                                                   px-3 py-2 rounded-lg text-xs hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">
                                            <svg class="w-3.5 h-3.5 text-gray-500 flex-shrink-0" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                            <span
                                                class="truncate max-w-[140px]">{{ basename(parse_url($url, PHP_URL_PATH)) }}</span>
                                        </a>
                                    @endif
                                    <a href="{{ $url }}" download
                                        class="absolute top-1 right-1 bg-black/60 text-white p-1 rounded
                                               opacity-0 group-hover:opacity-100 transition-opacity">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                        </svg>
                                    </a>
                                </div>
                            @endforeach
                        @endif

                        {{-- Message Body --}}
                        @if ($msg->message_body)
                            <div
                                class="px-3 py-2 rounded-lg text-xs shadow-sm
                                        {{ $isAdmin
                                            ? 'bg-purple-600 text-white rounded-tr-none'
                                            : 'bg-bg-primary dark:bg-bg-primary text-text-primary border border-bg-optional dark:border-bg-secondary rounded-tl-none' }}">
                                <p class="break-words whitespace-pre-wrap leading-relaxed">{{ $msg->message_body }}</p>
                            </div>
                        @endif

                        {{-- Timestamp --}}
                        <span class="text-[10px] text-text-muted">
                            {{ $msg->created_at->format('M d, h:i A') }}
                        </span>
                    </div>
                </div>
            @empty
                <div class="flex items-center justify-center h-full text-text-muted py-16">
                    <div class="text-center">
                        <div class="w-14 h-14 mx-auto mb-3 rounded-2xl bg-bg-optional flex items-center justify-center">
                            <svg class="w-7 h-7 text-text-muted" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                            </svg>
                        </div>
                        <p class="text-sm font-medium">No messages yet</p>
                        <p class="text-xs mt-1">Start the conversation</p>
                    </div>
                </div>
            @endforelse
        </div>

        {{-- ═══════════════════════════════════════════════════════════
             MESSAGE INPUT
        ═══════════════════════════════════════════════════════════ --}}
        <div class="flex-shrink-0 border-t border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800">

            {{-- File Upload Loading --}}
            <div wire:loading wire:target="media" class="px-4 pt-2">
                <div class="flex items-center gap-2 text-xs text-purple-600 dark:text-purple-400">
                    <div class="flex-1 h-1 bg-purple-100 dark:bg-purple-900/30 rounded-full overflow-hidden">
                        <div class="h-full bg-purple-600 rounded-full animate-pulse w-3/4"></div>
                    </div>
                    <span>Uploading...</span>
                </div>
            </div>

            {{-- Media Previews --}}
            @if ($media)
                <div class="px-4 pt-3 flex flex-wrap gap-2">
                    @php $mediaItems = is_array($media) ? $media : [$media]; @endphp
                    @foreach ($mediaItems as $index => $file)
                        <div class="relative group">
                            @php $mime = $file->getMimeType() ?? ''; @endphp
                            @if (str_starts_with($mime, 'image/'))
                                <img src="{{ $file->temporaryUrl() }}"
                                    class="w-12 h-12 rounded-lg object-cover border-2 border-purple-300 dark:border-purple-700" />
                            @else
                                <div
                                    class="px-2 py-1 bg-bg-secondary dark:bg-bg-primary rounded text-xs text-text-secondary border border-bg-optional dark:border-bg-secondary">
                                    📎 {{ \Illuminate\Support\Str::limit($file->getClientOriginalName(), 15) }}
                                </div>
                            @endif
                            <button type="button" wire:click="removeMedia({{ $index }})"
                                class="absolute -top-1 -right-1 w-4 h-4 bg-red-500 hover:bg-red-600 text-white rounded-full
                                       flex items-center justify-center text-xs leading-none transition-colors">
                                ×
                            </button>
                        </div>
                    @endforeach
                </div>
            @endif

            @error('media.*')
                <div
                    class="mx-4 mt-2 px-3 py-1.5 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg">
                    <p class="text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                </div>
            @enderror

            @if ($hasJoined)
                <div class="p-4">
                    <div class="flex items-end gap-2">
                        {{-- Attach --}}
                        <label
                            class="flex-shrink-0 cursor-pointer text-gray-400 hover:text-purple-600 dark:hover:text-purple-400 transition-colors p-1.5 rounded-lg hover:bg-purple-50 dark:hover:bg-purple-900/20">
                            <input type="file" wire:model="media" class="hidden"
                                accept=".jpg,.jpeg,.png,.heic,.svg,.gif,.mp4,.mkv,.mov,.webm,.mp3,.aac,.ogg,.wav,.pdf,.doc,.docx"
                                multiple>
                            <svg wire:loading.remove wire:target="media" class="w-5 h-5" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                            </svg>
                            <svg wire:loading wire:target="media" class="w-5 h-5 animate-spin text-purple-600"
                                fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10"
                                    stroke="currentColor" stroke-width="4" />
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z" />
                            </svg>
                        </label>

                        {{-- Textarea --}}
                        <div class="flex-1 relative">
                            <textarea id="adminMessageInput" wire:model="message" rows="1" placeholder="Type your message as admin..."
                                class="w-full bg-bg-secondary dark:bg-bg-primary text-text-primary placeholder-text-muted
                                       px-3 py-2 rounded-lg border border-bg-optional dark:border-bg-secondary
                                       focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent
                                       resize-none text-xs transition-colors"
                                style="min-height: 38px; max-height: 120px;" @if ($isLoading) disabled @endif
                                onkeydown="handleAdminKeyDown(event)"></textarea>
                        </div>

                        {{-- Send --}}
                        <button type="button" onclick="submitAdminMessage()"
                            @if ($isLoading) disabled @endif
                            class="flex-shrink-0 w-9 h-9 rounded-lg bg-purple-600 hover:bg-purple-700
                                   flex items-center justify-center text-white transition-all duration-150
                                   shadow-sm hover:shadow-md active:scale-95 disabled:opacity-50 disabled:cursor-not-allowed">
                            <svg wire:loading wire:target="sendMessage" class="w-4 h-4 animate-spin" fill="none"
                                viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10"
                                    stroke="currentColor" stroke-width="4" />
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z" />
                            </svg>
                            <svg wire:loading.remove wire:target="sendMessage"
                                class="w-4 h-4 -rotate-45 translate-x-px" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                            </svg>
                        </button>
                    </div>

                    <p class="text-[10px] text-text-muted mt-1.5 px-1">
                        Images, Video, Audio, PDF, DOC • Max 10MB
                    </p>
                </div>
            @else
                <div class="p-4 text-center">
                    <p class="text-sm text-text-secondary mb-3">Join this conversation to send messages
                    </p>
                    <button wire:click="joinConversation"
                        class="px-6 py-2 bg-purple-600 hover:bg-purple-700 text-white text-sm font-medium rounded-lg transition-colors">
                        Join Conversation
                    </button>
                </div>
            @endif
        </div>
    @else
        {{-- ═══════════════════════════════════════════════════════════
             EMPTY STATE
        ═══════════════════════════════════════════════════════════ --}}
        <div
            class="flex items-center justify-center h-full text-gray-500 dark:text-gray-400 ">
            <div class="text-center px-4">
                <div
                    class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-gray-100 dark:bg-gray-800 flex items-center justify-center">
                    <svg class="w-8 h-8 text-gray-400 dark:text-gray-600" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                    </svg>
                </div>
                <p class="text-sm font-semibold text-text-secondary">Select a conversation</p>
                <p class="text-xs text-text-muted mt-1">Choose from the list to view messages</p>
            </div>
        </div>
    @endif
</div>

@script
    <script>
        let adminConversationChannel = null;

        // ── Send via JS ───────────────────────────────────────────────
        window.submitAdminMessage = function() {
            @this.call('sendMessage');
        };

        window.handleAdminKeyDown = function(e) {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                submitAdminMessage();
            }
        };

        // ── Textarea auto-resize ──────────────────────────────────────
        function autoResizeAdmin(el) {
            el.style.height = 'auto';
            el.style.height = Math.min(el.scrollHeight, 120) + 'px';
        }

        document.addEventListener('input', e => {
            if (e.target?.id === 'adminMessageInput') autoResizeAdmin(e.target);
        });

        Livewire.on('reset-admin-textarea', () => {
            const el = document.getElementById('adminMessageInput');
            if (el) {
                el.style.height = '38px';
                el.focus();
            }
        });

        // ── Scroll helpers ────────────────────────────────────────────
        function scrollToBottomAdmin(smooth = false) {
            const c = document.getElementById('adminMessagesContainer');
            if (!c) return;
            c.scrollTo({
                top: c.scrollHeight,
                behavior: smooth ? 'smooth' : 'instant'
            });
        }

        // ── Livewire events ───────────────────────────────────────────
        Livewire.on('admin-conversation-selected', data => {
            const id = data.conversationId || data[0]?.conversationId || data[0];

            // Leave previous channel
            if (adminConversationChannel) {
                window.Echo?.leave(adminConversationChannel);
            }

            if (id) {
                adminConversationChannel = `conversation.${id}`;
                console.log('🛡️ Admin joining channel:', adminConversationChannel);

                window.Echo?.private(adminConversationChannel)
                    .listen('.message.sent', event => {
                        console.log('📨 Admin received message:', event);
                        @this.dispatch('new-message-received-admin', event);
                        setTimeout(scrollToBottomAdmin, 100);
                    });
            }
        });

        Livewire.on('admin-conversation-loaded', () => {
            setTimeout(() => {
                scrollToBottomAdmin(false);
                document.getElementById('adminMessageInput')?.focus();
            }, 100);
        });

        Livewire.on('scroll-to-bottom', () => {
            setTimeout(() => scrollToBottomAdmin(true), 50);
        });

        // ── Cleanup ───────────────────────────────────────────────────
        document.addEventListener('livewire:navigating', () => {
            if (adminConversationChannel) {
                window.Echo?.leave(adminConversationChannel);
            }
        });
    </script>
@endscript
