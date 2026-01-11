<div class="flex flex-col h-full">
    @if ($conversation)
        {{-- Header --}}
        <div class="p-4 border-b border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    {{-- Participants --}}
                    <div class="flex -space-x-2">
                        @foreach ($participants->take(3) as $participant)
                            @if ($participant['avatar'])
                                <img src="{{ storage_url($participant['avatar']) }}" alt="{{ $participant['name'] }}"
                                    class="w-10 h-10 rounded-full border-2 border-white dark:border-gray-800"
                                    title="{{ $participant['name'] }}">
                            @else
                                <div class="w-10 h-10 rounded-full border-2 border-white dark:border-gray-800 bg-gradient-to-br from-blue-500 to-purple-500 flex items-center justify-center text-white text-xs font-semibold"
                                    title="{{ $participant['name'] }}">
                                    {{ strtoupper(substr($participant['name'], 0, 2)) }}
                                </div>
                            @endif
                        @endforeach
                    </div>

                    <div>
                        <h3 class="text-base font-semibold text-gray-900 dark:text-white">
                            {{ $participants->pluck('name')->implode(', ') }}
                        </h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400">
                            {{ $participants->count() }} participants
                            @if ($hasJoined)
                                • <span class="text-green-600 dark:text-green-400">You're in this conversation</span>
                            @endif
                        </p>
                    </div>
                </div>

                {{-- Join Button --}}
                @if (!$hasJoined)
                    <button wire:click="joinConversation"
                        class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors">
                        Join Conversation
                    </button>
                @endif
            </div>
        </div>

        {{-- Messages Area --}}
        <div class="flex-1 overflow-y-auto p-4 space-y-4" id="adminMessagesContainer"
            data-conversation-id="{{ $conversation->id }}">
            @forelse($messages as $msg)
                <div class="message-item flex items-start gap-3 {{ $msg->sender_type === 'App\Models\Admin' ? 'flex-row-reverse' : '' }}"
                    data-message-id="{{ $msg->id }}">

                    {{-- Avatar --}}
                    @if ($msg->sender?->avatar)
                        <img src="{{ auth_storage_url($msg->sender->avatar) }}"
                            alt="{{ $msg->sender->full_name ?? ($msg->sender->name ?? 'User') }}"
                            class="w-8 h-8 rounded-full flex-shrink-0">
                    @else
                        <div
                            class="w-8 h-8 rounded-full flex-shrink-0 {{ $msg->sender_type === 'App\Models\Admin' ? 'bg-purple-500' : 'bg-blue-500' }} flex items-center justify-center text-white text-xs font-semibold">
                            {{ $msg->sender ? strtoupper(substr($msg->sender->full_name ?? ($msg->sender->name ?? 'U'), 0, 2)) : 'S' }}
                        </div>
                    @endif

                    <div
                        class="flex flex-col gap-1 max-w-[70%] {{ $msg->sender_type === 'App\Models\Admin' ? 'items-end' : '' }}">
                        {{-- Sender Name --}}
                        <div class="text-xs text-gray-600 dark:text-gray-400">
                            {{ $msg->sender->full_name ?? ($msg->sender->name ?? 'System') }}
                            @if ($msg->sender_type === 'App\Models\Admin')
                                <span class="text-purple-600 dark:text-purple-400">• Admin</span>
                            @endif
                        </div>

                        {{-- Attachments --}}
                        @if ($msg->attachments && $msg->attachments->count() > 0)
                            @foreach ($msg->attachments as $attachment)
                                <div class="relative">
                                    @if (in_array($attachment->attachment_type->value, ['image', 'photo']))
                                        <img src="{{ storage_url($attachment->file_path) }}"
                                            class="rounded-lg max-w-full max-h-64 object-cover">
                                    @else
                                        <a href="{{ asset('storage/' . $attachment->file_path) }}"
                                            class="flex items-center gap-2 bg-gray-100 dark:bg-gray-700 px-3 py-2 rounded-lg text-sm">
                                            📎 {{ basename($attachment->file_path) }}
                                        </a>
                                    @endif
                                </div>
                            @endforeach
                        @endif

                        {{-- Message Body --}}
                        @if ($msg->message_body)
                            <div
                                class="px-4 py-2 rounded-lg {{ $msg->sender_type === 'App\Models\Admin' ? 'bg-purple-600 text-white' : 'bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-white' }} text-sm">
                                {{ $msg->message_body }}
                            </div>
                        @endif

                        {{-- Timestamp --}}
                        <span class="text-xs text-gray-500 dark:text-gray-400">
                            {{ $msg->created_at->format('M d, Y h:i A') }}
                        </span>
                    </div>
                </div>
            @empty
                <div class="flex items-center justify-center h-full text-gray-500 dark:text-gray-400">
                    <div class="text-center">
                        <svg class="w-16 h-16 mx-auto mb-3 text-gray-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
                            </path>
                        </svg>
                        <p class="text-sm">No messages yet</p>
                    </div>
                </div>
            @endforelse
        </div>

        {{-- Message Input --}}
        <div class="p-4 border-t border-gray-200 dark:border-gray-700">
            @if ($hasJoined)
                <form wire:submit.prevent="sendMessage">
                    <div class="flex items-end gap-3">
                        <div class="flex-1 relative">
                            <textarea wire:model="message" wire:keydown.enter.prevent="sendMessage" rows="1"
                                placeholder="Type your message as admin..."
                                class="w-full px-4 py-3 pr-14 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-purple-500 dark:bg-gray-700 dark:text-white resize-none text-sm"
                                style="min-height: 44px; max-height: 120px;" @if ($isLoading) disabled @endif></textarea>

                            <div class="absolute right-3 bottom-3 flex items-center gap-2">
                                <label
                                    class="cursor-pointer text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300">
                                    <input type="file" wire:model="media" class="hidden"
                                        accept="image/*,video/*,audio/*,.pdf,.doc,.docx" multiple>
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13">
                                        </path>
                                    </svg>
                                </label>

                                <button type="submit"
                                    class="text-purple-600 hover:text-purple-700 dark:text-purple-400 dark:hover:text-purple-300 disabled:opacity-50"
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
                                        <span class="text-xs bg-gray-100 dark:bg-gray-700 px-2 py-1 rounded">
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
                                    <span class="text-xs bg-gray-100 dark:bg-gray-700 px-2 py-1 rounded">
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
            @else
                <div class="text-center py-4">
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">Join this conversation to send messages</p>
                    <button wire:click="joinConversation"
                        class="px-6 py-2 bg-purple-600 hover:bg-purple-700 text-white text-sm font-medium rounded-lg transition-colors">
                        Join Conversation
                    </button>
                </div>
            @endif
        </div>
    @else
        {{-- No Conversation Selected --}}
        <div class="flex items-center justify-center h-full text-gray-500 dark:text-gray-400">
            <div class="text-center">
                <svg class="w-16 h-16 mx-auto mb-3 text-gray-400" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
                    </path>
                </svg>
                <p class="text-sm">Select a conversation to view messages</p>
            </div>
        </div>
    @endif
</div>

@script
    <script>
        let adminConversationChannel = null;

        // Listen for admin conversation selection
        Livewire.on('admin-conversation-selected', (data) => {
            const conversationId = data.conversationId || data[0]?.conversationId || data[0];

            // Leave previous channel
            if (adminConversationChannel) {
                window.Echo.leave(adminConversationChannel);
            }

            // Join new conversation channel
            if (conversationId) {
                adminConversationChannel = `conversation.${conversationId}`;

                console.log('🛡️ Admin joining channel:', adminConversationChannel);

                window.Echo.private(adminConversationChannel)
                    .listen('.message.sent', (event) => {
                        console.log('📨 Admin received message:', event);

                        // Dispatch to Livewire
                        $wire.dispatch('new-message-received-admin', event);

                        // Scroll to bottom
                        setTimeout(scrollToBottomAdmin, 100);
                    });
            }
        });

        // Listen for conversation loaded
        Livewire.on('admin-conversation-loaded', () => {
            setTimeout(scrollToBottomAdmin, 100);
        });

        // Listen for scroll to bottom
        Livewire.on('scroll-to-bottom', () => {
            setTimeout(() => scrollToBottomAdmin(true), 100);
        });

        function scrollToBottomAdmin(smooth = false) {
            const container = document.getElementById('adminMessagesContainer');
            if (!container) return;

            container.scrollTo({
                top: container.scrollHeight,
                behavior: smooth ? 'smooth' : 'auto'
            });
        }

        // Cleanup
        document.addEventListener('livewire:navigating', () => {
            if (adminConversationChannel) {
                window.Echo.leave(adminConversationChannel);
            }
        });
    </script>
@endscript
