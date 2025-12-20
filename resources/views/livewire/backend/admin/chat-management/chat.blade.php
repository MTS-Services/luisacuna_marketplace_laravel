<div>
    {{-- <div>
        <!-- Right Side - Chat Area -->
        <div class="flex-1 flex flex-col min-h-[50vh] md:min-h-[20vh] rounded-lg bg-bg-secondary">
            @if ($receiverId)
                <!-- Chat Header -->
                <div class="p-3 sm:p-4 flex items-center bg-zinc-50/10 rounded-t-lg justify-between">
                    <div class="flex items-center gap-2 sm:gap-3">
                        @php
                            $selectedUser = collect($users)->firstWhere('id', $receiverId);
                        @endphp
                        @if ($selectedUser && isset($selectedUser->avatar) && $selectedUser->avatar)
                            <img src="{{ storage_url($selectedUser->avatar) }}"
                                alt="{{ $selectedUser->full_name ?? $selectedUser->username }}"
                                class="w-8 h-8 sm:w-10 sm:h-10 rounded-full object-cover flex-shrink-0">
                        @else
                            <div
                                class="w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-gradient-to-br from-accent to-accent-foreground flex items-center justify-center text-text-white font-semibold text-xs sm:text-sm flex-shrink-0">
                                {{ strtoupper(substr($receiverName ?? 'U', 0, 2)) }}
                            </div>
                        @endif
                        <div>
                            <h3 class="text-text-primary font-semibold text-sm sm:text-base">
                                {{ $receiverName ?? 'User' }}</h3>
                            <p class="text-text-secondary text-xs sm:text-sm">{{ __('Available') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Messages Area -->
                <div class="flex-1 overflow-y-auto custom-scrollbar p-3 sm:p-4 md:p-6 space-y-4 sm:space-y-6"
                    id="messagesContainer">
                    @forelse($messages as $msg)
                        @php
                            $participantIds = collect($users)->pluck('id')->filter(function($id) {
                                return $id != Auth::id();
                            })->values()->all();
                            
                            $isAdmin = $msg->sender_id == Auth::id();
                            $isParticipant = in_array($msg->sender_id, $participantIds);
                        
                            $isReceiver = !empty($participantIds) && $msg->sender_id == ($participantIds[0] ?? null);
                        @endphp

                        @if ($isAdmin)
                            <div class="flex justify-center my-4">
                                <div class="max-w-[85%] sm:max-w-xl w-full">
                                    <!-- Admin Label -->
                                    <div class="flex items-center justify-center gap-2 mb-2">
                                        <div class="h-px bg-gradient-to-r from-transparent via-blue-500 to-transparent flex-1"></div>
                                        <div class="flex items-center gap-2 px-3 py-1 bg-blue-500/10 rounded-full border border-blue-500/20">
                                            <svg class="w-3 h-3 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z" clip-rule="evenodd" />
                                            </svg>
                                            <span class="text-xs font-medium text-blue-400">Admin</span>
                                        </div>
                                        <div class="h-px bg-gradient-to-r from-blue-500 via-transparent to-transparent flex-1"></div>
                                    </div>

                                    <!-- Admin Message Content -->
                                    <div class="bg-gradient-to-br from-blue-500/20 to-blue-600/10 backdrop-blur-sm border border-blue-500/30 rounded-2xl p-4 shadow-lg">
                                        @if ($msg->attachments && $msg->attachments->count() > 0)
                                            <div class="mb-3 space-y-2">
                                                @foreach ($msg->attachments as $attachment)
                                                    <div class="relative">
                                                        @if ($attachment->attachment_type->value === 'image' || in_array($attachment->attachment_type->value, ['image', 'photo', 'picture']))
                                                            <img src="{{ asset('storage/' . $attachment->file_path) }}"
                                                                class="rounded-lg max-w-full max-h-64 object-cover mx-auto">
                                                        @else
                                                            <a href="{{ asset('storage/' . $attachment->file_path) }}"
                                                                class="flex items-center gap-2 bg-blue-500/20 px-3 py-2 rounded-lg text-blue-300 text-xs hover:bg-blue-500/30 transition-colors">
                                                                📎 {{ basename($attachment->file_path) }}
                                                            </a>
                                                        @endif
                                                        <a href="{{ asset('storage/' . $attachment->file_path) }}" download
                                                            class="absolute top-1 right-1 bg-black bg-opacity-50 text-white px-2 py-1 text-xs rounded hover:bg-opacity-70">
                                                            Download
                                                        </a>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif

                                        @if ($msg->message_body)
                                            <p class="text-sm text-text-white text-center leading-relaxed">
                                                {{ $msg->message_body }}
                                            </p>
                                        @endif

                                        <div class="flex items-center justify-center gap-2 mt-3 pt-2 border-t border-blue-500/20">
                                            <span class="text-[10px] text-blue-300">
                                                {{ $msg->created_at->format('M d, Y h:i A') }}
                                            </span>
                                            @if ($msg->readReceipts && $msg->readReceipts->count() > 0)
                                                <span class="text-blue-400 text-xs">✓✓ Read</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @elseif ($isReceiver)
                            <!-- Receiver Message (Left) -->
                            <div class="flex items-start gap-2 sm:gap-3">
                                @php
                                    $displayName = $msg->sender->full_name ?? $msg->sender->name ?? $msg->sender->username ?? 'User';
                                @endphp
                                @if ($msg->sender && $msg->sender->avatar)
                                    <img src="{{ storage_url($msg->sender->avatar) }}" alt="{{ $displayName }}"
                                        class="w-8 h-8 sm:w-10 sm:h-10 rounded-full object-cover flex-shrink-0">
                                @else
                                    <div
                                        class="w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-gradient-to-br from-purple-500 to-purple-600 flex items-center justify-center text-white font-semibold text-xs sm:text-sm flex-shrink-0">
                                        {{ strtoupper(substr($displayName, 0, 2)) }}
                                    </div>
                                @endif
                                <div class="flex flex-col gap-1 sm:gap-2 max-w-[75%] sm:max-w-md">
                                    @if ($msg->attachments && $msg->attachments->count() > 0)
                                        @foreach ($msg->attachments as $attachment)
                                            <div class="relative mb-2">
                                                @if ($attachment->attachment_type->value === 'image' || in_array($attachment->attachment_type->value, ['image', 'photo', 'picture']))
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
                                                    Download
                                                </a>
                                            </div>
                                        @endforeach
                                    @endif

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
                        @else
                            <!-- Other User Message (Right) -->
                            <div class="flex items-start gap-2 sm:gap-3 flex-row-reverse">
                                @php
                                    $displayName = $msg->sender->full_name ?? $msg->sender->name ?? $msg->sender->username ?? 'User';
                                @endphp
                                @if ($msg->sender && $msg->sender->avatar)
                                    <img src="{{ storage_url($msg->sender->avatar) }}" alt="{{ $displayName }}"
                                        class="w-8 h-8 sm:w-10 sm:h-10 rounded-full object-cover flex-shrink-0">
                                @else
                                    <div
                                        class="w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-gradient-to-br from-accent to-accent-foreground flex items-center justify-center text-white font-semibold text-xs sm:text-sm flex-shrink-0">
                                        {{ strtoupper(substr($displayName, 0, 2)) }}
                                    </div>
                                @endif
                                <div class="flex flex-col gap-1 sm:gap-2 max-w-[75%] sm:max-w-md items-end">
                                    @if ($msg->attachments && $msg->attachments->count() > 0)
                                        @foreach ($msg->attachments as $attachment)
                                            <div class="relative mb-2">
                                                @if ($attachment->attachment_type->value === 'image' || in_array($attachment->attachment_type->value, ['image', 'photo', 'picture']))
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
                                                    Download
                                                </a>
                                            </div>
                                        @endforeach
                                    @endif

                                    @if ($msg->message_body)
                                        <div
                                            class="bg-gradient-to-r from-accent to-accent-foreground text-white px-3 sm:px-4 py-2 sm:py-3 rounded-2xl rounded-tr-none">
                                            <p class="text-xs sm:text-sm break-words">{{ $msg->message_body }}</p>
                                        </div>
                                    @endif

                                    <span class="text-[10px] sm:text-xs text-text-muted">
                                        {{ $msg->created_at->format('M d, Y h:i A') }}
                                    </span>
                                </div>
                            </div>
                        @endif
                    @empty
                        <div class="flex items-center justify-center h-full text-text-muted text-sm">
                            {{ __('No messages yet. Start the conversation!') }}
                        </div>
                    @endforelse
                </div>

                <!-- Message Input -->
                <div class="p-3 sm:p-4 border-t border-zinc-800">
                    <form wire:submit.prevent="sendMessage">
                        <div class="flex items-end gap-2 sm:gap-3">
                            <div class="flex-1 relative">
                                <textarea wire:model="message" wire:keydown.enter.prevent="sendMessage" rows="1"
                                    placeholder="Type your message here..."
                                    class="w-full bg-bg-hover text-text-white px-3 sm:px-4 py-2 sm:py-3 pr-12 sm:pr-14 rounded-lg border border-zinc-700 focus:outline-none focus:ring-2 focus:ring-accent resize-none text-xs sm:text-sm"
                                    style="min-height: 40px; max-height: 120px;"></textarea>
                                <div
                                    class="absolute right-2 sm:right-3 bottom-2 sm:bottom-3 flex items-center gap-1 sm:gap-2">
                                    <label
                                        class="cursor-pointer text-text-muted hover:text-text-primary transition-colors">
                                        <input type="file" wire:model="media" class="hidden"
                                            accept="image/*,application/pdf">
                                        <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13">
                                            </path>
                                        </svg>
                                    </label>
                                    <button type="submit"
                                        class="text-text-muted hover:text-text-primary transition-colors disabled:opacity-50"
                                        wire:loading.attr="disabled">
                                        <svg class="w-5 h-5 -rotate-45" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>

                    @if ($media)
                        <div class="mt-2 flex items-center gap-2 text-xs text-text-secondary">
                            <span>📎 {{ is_object($media) ? $media->getClientOriginalName() : 'File selected' }}</span>
                            <button wire:click="$set('media', null)" class="text-red-500 hover:text-red-400 ml-2">
                                Remove
                            </button>
                        </div>
                    @endif

                    <div wire:loading wire:target="sendMessage" class="mt-2 text-xs text-accent">
                        Sending message...
                    </div>
                </div>
            @else
                <!-- No User Selected -->
                <div class="flex-1 flex items-center justify-center text-text-muted">
                    <div class="text-center">
                        <svg class="w-16 h-16 mx-auto mb-3 text-zinc-600" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                        </svg>
                        <p class="text-sm">{{ __('Loading conversation...') }}</p>
                    </div>
                </div>
            @endif
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('livewire:initialized', () => {
                scrollToBottom();

                Livewire.on('scrollToBottom', () => {
                    scrollToBottom();
                });

                Livewire.on('success', (message) => {
                    console.log('Success:', message);
                });

                Livewire.on('error', (message) => {
                    console.error('Error:', message);
                });
            });

            function scrollToBottom() {
                setTimeout(() => {
                    const container = document.getElementById('messagesContainer');
                    if (container) {
                        container.scrollTop = container.scrollHeight;
                    }
                }, 100);
            }

            document.addEventListener('DOMContentLoaded', function() {
                const textarea = document.querySelector('textarea[wire\\:model="message"]');
                if (textarea) {
                    textarea.addEventListener('input', function() {
                        this.style.height = 'auto';
                        this.style.height = Math.min(this.scrollHeight, 120) + 'px';
                    });
                }
            });
        </script>
    @endpush --}}

    <div class="container-fluid p-4">
        <div class="card shadow" style="height: calc(100vh - 120px);">

            {{-- Header --}}
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <a href="{{ route('admin.chat.index') }}" class="btn btn-light btn-sm me-3">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                    <div>
                        <h5 class="mb-0">Conversation #{{ $conversationId }}</h5>
                        <small>{{ $participant1?->username ?? 'User 1' }} &
                            {{ $participant2?->username ?? 'User 2' }}</small>
                    </div>
                </div>
                <button wire:click="loadMessages" class="btn btn-light btn-sm">
                    <i class="fas fa-sync-alt"></i>
                </button>
            </div>

            {{-- Messages --}}
            <div class="card-body overflow-auto" style="height: calc(100% - 150px);" id="messages-container">

                @forelse($messages as $message)
                    @php
                        $isParticipant1 = $message->sender_id === $participant1?->id;
                        $isParticipant2 = $message->sender_id === $participant2?->id;
                        $isAdmin = !$isParticipant1 && !$isParticipant2;
                    @endphp

                    {{-- Left: Participant 1 --}}
                    @if ($isParticipant1)
                        <div class="d-flex mb-3">
                            <div class="me-2">
                                <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center"
                                    style="width: 40px; height: 40px;">
                                    <strong>{{ strtoupper(substr($participant1->username ?? 'U', 0, 1)) }}</strong>
                                </div>
                            </div>
                            <div style="max-width: 60%;">
                                <div class="bg-light p-3 rounded">
                                    <p class="mb-0">{{ $message->message_body }}</p>
                                </div>
                                <small class="text-muted">{{ $participant1->username }} •
                                    {{ $message->created_at->format('M d, h:i A') }}</small>
                            </div>
                        </div>
                    @endif

                    {{-- Right: Participant 2 --}}
                    @if ($isParticipant2)
                        <div class="d-flex mb-3 justify-content-end">
                            <div style="max-width: 60%;" class="text-end">
                                <div class="bg-primary text-white p-3 rounded">
                                    <p class="mb-0">{{ $message->message_body }}</p>
                                </div>
                                <small class="text-muted">{{ $message->created_at->format('M d, h:i A') }} •
                                    {{ $participant2->username }}</small>
                            </div>
                            <div class="ms-2">
                                <div class="rounded-circle bg-success text-white d-flex align-items-center justify-content-center"
                                    style="width: 40px; height: 40px;">
                                    <strong>{{ strtoupper(substr($participant2->username ?? 'U', 0, 1)) }}</strong>
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- Center: Admin --}}
                    @if ($isAdmin)
                        <div class="d-flex justify-content-center mb-3">
                            <div class="bg-warning bg-opacity-25 border border-warning p-3 rounded"
                                style="max-width: 70%;">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="fas fa-user-shield text-warning me-2"></i>
                                    <strong class="text-warning">Admin</strong>
                                    <small
                                        class="text-muted ms-2">{{ $message->created_at->format('M d, h:i A') }}</small>
                                </div>
                                <p class="mb-0">{{ $message->message_body }}</p>
                            </div>
                        </div>
                    @endif

                @empty
                    <div class="d-flex align-items-center justify-content-center h-100">
                        <div class="text-center text-muted">
                            <i class="fas fa-comments fa-3x mb-3"></i>
                            <p>No messages yet</p>
                        </div>
                    </div>
                @endforelse
            </div>

            {{-- Input --}}
            <div class="card-footer">
                <form wire:submit.prevent="sendMessage">
                    <div class="input-group">
                        <textarea wire:model.defer="messageBody" class="form-control" rows="2" placeholder="Type message as admin..."></textarea>
                        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">
                            <span wire:loading.remove>Send</span>
                            <span wire:loading>...</span>
                        </button>
                    </div>
                    @error('messageBody')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const container = document.getElementById('messages-container');
            if (container) {
                container.scrollTop = container.scrollHeight;
            }
        });

        window.addEventListener('message-sent', function() {
            setTimeout(() => {
                const container = document.getElementById('messages-container');
                if (container) container.scrollTop = container.scrollHeight;
            }, 100);
        });
    </script>
</div>
