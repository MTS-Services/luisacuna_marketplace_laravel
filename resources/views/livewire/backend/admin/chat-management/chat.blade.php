<div>
    <div class="chat-container">
    <div class="row g-0" style="height: calc(100vh - 200px);">
        <!-- Conversations List Sidebar -->
        <div class="col-md-4 border-end">
            <div class="p-3 border-bottom">
                <h5 class="mb-3">Conversations</h5>
                <input 
                    type="text" 
                    class="form-control" 
                    placeholder="Search conversations..." 
                    wire:model.live.debounce.300ms="search"
                >
            </div>
            
            <div class="conversations-list" style="height: calc(100% - 100px); overflow-y: auto;">
                @forelse($conversations as $conversation)
                    <div 
                        class="conversation-item p-3 border-bottom {{ $selectedConversationId == $conversation->id ? 'active bg-light' : '' }}" 
                        style="cursor: pointer;"
                        wire:click="selectConversation({{ $conversation->id }})"
                    >
                        <div class="d-flex align-items-start">
                            <div class="flex-grow-1">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <h6 class="mb-0">
                                        @foreach($conversation->conversation_participants as $participant)
                                            <span class="badge bg-primary me-1">
                                                {{ $participant->user->username }}
                                            </span>
                                        @endforeach
                                    </h6>
                                    <small class="text-muted">
                                        {{ $conversation->last_message_at ? \Carbon\Carbon::parse($conversation->last_message_at)->diffForHumans() : 'No messages' }}
                                    </small>
                                </div>
                                
                                @if($conversation->messages->isNotEmpty())
                                    <p class="mb-0 text-muted small text-truncate">
                                        <strong>{{ $conversation->messages->first()->sender->username }}:</strong>
                                        {{ Str::limit($conversation->messages->first()->message_body, 50) }}
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center p-4 text-muted">
                        <i class="fas fa-comments fa-3x mb-3"></i>
                        <p>No conversations found</p>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if($conversations->hasPages())
                <div class="p-3 border-top">
                    {{ $conversations->links() }}
                </div>
            @endif
        </div>

        <!-- Messages Area -->
        <div class="col-md-8">
            @if($selectedConversationId)
                <!-- Chat Header -->
                <div class="chat-header p-3 border-bottom bg-light">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h5 class="mb-1">
                                @if($conversationDetails)
                                    @foreach($conversationDetails->conversation_participants as $participant)
                                        <span class="badge bg-primary me-1">
                                            {{ $participant->user->first_name }} {{ $participant->user->last_name }}
                                            ({{ $participant->user->username }})
                                        </span>
                                    @endforeach
                                @endif
                            </h5>
                            <small class="text-muted">
                                Conversation ID: {{ $selectedConversationId }}
                                @if($conversationDetails)
                                    | UUID: {{ $conversationDetails->conversation_uuid }}
                                @endif
                            </small>
                        </div>
                        <button class="btn btn-sm btn-outline-secondary" wire:click="loadMessages">
                            <i class="fas fa-sync-alt"></i> Refresh
                        </button>
                    </div>
                </div>

                <!-- Messages Container -->
                <div class="messages-container p-3" style="height: calc(100% - 80px); overflow-y: auto; background-color: #f8f9fa;">
                    @forelse($messages as $message)
                        @php
                            $message = (object) $message; // Convert array to object for easier access
                            $sender = (object) $message->sender;
                        @endphp
                        <div class="message-wrapper mb-3 {{ $message->sender_id == ($conversationDetails->conversation_participants->first()->user_id ?? null) ? 'text-start' : 'text-end' }}">
                            <div class="d-inline-block" style="max-width: 70%;">
                                <!-- Sender Info -->
                                <div class="mb-1">
                                    <small class="text-muted">
                                        <strong>{{ $sender->username }}</strong>
                                        <span class="badge bg-{{ $message->sender_id == ($conversationDetails->conversation_participants->first()->user_id ?? null) ? 'info' : 'success' }} ms-1">
                                            {{ $sender->first_name }} {{ $sender->last_name }}
                                        </span>
                                    </small>
                                </div>

                                <!-- Message Bubble -->
                                <div class="message-bubble p-3 rounded {{ $message->sender_id == ($conversationDetails->conversation_participants->first()->user_id ?? null) ? 'bg-white border' : 'bg-primary text-white' }}">
                                    <p class="mb-0">{{ $message->message_body }}</p>
                                    
                                    <!-- Attachments -->
                                    @if(isset($message->attachments) && count($message->attachments) > 0)
                                        <div class="mt-2">
                                            @foreach($message->attachments as $attachment)
                                                @php
                                                    $attachment = (object) $attachment;
                                                @endphp
                                                <div class="attachment-item mb-1">
                                                    @if(in_array($attachment->attachment_type ?? '', ['image', 'photo']))
                                                        <img src="{{ asset($attachment->file_path) }}" 
                                                             alt="Attachment" 
                                                             class="img-fluid rounded" 
                                                             style="max-width: 200px;">
                                                    @else
                                                        <a href="{{ asset($attachment->file_path) }}" 
                                                           target="_blank" 
                                                           class="btn btn-sm btn-outline-secondary">
                                                            <i class="fas fa-file"></i> View Attachment
                                                        </a>
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif

                                    <!-- Message Meta -->
                                    <div class="mt-2 pt-2 border-top" style="font-size: 0.75rem; opacity: 0.8;">
                                        <i class="far fa-clock"></i> {{ \Carbon\Carbon::parse($message->created_at)->format('M d, Y h:i A') }}
                                        @if($message->is_edited ?? false)
                                            <span class="ms-2">
                                                <i class="fas fa-edit"></i> Edited
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center p-5 text-muted">
                            <i class="far fa-comments fa-3x mb-3"></i>
                            <p>No messages in this conversation yet</p>
                        </div>
                    @endforelse
                </div>
            @else
                <!-- No Conversation Selected -->
                <div class="d-flex align-items-center justify-content-center h-100">
                    <div class="text-center text-muted">
                        <i class="far fa-comment-dots fa-4x mb-3"></i>
                        <h5>Select a conversation to view messages</h5>
                        <p>Choose from the list on the left</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<style>
    .conversation-item {
        transition: background-color 0.2s;
    }

    .conversation-item:hover {
        background-color: #f8f9fa !important;
    }

    .conversation-item.active {
        border-left: 4px solid #0d6efd;
    }

    .messages-container {
        scroll-behavior: smooth;
    }

    .message-bubble {
        word-wrap: break-word;
        box-shadow: 0 1px 2px rgba(0,0,0,0.1);
    }

    .conversations-list::-webkit-scrollbar,
    .messages-container::-webkit-scrollbar {
        width: 6px;
    }

    .conversations-list::-webkit-scrollbar-thumb,
    .messages-container::-webkit-scrollbar-thumb {
        background-color: #ccc;
        border-radius: 3px;
    }
</style>

@push('scripts')
<script>
    document.addEventListener('livewire:initialized', () => {
        // Auto-scroll to bottom when messages load
        Livewire.hook('morph.updated', () => {
            const messagesContainer = document.querySelector('.messages-container');
            if (messagesContainer) {
                messagesContainer.scrollTop = messagesContainer.scrollHeight;
            }
        });
    });
</script>
@endpush
</div>