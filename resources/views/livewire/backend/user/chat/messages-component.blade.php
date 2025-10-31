<div class="bg-bg-secondary">
    <div class="container-fluid">
        <div class="p-4">
            <h2 class="text-xl sm:text-2xl lg:text-3xl  text-text-primary font-lato mb-4">Messages</h2>

            <!-- Unread message only toggle -->
            <div class="flex flex-col sm:flex-row items-center justify-between mb-3 gap-4">
                <div class="flex items-center gap-5 border border-zinc-500 px-3 py-1 w-full sm:w-auto justify-between rounded-md">
                    <span class="text-sm text-text-secondary">Unread message only</span>
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
                <div class="relative w-full sm:w-40 lg:w-44 xl:w-70">
                    <x-ui.select class="bg-surface-card border border-border-primary py-1.5! rounded-lg">
                        <option value="">All</option>
                        <option value="boosting">Boosting</option>
                        <option value="orders">Orders</option>
                        <option value="support">Support</option>
                        <option value="pre-purchase">Pre-purchase</option>
                    </x-ui.select>
                </div>
            </div>
            <!-- Mark all as read -->
            <a href="#" class="text-sm text-pink-500 hover:text-pink-400 transition-colors">
                Mark all as read
            </a>

        </div>
        <div class="flex h-[72vh] gap-2">
            <!-- Left Sidebar - Messages List -->
            <div class="w-70 bg-bg-primary rounded-lg  flex flex-col mr-5">
                <div class="p-5 ">
                    <!-- Browser notification toggle -->
                    <div class="flex items-center justify-between mt-4 dark:bg-zinc-50/10 bg-zinc-100 px-3 py-1">
                        <span class="text-sm text-text-secondary">Browser notification</span>
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
                    <div class="mt-4">
                        <div class="relative">
                            <input type="text" id="searchMessages" placeholder="Search"
                                class="w-full dark:bg-zinc-50/10 bg-zinc-100 text-text-white px-4 py-2 pr-10 rounded-lg  focus:outline-none focus:ring-2 focus:ring-zinc-500 text-sm">
                            <button class="absolute right-3 top-1/2 -translate-y-1/2 text-zinc-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Messages List -->
                <div class="flex-1 overflow-y-auto custom-scrollbar">
                    @php
                        $messages = [
                            [
                                'name' => 'VC_spams',
                                'message' => 'Hello! Nice to mee...',
                                'time' => 'Sep 25',
                                'avatar' => 'VS',
                                'unread' => true,
                                'active' => true,
                            ],
                            [
                                'name' => 'CynicX',
                                'message' => 'Oyster, breakfast burrito, veggies before burrito',
                                'time' => 'Sep 25',
                                'avatar' => 'CX',
                                'unread' => false,
                            ],
                            [
                                'name' => 'Gabriel2324',
                                'message' => 'How are you? Its been...',
                                'time' => 'Sep 25',
                                'avatar' => 'G2',
                                'unread' => false,
                            ],
                            [
                                'name' => 'ImagoQueen',
                                'message' => 'All of us were deeply mo...',
                                'time' => 'Sep 22',
                                'avatar' => 'IQ',
                                'unread' => false,
                            ],
                            [
                                'name' => 'PlanPulse',
                                'message' => 'I have always been curr...',
                                'time' => 'Sep 22',
                                'avatar' => 'PP',
                                'unread' => false,
                            ],
                            [
                                'name' => 'SoulWhishr',
                                'message' => 'If anything supersedes...',
                                'time' => 'Sep 19',
                                'avatar' => 'SW',
                                'unread' => false,
                            ],
                            [
                                'name' => 'BotLord',
                                'message' => 'A key theme which was...',
                                'time' => 'Sep 18',
                                'avatar' => 'BL',
                                'unread' => false,
                            ],
                            [
                                'name' => '@Chandler',
                                'message' => 'Could this BE any funnier...',
                                'time' => 'Sep 28',
                                'avatar' => 'CH',
                                'unread' => false,
                            ],
                            [
                                'name' => 'WiseMage',
                                'message' => 'I believe that ultimately...',
                                'time' => 'Sep 27',
                                'avatar' => 'WM',
                                'unread' => false,
                            ],
                            [
                                'name' => 'NightGamer',
                                'message' => 'GGs! When should I be...',
                                'time' => 'Sep 26',
                                'avatar' => 'NG',
                                'unread' => false,
                            ],
                            [
                                'name' => 'ComicMasters',
                                'message' => 'Thoughts on this new iss...',
                                'time' => 'Sep 26',
                                'avatar' => 'CM',
                                'unread' => false,
                            ],
                        ];
                    @endphp

                    @foreach ($messages as $msg)
                        <div
                            class="flex items-center gap-3 p-4 hover:bg-bg-hover cursor-pointer border-b border-zinc-800 {{ $msg['active'] ?? false ? 'dark:bg-zinc-800 bg-zinc-200' : '' }} transition-colors">
                            <div
                                class="w-10 h-10 rounded-full bg-gradient-to-br from-accent to-accent-foreground flex items-center justify-center text-white font-semibold text-sm flex-shrink-0">
                                {{ $msg['avatar'] }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center justify-between mb-1">
                                    <h4 class="text-text-primary font-semibold text-sm truncate">{{ $msg['name'] }}
                                    </h4>
                                    <span class="text-xs text-text-muted">{{ $msg['time'] }}</span>
                                </div>
                                <p class="text-text-secondary  text-xs truncate">{{ $msg['message'] }}</p>
                            </div>
                            @if ($msg['unread'])
                                <div class="w-2 h-2 bg-accent rounded-full flex-shrink-0"></div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Right Side - Chat Area -->
            <div class="flex-1 flex flex-col min-h-[20vh] rounded-lg bg-bg-primary">
                <!-- Chat Header -->
                <div class="p-4 flex items-center bg-zinc-50/10 rounded-t-lg justify-between">
                    <div class="flex items-center gap-3">
                        <div
                            class="w-12 h-12 rounded-full bg-gradient-to-br from-accent to-accent-foreground flex items-center justify-center text-white font-semibold">
                            VS
                        </div>
                        <div>
                            <h3 class="text-text-primary font-semibold">VC_spams</h3>
                            <p class="text-text-secondary text-sm">Available: Back by 10am</p>
                        </div>
                    </div>
                </div>

                <!-- Messages Area -->
                <div class="flex-1 overflow-y-auto custom-scrollbar p-6 space-y-6">
                    <!-- Message from other user -->
                    <div class="flex items-start gap-3">
                        <div
                            class="w-10 h-10 rounded-full bg-gradient-to-br from-accent to-accent-foreground flex items-center justify-center text-white font-semibold text-sm flex-shrink-0">
                            VS
                        </div>
                        <div class="flex flex-col gap-2 max-w-md">
                            <div class="bg-bg-hover text-text-primary px-4 py-3 rounded-2xl rounded-tl-none">
                                <p class="text-sm">Oyster, breakfast burrito, veggies before burrito</p>
                            </div>
                            <span class="text-xs text-text-muted">Oct 26,2025</span>
                        </div>
                    </div>

                    <!-- Message from current user -->
                    <div class="flex items-start gap-3 flex-row-reverse">
                        <div
                            class="w-10 h-10 rounded-full bg-gradient-to-br from-pink-500 to-purple-500 flex items-center justify-center text-white font-semibold text-sm flex-shrink-0">
                            <img src="https://via.placeholder.com/40" alt="User"
                                class="w-full h-full rounded-full object-cover">
                        </div>
                        <div class="flex flex-col gap-2 max-w-md items-end">
                            <div
                                class="bg-gradient-to-r from-accent to-accent-foreground text-white px-4 py-3 rounded-2xl rounded-tr-none">
                                <p class="text-sm">Confirmed, I am waiting for the delivery. When should I expect it?
                                </p>
                            </div>
                            <span class="text-xs text-text-muted">Oct 26,2025</span>
                        </div>
                    </div>

                    <!-- Another message from other user -->
                    <div class="flex items-start gap-3">
                        <div
                            class="w-10 h-10 rounded-full bg-gradient-to-br from-accent to-accent-foreground flex items-center justify-center text-white font-semibold text-sm flex-shrink-0">
                            VS
                        </div>
                        <div class="flex flex-col gap-2 max-w-md">
                            <div class="bg-bg-hover text-text-primary px-4 py-3 rounded-2xl rounded-tl-none">
                                <p class="text-sm">Okay</p>
                            </div>
                            <span class="text-xs text-text-muted">Oct 26,2025</span>
                        </div>
                    </div>
                </div>

                <!-- Message Input -->
                <div class="p-4">
                    <div class="flex items-end gap-3">
                        <div class="flex-1 relative">
                            <textarea rows="1" placeholder="Say something....."
                                class="w-full bg-bg-hover text-text-white px-4 py-3 pr-12 rounded-lg border border-zinc-700 focus:outline-none focus:ring-2 focus:ring-accent resize-none"
                                style="min-height: 48px; max-height: 120px;"></textarea>
                            <div class="absolute right-3 bottom-4 flex items-center gap-2">
                                <button class="text-text-muted hover:text-text-primary transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13">
                                        </path>
                                    </svg>
                                </button>
                                <button class="text-text-muted hover:text-text-primary transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                        </path>
                                    </svg>
                                </button>
                                <button class="text-text-muted hover:text-text-primary transition-colors">
                                    <flux:icon name="paper-airplane" class="w-5 h-5 mb-1 -rotate-45" />
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
