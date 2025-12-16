<div x-data x-init="setInterval(() => Livewire.dispatch('refreshMessages'), 500)">

    <div class="bg-bg-primary">
        <div>
            <div class="p-3 sm:p-4">
                <div class="flex items-center justify-between mb-3 sm:mb-4">
                    <h2 class="text-lg sm:text-xl md:text-2xl lg:text-3xl text-text-primary font-lato">
                        {{ __('Messages') }}</h2>

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

                <!-- Unread message only toggle -->
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
                        <x-ui.select class="bg-surface-card border border-border-primary py-1.5! rounded-lg w-full">
                            <option value="">{{ __('All') }}</option>
                            <option value="boosting">{{ __('Boosting') }}</option>
                            <option value="orders">{{ __('Orders') }}</option>
                            <option value="support">{{ __('Support') }}</option>
                            <option value="pre-purchase">{{ __('Pre-purchase') }}</option>
                        </x-ui.select>
                    </div>
                </div>

                <!-- Mark all as read -->
                <a href="#" wire:click.prevent="markAllAsRead"
                    class="text-xs sm:text-sm text-pink-500 hover:text-pink-400 transition-colors">
                    {{ __('Mark all as read') }}
                </a>
            </div>

            {{-- <div class="flex flex-col md:flex-row h-auto md:h-[68vh] gap-2 px-3 sm:px-4 relative">
                
                <!-- Mobile Overlay -->
                <div id="mobileOverlay" onclick="toggleMobileMenu()"
                    class="hidden fixed inset-0 bg-black bg-opacity-50 z-40 md:hidden"></div>

                <!-- Left Sidebar - Messages List -->
                <div id="messagesSidebar"
                    class="fixed md:static inset-y-0 left-0 transform -translate-x-full md:translate-x-0 transition-transform duration-300 ease-in-out z-30 w-full md:w-64 lg:w-72 xl:w-80 2xl:w-96 bg-bg-secondary rounded-lg flex flex-col md:mr-5 mb-1 md:mb-0 max-h-full md:max-h-full">
                    <div class="p-3 sm:p-4">
                        <!-- Close Button for Mobile -->
                        <div class="flex items-center justify-between mb-3 md:hidden">
                            <h3 class="text-text-primary font-semibold text-base">{{ __('Conversations') }}</h3>
                            <button onclick="toggleMobileMenu()" class="text-text-muted hover:text-text-primary">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>

                        <!-- Browser notification toggle -->
                        <div
                            class="flex items-center justify-between mt-2 sm:mt-4 dark:bg-zinc-50/10 bg-zinc-100 px-2 sm:px-3 py-1">
                            <span
                                class="text-xs sm:text-sm text-text-secondary">{{ __('Browser notification') }}</span>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" class="sr-only peer">
                                <div
                                    class="w-7 h-4 bg-zinc-700 rounded-full peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-accent transition-colors
                                    peer-checked:bg-accent after:content-[''] after:absolute after:top-[2px] after:left-[2px]
                                    after:bg-white after:rounded-full after:h-3 after:w-3 after:transition-all
                                    peer-checked:after:translate-x-4">
                                </div>
                            </label>
                        </div>

                        <!-- Search -->
                        <!-- Search -->
                        <div class="mt-3 sm:mt-4">
                            <div class="relative">
                                <input type="text" wire:model.live="searchTerm" placeholder="{{ __('Search') }}"
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
                    <!-- Messages List -->
                    <div class="flex-1 overflow-y-auto custom-scrollbar">
                        @forelse($users as $user)
                            <div wire:click="selectUser({{ $user->id }}, '{{ $user->full_name }}')"
                                onclick="selectMessage()"
                                class="flex items-center gap-2 sm:gap-3 p-3 sm:p-4 hover:bg-bg-hover cursor-pointer border-b border-zinc-800 
                                    {{ $receiverId == $user->id ? 'dark:bg-zinc-800 bg-zinc-200' : '' }} transition-colors">
                                @if ($user->avatar)
                                   
                                    <img src="{{ storage_url($user->avatar) }}" alt="{{ $user->full_name }}"
                                        class="w-8 h-8 sm:w-10 sm:h-10 rounded-full object-cover flex-shrink-0">
                                @else
                                 
                                    <div
                                        class="w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-gradient-to-br from-accent to-accent-foreground flex items-center justify-center text-white font-semibold text-xs sm:text-sm flex-shrink-0">
                                        {{ strtoupper(substr($user->full_name, 0, 2)) }}
                                    </div>
                                @endif
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center justify-between mb-1">
                                        <h4 class="text-text-primary font-semibold text-xs sm:text-sm truncate">
                                            {{ $user->full_name }}
                                        </h4>
                                        <span class="text-[10px] sm:text-xs text-text-muted">
                                            {{ $user->lastMessage ? $user->lastMessage->created_at_formatted : '' }}
                                        </span>
                                    </div>
                                    <p class="text-text-secondary text-[10px] sm:text-xs truncate">
                                        {{ $user->lastMessage ? \Illuminate\Support\Str::limit($user->lastMessage->message, 30) : 'No messages yet' }}
                                    </p>
                                </div>
                                @if ($user->unreadCount > 0)
                                    <div
                                        class="w-5 h-5 bg-accent rounded-full flex items-center justify-center flex-shrink-0">
                                        <span class="text-white text-[10px] font-bold">{{ $user->unreadCount }}</span>
                                    </div>
                                @endif
                            </div>
                        @empty
                            <div class="p-4 text-center text-text-muted text-sm">
                                {{ __('No users found') }}
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Right Side - Chat Area -->
                <div class="flex-1 flex flex-col min-h-[50vh] md:min-h-[20vh] rounded-lg bg-bg-secondary">
                    @if ($receiverId)
                        <!-- Chat Header -->
                        <div class="p-3 sm:p-4 flex items-center bg-zinc-50/10 rounded-t-lg justify-between">
                            <div class="flex items-center gap-2 sm:gap-3">
                                @if ($user->avatar)
                                   
                                    <img src="{{ storage_url($user->avatar) }}" alt="{{ $user->full_name }}"
                                        class="w-8 h-8 sm:w-10 sm:h-10 rounded-full object-cover flex-shrink-0">
                                @else
                                  
                                    <div
                                        class="w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-gradient-to-br from-accent to-accent-foreground flex items-center justify-center text-white font-semibold text-xs sm:text-sm flex-shrink-0">
                                        {{ strtoupper(substr($user->full_name, 0, 2)) }}
                                    </div>
                                @endif
                                <div>
                                    <h3 class="text-text-primary font-semibold text-sm sm:text-base">
                                        {{ $user->full_name }}</h3>
                                    <p class="text-text-secondary text-xs sm:text-sm">{{ __('Available') }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Messages Area -->
                        <div class="flex-1 overflow-y-auto custom-scrollbar p-3 sm:p-4 md:p-6 space-y-4 sm:space-y-6"
                            id="messagesContainer">
                            @forelse($messages as $msg)
                                @if ($msg->creater_id == Auth::id() && $msg->creater_type == get_class(Auth::user()))
                                    <!-- Current User Message -->
                                    <div class="flex items-start gap-2 sm:gap-3 flex-row-reverse">
                                        @if ($user->avatar)
                                            <img src="{{ auth_storage_url(user()->avatar) }}"
                                                alt="{{ $user->full_name }}"
                                                class="w-8 h-8 sm:w-10 sm:h-10 rounded-full object-cover flex-shrink-0">
                                        @else
                                            
                                            <div
                                                class="w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-gradient-to-br from-accent to-accent-foreground flex items-center justify-center text-white font-semibold text-xs sm:text-sm flex-shrink-0">
                                                {{ strtoupper(substr($user->full_name, 0, 2)) }}
                                            </div>
                                        @endif
                                        <div class="flex flex-col gap-1 sm:gap-2 max-w-[75%] sm:max-w-md items-end">
                                            @if ($msg->attachments)
                                                @php
                                                    $mediaArray = is_array($msg->attachments)
                                                        ? $msg->attachments
                                                        : json_decode($msg->attachments, true);
                                                @endphp
                                                @if ($mediaArray)
                                                    @foreach ($mediaArray as $mediaPath)
                                                        <div class="relative mb-2">
                                                            <img src="{{ asset('storage/' . $mediaPath) }}"
                                                                class="rounded-lg max-w-full">
                                                            <!-- Download Button -->
                                                            <a href="{{ asset('storage/' . $mediaPath) }}" download
                                                                class="absolute top-1 right-1 bg-black bg-opacity-50 text-white px-2 py-1 text-xs rounded hover:bg-opacity-70">
                                                                Download
                                                            </a>
                                                        </div>
                                                    @endforeach
                                                @endif
                                            @endif

                                            @if ($msg->message)
                                                <div
                                                    class="bg-gradient-to-r from-accent to-accent-foreground text-white px-3 sm:px-4 py-2 sm:py-3 rounded-2xl rounded-tr-none">
                                                    <p class="text-xs sm:text-sm break-words">{{ $msg->message }}</p>
                                                </div>
                                            @endif

                                            <span class="text-[10px] sm:text-xs text-text-muted">
                                                {{ $msg->created_at->format('M d, Y h:i A') }}
                                                @if ($msg->seen_at)
                                                    <span class="text-blue-500">✓✓</span>
                                                @endif
                                            </span>
                                        </div>
                                    </div>
                                @else
                                    <!-- Other User Message -->
                                    <div class="flex items-start gap-2 sm:gap-3">
                                        @php
                                            $otherUser = $msg->creator;
                                            $displayName =
                                                $otherUser->full_name ??
                                                ($otherUser->name ?? ($otherUser->username ?? 'U'));
                                        @endphp
                                        @if ($user->avatar)
                                            <img src="{{ storage_url($user->avatar) }}" alt="{{ $user->full_name }}"
                                                class="w-8 h-8 sm:w-10 sm:h-10 rounded-full object-cover flex-shrink-0">
                                        @else
                                            <div
                                                class="w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-gradient-to-br from-accent to-accent-foreground flex items-center justify-center text-white font-semibold text-xs sm:text-sm flex-shrink-0">
                                                {{ strtoupper(substr($user->full_name, 0, 2)) }}
                                            </div>
                                        @endif
                                        <div class="flex flex-col gap-1 sm:gap-2 max-w-[75%] sm:max-w-md">
                                            @if ($msg->attachments)
                                                @php
                                                    $mediaArray = is_array($msg->attachments)
                                                        ? $msg->attachments
                                                        : json_decode($msg->attachments, true);
                                                @endphp
                                                @if ($mediaArray)
                                                    @foreach ($mediaArray as $mediaPath)
                                                        <div class="relative mb-2">
                                                            <img src="{{ asset('storage/' . $mediaPath) }}"
                                                                class="rounded-lg max-w-full">
                                                            <!-- Download Button -->
                                                            <a href="{{ asset('storage/' . $mediaPath) }}" download
                                                                class="absolute top-1 right-1 bg-black bg-opacity-50 text-white px-2 py-1 text-xs rounded hover:bg-opacity-70">
                                                                Download
                                                            </a>
                                                        </div>
                                                    @endforeach
                                                @endif
                                            @endif

                                            @if ($msg->message)
                                                <div
                                                    class="bg-bg-hover text-text-primary px-3 sm:px-4 py-2 sm:py-3 rounded-2xl rounded-tl-none">
                                                    <p class="text-xs sm:text-sm break-words">{{ $msg->message }}</p>
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
                        <div class="p-3 sm:p-4">
                            <div class="flex items-end gap-2 sm:gap-3">
                                <div class="flex-1 relative">
                                    <textarea wire:model="message" wire:keydown.enter.prevent="sendMessage" rows="1"
                                        placeholder="Say something....."
                                        class="w-full bg-bg-hover text-text-white px-3 sm:px-4 py-2 sm:py-3 pr-12 sm:pr-14 rounded-lg border border-zinc-700 focus:outline-none focus:ring-2 focus:ring-accent resize-none text-xs sm:text-sm"
                                        style="min-height: 40px; max-height: 120px;"></textarea>
                                    <div
                                        class="absolute right-2 sm:right-3 bottom-3 sm:bottom-4 flex items-center gap-1 sm:gap-2">
                                        <label
                                            class="cursor-pointer text-text-muted hover:text-text-primary transition-colors">
                                            <input type="file" wire:model="media" class="hidden" accept="image/*"
                                                multiple>
                                            <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13">
                                                </path>
                                            </svg>
                                        </label>
                                        <button wire:click="sendMessage"
                                            class="text-text-muted hover:text-text-primary transition-colors">
                                            <svg class="w-5 h-5 -rotate-45" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            @if ($media)
                                <div class="mt-2 text-xs text-text-secondary">
                                    Image selected
                                    <button wire:click="$set('media', null)" class="text-red-500 ml-2">Remove</button>
                                </div>
                            @endif
                        </div>
                    @else
                        <!-- No User Selected -->
                        <div class="flex-1 flex items-center justify-center text-text-muted">
                            <div class="text-center">
                                <svg class="w-16 h-16 mx-auto mb-3 text-zinc-600" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                </svg>
                                <p class="text-sm">{{ __('Select a user to start chatting') }}</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div> --}}
            <div class="flex flex-col md:flex-row h-auto md:h-[68vh] gap-2 px-3 sm:px-4 relative">
                {{-- wire:poll.3s="loadMessages" --}}
                <!-- Mobile Overlay -->
                <div id="mobileOverlay" onclick="toggleMobileMenu()"
                    class="hidden fixed inset-0 bg-black bg-opacity-50 z-40 md:hidden"></div>

                <!-- Left Sidebar - Messages List -->
                <div id="messagesSidebar"
                    class="fixed md:static inset-y-0 left-0 transform -translate-x-full md:translate-x-0 transition-transform duration-300 ease-in-out z-30 w-full md:w-64 lg:w-72 xl:w-80 2xl:w-96 bg-bg-secondary rounded-lg flex flex-col md:mr-5 mb-1 md:mb-0 max-h-full md:max-h-full">
                    <div class="p-3 sm:p-4">
                        <!-- Close Button for Mobile -->
                        <div class="flex items-center justify-between mb-3 md:hidden">
                            <h3 class="text-text-primary font-semibold text-base">{{ __('Conversations') }}</h3>
                            <button onclick="toggleMobileMenu()" class="text-text-muted hover:text-text-primary">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>

                        <!-- Browser notification toggle -->
                        <div
                            class="flex items-center justify-between mt-2 sm:mt-4 dark:bg-zinc-50/10 bg-zinc-100 px-2 sm:px-3 py-1">
                            <span
                                class="text-xs sm:text-sm text-text-secondary">{{ __('Browser notification') }}</span>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" class="sr-only peer">
                                <div
                                    class="w-7 h-4 bg-zinc-700 rounded-full peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-accent transition-colors
                        peer-checked:bg-accent after:content-[''] after:absolute after:top-[2px] after:left-[2px]
                        after:bg-white after:rounded-full after:h-3 after:w-3 after:transition-all
                        peer-checked:after:translate-x-4">
                                </div>
                            </label>
                        </div>

                        <!-- Search -->
                        <div class="mt-3 sm:mt-4">
                            <div class="relative">
                                <input type="text" wire:model.live="searchTerm" placeholder="{{ __('Search') }}"
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
                    <!-- Messages List -->
                    <div class="flex-1 overflow-y-auto custom-scrollbar">
                        @forelse($users as $user)
                            <div wire:click="selectUser({{ $user->id }}, '{{ $user->full_name }}')"
                                onclick="selectMessage()"
                                class="flex items-center gap-2 sm:gap-3 p-3 sm:p-4 hover:bg-bg-hover cursor-pointer border-b border-zinc-800 
                                    {{ $receiverId == $user->id ? 'dark:bg-zinc-800 bg-zinc-200' : '' }} transition-colors">
                                @if ($user->avatar)
                                    {{-- Show actual avatar image --}}
                                    <img src="{{ storage_url($user->avatar) }}" alt="{{ $user->full_name }}"
                                        class="w-8 h-8 sm:w-10 sm:h-10 rounded-full object-cover flex-shrink-0">
                                @else
                                    {{-- Show initials --}}
                                    <div
                                        class="w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-gradient-to-br from-accent to-accent-foreground flex items-center justify-center text-white font-semibold text-xs sm:text-sm flex-shrink-0">
                                        {{ strtoupper(substr($user->full_name, 0, 2)) }}
                                    </div>
                                @endif
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center justify-between mb-1">
                                        <h4 class="text-text-primary font-semibold text-xs sm:text-sm truncate">
                                            {{ $user->full_name }}
                                        </h4>
                                        <span class="text-[10px] sm:text-xs text-text-muted">
                                            {{ $user->lastMessage ? $user->lastMessage->created_at_formatted : '' }}
                                        </span>
                                    </div>
                                    <p class="text-text-secondary text-[10px] sm:text-xs truncate">
                                        {{ $user->lastMessage ? \Illuminate\Support\Str::limit($user->lastMessage->message_body, 30) : 'No messages yet' }}
                                    </p>
                                </div>
                                @if ($user->unreadCount > 0)
                                    <div
                                        class="w-5 h-5 bg-accent rounded-full flex items-center justify-center flex-shrink-0">
                                        <span class="text-white text-[10px] font-bold">{{ $user->unreadCount }}</span>
                                    </div>
                                @endif
                            </div>
                        @empty
                            <div class="p-4 text-center text-text-muted text-sm">
                                {{ __('No users found') }}
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Right Side - Chat Area -->
                <div class="flex-1 flex flex-col min-h-[50vh] md:min-h-[20vh] rounded-lg bg-bg-secondary">
                    @if ($receiverId)
                        <!-- Chat Header -->
                        <div class="p-3 sm:p-4 flex items-center bg-zinc-50/10 rounded-t-lg justify-between">
                            <div class="flex items-center gap-2 sm:gap-3">
                                @php
                                    $selectedUser = collect($users)->firstWhere('id', $receiverId);
                                @endphp
                                @if ($selectedUser && $selectedUser->avatar)
                                    {{-- Show actual avatar image --}}
                                    <img src="{{ storage_url($selectedUser->avatar) }}"
                                        alt="{{ $selectedUser->full_name }}"
                                        class="w-8 h-8 sm:w-10 sm:h-10 rounded-full object-cover flex-shrink-0">
                                @else
                                    {{-- Show initials --}}
                                    <div
                                        class="w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-gradient-to-br from-accent to-accent-foreground flex items-center justify-center text-white font-semibold text-xs sm:text-sm flex-shrink-0">
                                        {{ strtoupper(substr($receiverName, 0, 2)) }}
                                    </div>
                                @endif
                                <div>
                                    <h3 class="text-text-primary font-semibold text-sm sm:text-base">
                                        {{ $receiverName }}</h3>
                                    <p class="text-text-secondary text-xs sm:text-sm">{{ __('Available') }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Messages Area -->
                        <div class="flex-1 overflow-y-auto custom-scrollbar p-3 sm:p-4 md:p-6 space-y-4 sm:space-y-6"
                            id="messagesContainer">
                            @forelse($messages as $msg)
                                @if ($msg->sender_id == Auth::id())
                                    <!-- Current User Message -->
                                    <div class="flex items-start gap-2 sm:gap-3 flex-row-reverse">
                                        @if (auth()->user()->avatar)
                                            <img src="{{ auth_storage_url(auth()->user()->avatar) }}"
                                                alt="{{ auth()->user()->full_name }}"
                                                class="w-8 h-8 sm:w-10 sm:h-10 rounded-full object-cover flex-shrink-0">
                                        @else
                                            {{-- Show initials --}}
                                            <div
                                                class="w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-gradient-to-br from-accent to-accent-foreground flex items-center justify-center text-white font-semibold text-xs sm:text-sm flex-shrink-0">
                                                {{ strtoupper(substr(auth()->user()->full_name, 0, 2)) }}
                                            </div>
                                        @endif
                                        <div class="flex flex-col gap-1 sm:gap-2 max-w-[75%] sm:max-w-md items-end">
                                            @if ($msg->attachments && $msg->attachments->count() > 0)
                                                @foreach ($msg->attachments as $attachment)
                                                    <div class="relative mb-2">
                                                        @if (
                                                            $attachment->attachment_type->value === 'image' ||
                                                                in_array($attachment->attachment_type->value, ['image', 'photo', 'picture']))
                                                            <img src="{{ asset('storage/' . $attachment->file_path) }}"
                                                                class="rounded-lg max-w-full">
                                                        @else
                                                            <a href="{{ asset('storage/' . $attachment->file_path) }}"
                                                                class="flex items-center gap-2 bg-bg-hover px-3 py-2 rounded-lg text-text-primary text-xs">
                                                                📎 {{ basename($attachment->file_path) }}
                                                            </a>
                                                        @endif
                                                        <!-- Download Button -->
                                                        <a href="{{ asset('storage/' . $attachment->file_path) }}"
                                                            download
                                                            class="absolute top-1 right-1 bg-black bg-opacity-50 text-white px-2 py-1 text-xs rounded hover:bg-opacity-70">
                                                            Download
                                                        </a>
                                                    </div>
                                                @endforeach
                                            @endif

                                            @if ($msg->message_body)
                                                <div
                                                    class="bg-gradient-to-r from-accent to-accent-foreground text-white px-3 sm:px-4 py-2 sm:py-3 rounded-2xl rounded-tr-none">
                                                    <p class="text-xs sm:text-sm break-words">{{ $msg->message_body }}
                                                    </p>
                                                </div>
                                            @endif

                                            <span class="text-[10px] sm:text-xs text-text-muted">
                                                {{ $msg->created_at->format('M d, Y h:i A') }}
                                                @if ($msg->readReceipts && $msg->readReceipts->where('user_id', '!=', Auth::id())->count() > 0)
                                                    <span class="text-blue-500">✓✓</span>
                                                @endif
                                            </span>
                                        </div>
                                    </div>
                                @else
                                    <!-- Other User Message -->
                                    <div class="flex items-start gap-2 sm:gap-3">
                                        @php
                                            $otherUser = $msg->sender;
                                            $displayName =
                                                $otherUser->full_name ??
                                                ($otherUser->name ?? ($otherUser->username ?? 'U'));
                                        @endphp
                                        @if ($otherUser && $otherUser->avatar)
                                            <img src="{{ storage_url($otherUser->avatar) }}"
                                                alt="{{ $displayName }}"
                                                class="w-8 h-8 sm:w-10 sm:h-10 rounded-full object-cover flex-shrink-0">
                                        @else
                                            <div
                                                class="w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-gradient-to-br from-accent to-accent-foreground flex items-center justify-center text-white font-semibold text-xs sm:text-sm flex-shrink-0">
                                                {{ strtoupper(substr($displayName, 0, 2)) }}
                                            </div>
                                        @endif
                                        <div class="flex flex-col gap-1 sm:gap-2 max-w-[75%] sm:max-w-md">
                                            @if ($msg->attachments && $msg->attachments->count() > 0)
                                                @foreach ($msg->attachments as $attachment)
                                                    <div class="relative mb-2">
                                                        @if (
                                                            $attachment->attachment_type->value === 'image' ||
                                                                in_array($attachment->attachment_type->value, ['image', 'photo', 'picture']))
                                                            <img src="{{ asset('storage/' . $attachment->file_path) }}"
                                                                class="rounded-lg max-w-full">
                                                        @else
                                                            <a href="{{ asset('storage/' . $attachment->file_path) }}"
                                                                class="flex items-center gap-2 bg-bg-hover px-3 py-2 rounded-lg text-text-primary text-xs">
                                                                📎 {{ basename($attachment->file_path) }}
                                                            </a>
                                                        @endif
                                                        <!-- Download Button -->
                                                        <a href="{{ asset('storage/' . $attachment->file_path) }}"
                                                            download
                                                            class="absolute top-1 right-1 bg-black bg-opacity-50 text-white px-2 py-1 text-xs rounded hover:bg-opacity-70">
                                                            Download
                                                        </a>
                                                    </div>
                                                @endforeach
                                            @endif

                                            @if ($msg->message_body)
                                                <div
                                                    class="bg-bg-hover text-text-primary px-3 sm:px-4 py-2 sm:py-3 rounded-2xl rounded-tl-none">
                                                    <p class="text-xs sm:text-sm break-words">{{ $msg->message_body }}
                                                    </p>
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
                        <div class="p-3 sm:p-4">
                            <div class="flex items-end gap-2 sm:gap-3">
                                <div class="flex-1 relative">
                                    <textarea wire:model="message" wire:keydown.enter.prevent="sendMessage" rows="1"
                                        placeholder="Say something....."
                                        class="w-full bg-bg-hover text-text-white px-3 sm:px-4 py-2 sm:py-3 pr-12 sm:pr-14 rounded-lg border border-zinc-700 focus:outline-none focus:ring-2 focus:ring-accent resize-none text-xs sm:text-sm"
                                        style="min-height: 40px; max-height: 120px;"></textarea>
                                    <div
                                        class="absolute right-2 sm:right-3 bottom-3 sm:bottom-4 flex items-center gap-1 sm:gap-2">
                                        <label
                                            class="cursor-pointer text-text-muted hover:text-text-primary transition-colors">
                                            <input type="file" wire:model="media" class="hidden" accept="image/*"
                                                multiple>
                                            <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13">
                                                </path>
                                            </svg>
                                        </label>
                                        <button wire:click="sendMessage"
                                            class="text-text-muted hover:text-text-primary transition-colors">
                                            <svg class="w-5 h-5 -rotate-45" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            @if ($media)
                                <div class="mt-2 text-xs text-text-secondary">
                                    Image selected
                                    <button wire:click="$set('media', null)" class="text-red-500 ml-2">Remove</button>
                                </div>
                            @endif
                        </div>
                    @else
                        <!-- No User Selected -->
                        <div class="flex-1 flex items-center justify-center text-text-muted">
                            <div class="text-center">
                                <svg class="w-16 h-16 mx-auto mb-3 text-zinc-600" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                </svg>
                                <p class="text-sm">{{ __('Select a user to start chatting') }}</p>
                            </div>
                        </div>
                    @endif
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

        // Auto scroll to bottom jokhn new message ashe
        document.addEventListener('livewire:load', function() {
            Livewire.hook('message.processed', (message, component) => {
                const container = document.getElementById('messagesContainer');
                if (container) {
                    container.scrollTop = container.scrollHeight;
                }
            });
        });
    </script>
</div>
