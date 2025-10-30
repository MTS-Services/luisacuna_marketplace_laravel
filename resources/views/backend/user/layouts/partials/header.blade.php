<header class="px-3 sm:px-4 md:px-6 py-3 sm:py-4 z-10 {{ request()->routeIs('home') ? 'bg-gradient-to-r from-zinc-950 via-black to-zinc-950' : 'glass-card' }}">
    <div class="flex items-center justify-between">
        <!-- Logo and Mobile Menu -->
        <div class="flex items-center gap-2 sm:gap-4">
            <!-- Mobile Menu Toggle -->
            <button @click="sidebarOpen = !sidebarOpen" class="lg:hidden text-text-white hover:text-zinc-300">
                <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>

            <!-- Logo -->
            <a href="{{ route('user.dashboard') }}" wire:navigate>
                <img src="{{ asset('assets/images/header_logo.png') }}" alt="Logo" class="h-6 sm:h-8 w-auto">
            </a>
        </div>

        <!-- Desktop Navigation -->
        @include('partials.user-navigation')

        <!-- Right Side Icons -->
        <div class="flex items-center gap-1 sm:gap-2">
            <!-- Mobile Search -->
            <button class="lg:hidden text-text-white hover:bg-zinc-800 p-1.5 sm:p-2 rounded transition-all">
                <svg class="w-4 h-4 sm:w-5 sm:h-5 text-text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </button>

            <!-- Messages -->
            <button class="text-text-white  p-1 sm:p-1.5 rounded transition-all">
                {{-- <img src="{{ asset('assets/icons/MessengerLogo.svg') }}" alt="Messages" class="w-5 h-5 sm:w-6 sm:h-6"> --}}
                <flux:icon name="chat-bubble-oval-left" class="w-5 h-5 sm:w-6 sm:h-6 text-text-white stroke-current" />
            </button>
            <flux:radio.group x-data variant="segmented" x-model="$flux.appearance">
                <flux:radio value="light" icon="sun" />
                <flux:radio value="dark" icon="moon" />
            </flux:radio.group>

            <!-- Notifications -->
            <button class="text-text-white hover:bg-zinc-800 p-1 sm:p-1.5 md:p-2 rounded transition-all relative">
                <svg class="w-4 h-4 sm:w-5 sm:h-5 text-text-btn-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                </svg>
                <span
                    class="absolute -top-1 -right-1 bg-gradient-to-r from-pink-500 to-red-500 text-text-white text-xs font-bold px-1 sm:px-1.5 py-0.5 rounded-full min-w-[18px] sm:min-w-[20px] text-center">1</span>
            </button>

            <div x-data="{ open: false }" class="relative">
                <button @click="open = !open"
                    class="flex items-center p-1 sm:p-1.5 rounded-lg text-text-white transition-all focus:outline-none">
                    <div class="w-7 h-7 sm:w-9 sm:h-9 md:w-10 md:h-10 rounded-full shadow-lg overflow-hidden">
                        <img src="{{ storage_url(auth()->user()->avatar) }}" class="w-full h-full object-cover"
                            alt="{{ auth()->user()->full_name ?? 'User Avatar' }}">
                    </div>
                </button>

                <!-- Dropdown Menu -->
                <div x-show="open" x-cloak @click.away="open = false"
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 transform scale-95"
                    x-transition:enter-end="opacity-100 transform scale-100"
                    x-transition:leave="transition ease-in duration-150"
                    x-transition:leave-start="opacity-100 transform scale-100"
                    x-transition:leave-end="opacity-0 transform scale-95"
                    class="absolute right-0 mt-2 w-48 sm:w-56 bg-zinc-900 border border-zinc-800 rounded-lg shadow-lg overflow-hidden z-50">

                    <div class="px-3 sm:px-4 py-2 sm:py-3 border-b border-zinc-800">
                        <p class="text-xs sm:text-sm font-semibold text-text-white truncate">{{ auth()->user()->full_name }}
                        </p>
                        <p class="text-xs text-zinc-400 truncate">{{ auth()->user()->email }}</p>
                    </div>

                    <a href="{{ route('user.profile') }}"
                        class="block px-3 sm:px-4 py-2 text-xs sm:text-sm text-zinc-400 hover:text-text-white hover:bg-zinc-800 transition-all">
                        Profile
                    </a>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="w-full text-left px-3 sm:px-4 py-2 text-xs sm:text-sm text-zinc-400 hover:text-text-white hover:bg-zinc-800 transition-all">
                            Logout
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>

    <!-- Mobile Navigation Menu -->
    <nav class="lg:hidden mt-3 sm:mt-4 pt-3 sm:pt-4 border-t border-zinc-800 flex flex-wrap gap-2 sm:gap-3">
        <a href="#"
            class="text-text-white text-xs font-medium hover:text-purple-400 transition-colors whitespace-nowrap">Currency</a>
        <a href="#"
            class="text-text-white text-xs font-medium hover:text-purple-400 transition-colors whitespace-nowrap">Gift
            Cards</a>
        <a href="#"
            class="text-text-white text-xs font-medium hover:text-purple-400 transition-colors whitespace-nowrap">Boosting</a>
        <a href="#"
            class="text-text-white text-xs font-medium hover:text-purple-400 transition-colors whitespace-nowrap">Items</a>
        <a href="#"
            class="text-text-white text-xs font-medium hover:text-purple-400 transition-colors whitespace-nowrap">Accounts</a>
        <a href="#"
            class="text-text-white text-xs font-medium hover:text-purple-400 transition-colors whitespace-nowrap">Top
            Ups</a>
        <a href="#"
            class="text-text-white text-xs font-medium hover:text-purple-400 transition-colors whitespace-nowrap">Coaching</a>
    </nav>
</header>
