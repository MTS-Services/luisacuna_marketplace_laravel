<div class="min-h-[30vh] bg-bg-secondary">
    <div class="container-fluid">
        <div class="p-4">
            <h2 class="text-2xl font-bold text-text-primary mb-4">Messages</h2>

            <!-- Unread message only toggle -->
            <div class="flex items-center justify-between mb-3">
                <div class="flex items-center gap-5 border border-zinc-500 px-3 py-1 rounded-md">
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
                                class="w-full bg-bg-hover text-text-primary px-4 py-3 pr-12 rounded-lg border border-zinc-700 focus:outline-none focus:ring-2 focus:ring-accent resize-none"
                                style="min-height: 48px; max-height: 120px;"></textarea>
                            <div class="absolute right-3 bottom-5 flex items-center gap-2">
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
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24"
                                        fill="none">
                                        <path
                                            d="M21.3112 2.689C21.1226 2.5005 20.8871 2.36569 20.629 2.29846C20.371 2.23122 20.0997 2.234 19.843 2.3065H19.829L1.83461 7.7665C1.54248 7.85069 1.28283 8.02166 1.09007 8.25676C0.897302 8.49185 0.780525 8.77997 0.75521 9.08294C0.729895 9.3859 0.797238 9.6894 0.948314 9.95323C1.09939 10.2171 1.32707 10.4287 1.60117 10.5602L9.56242 14.4377L13.4343 22.3943C13.5547 22.6513 13.7462 22.8685 13.9861 23.0201C14.226 23.1718 14.5042 23.2517 14.788 23.2502C14.8312 23.2502 14.8743 23.2484 14.9174 23.2446C15.2201 23.2201 15.5081 23.1036 15.7427 22.9107C15.9773 22.7178 16.1473 22.4578 16.2299 22.1656L21.6862 4.17119C21.6862 4.1665 21.6862 4.16181 21.6862 4.15712C21.7596 3.90115 21.7636 3.63024 21.6977 3.37223C21.6318 3.11421 21.4984 2.8784 21.3112 2.689ZM14.7965 21.7362L14.7918 21.7493V21.7427L11.0362 14.0271L15.5362 9.52712C15.6709 9.38533 15.7449 9.19651 15.7424 9.00094C15.7399 8.80537 15.6611 8.61852 15.5228 8.48022C15.3845 8.34191 15.1976 8.26311 15.002 8.26061C14.8065 8.2581 14.6177 8.3321 14.4759 8.46681L9.97586 12.9668L2.25742 9.21119H2.25086H2.26399L20.2499 3.75025L14.7965 21.7362Z"
                                            fill="white" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
