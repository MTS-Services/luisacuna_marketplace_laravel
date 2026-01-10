<div class="min-h-screen bg-gray-50 dark:bg-gray-900">
    <div class="p-4 sm:p-6">
        {{-- Header --}}
        <div class="mb-6">
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white mb-2">
                Conversation Management
            </h1>
            <p class="text-gray-600 dark:text-gray-400">Monitor and manage all user conversations</p>
        </div>

        {{-- Dashboard Stats --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Total Conversations</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['total_conversations'] }}
                        </p>
                    </div>
                    <div class="p-3 bg-blue-100 dark:bg-blue-900 rounded-full">
                        <svg class="w-6 h-6 text-blue-600 dark:text-blue-300" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
                            </path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Active Conversations</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['active_conversations'] }}
                        </p>
                    </div>
                    <div class="p-3 bg-green-100 dark:bg-green-900 rounded-full">
                        <svg class="w-6 h-6 text-green-600 dark:text-green-300" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Admin Involved</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">
                            {{ $stats['conversations_with_admin'] }}</p>
                    </div>
                    <div class="p-3 bg-purple-100 dark:bg-purple-900 rounded-full">
                        <svg class="w-6 h-6 text-purple-600 dark:text-purple-300" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                            </path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Messages Today</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['total_messages_today'] }}
                        </p>
                    </div>
                    <div class="p-3 bg-yellow-100 dark:bg-yellow-900 rounded-full">
                        <svg class="w-6 h-6 text-yellow-600 dark:text-yellow-300" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z">
                            </path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        {{-- Filters --}}
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4 mb-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
                {{-- Search --}}
                <div class="lg:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Search</label>
                    <input type="text" wire:model.live.debounce.300ms="searchTerm"
                        placeholder="Search conversations, users..."
                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white text-sm">
                </div>

                {{-- Status Filter --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Status</label>
                    <select wire:model.live="statusFilter"
                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white text-sm">
                        <option value="">All Status</option>
                        <option value="active">Active</option>
                        <option value="archived">Archived</option>
                        <option value="closed">Closed</option>
                    </select>
                </div>

                {{-- Admin Involved Filter --}}
                <div class="flex items-end">
                    <label class="flex items-center cursor-pointer">
                        <input type="checkbox" wire:model.live="adminInvolvedOnly"
                            class="w-4 h-4 text-blue-600 rounded focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600">
                        <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Admin Involved Only</span>
                    </label>
                </div>

                {{-- Clear Filters --}}
                <div class="flex items-end">
                    <button wire:click="clearFilters"
                        class="w-full px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors text-sm">
                        Clear Filters
                    </button>
                </div>
            </div>
        </div>

        {{-- Main Content --}}
        <div class="flex flex-col lg:flex-row gap-6 h-[70vh]">
            {{-- Conversations List --}}
            <div class="lg:w-1/3 bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden flex flex-col">
                <div class="p-4 border-b border-gray-200 dark:border-gray-700">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Conversations</h2>
                </div>

                <div class="flex-1 overflow-y-auto">
                    @forelse($this->conversations as $conversation)
                        <div wire:click="selectConversation({{ $conversation->id }})"
                            class="p-4 border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 cursor-pointer transition-colors {{ $selectedConversationId == $conversation->id ? 'bg-blue-50 dark:bg-gray-700' : '' }}">

                            <div class="flex items-start gap-3">
                                {{-- Participants Avatars --}}
                                <div class="flex -space-x-2">
                                    @foreach ($conversation->participants->take(2) as $participant)
                                        @if ($participant->participant?->avatar)
                                            <img src="{{auth_storage_url($participant?->participant?->avatar) }}"
                                                alt="{{ $participant->participant->full_name ?? 'User' }}"
                                                class="w-10 h-10 rounded-full border-2 border-white dark:border-gray-800">
                                        @else
                                            <div
                                                class="w-10 h-10 rounded-full border-2 border-white dark:border-gray-800 bg-gradient-to-br from-blue-500 to-purple-500 flex items-center justify-center text-white text-xs font-semibold">
                                                {{ strtoupper(substr($participant->participant?->full_name ?? 'U', 0, 2)) }}
                                            </div>
                                        @endif
                                    @endforeach
                                </div>

                                <div class="flex-1 min-w-0">
                                    {{-- Participants Names --}}
                                    <div class="flex items-center justify-between mb-1">
                                        <h3 class="text-sm font-semibold text-gray-900 dark:text-white truncate">
                                            {{ $conversation->participants->pluck('participant')->map(fn($p) => $p?->full_name ?? ($p?->name ?? 'Unknown'))->implode(', ') }}
                                        </h3>
                                        <span class="text-xs text-gray-500 dark:text-gray-400">
                                            {{ $conversation->last_message_at?->diffForHumans() ?? $conversation->created_at->diffForHumans() }}
                                        </span>
                                    </div>

                                    {{-- Last Message --}}
                                    @if ($conversation->messages->isNotEmpty())
                                        <p class="text-xs text-gray-600 dark:text-gray-400 truncate">
                                            {{ \Illuminate\Support\Str::limit($conversation->messages->first()->message_body, 50) }}
                                        </p>
                                    @endif

                                    {{-- Stats --}}
                                    <div class="flex items-center gap-3 mt-2">
                                        <span class="text-xs text-gray-500 dark:text-gray-400">
                                            💬 {{ $conversation->total_messages }} messages
                                        </span>
                                        <span class="text-xs text-gray-500 dark:text-gray-400">
                                            👥 {{ $conversation->active_participants }} participants
                                        </span>
                                        @if ($conversation->participants->where('participant_role', 'admin')->where('is_active', true)->isNotEmpty())
                                            <span class="text-xs text-purple-600 dark:text-purple-400">
                                                🛡️ Admin
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="p-8 text-center text-gray-500 dark:text-gray-400">
                            <svg class="w-16 h-16 mx-auto mb-3 text-gray-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
                                </path>
                            </svg>
                            <p>No conversations found</p>
                        </div>
                    @endforelse
                </div>

                {{-- Pagination --}}
                <div class="p-4 border-t border-gray-200 dark:border-gray-700">
                    {{ $this->conversations->links() }}
                </div>
            </div>

            {{-- Messages Panel --}}
            <div class="lg:w-2/3 bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
                <livewire:backend.admin.conversation-management.conversation.messages :conversationId="$selectedConversationId"
                    :key="'messages-' . $selectedConversationId" />
            </div>
        </div>
    </div>
</div>
