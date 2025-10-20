<header class="bg-gray-950 border-b border-gray-800 px-6 py-4 z-10">
    <div class="flex items-center justify-between">
        <div class="flex items-center">
            <button @click="sidebarOpen = !sidebarOpen" class="md:hidden text-white hover:text-white">
                <svg class="w-6 h-6" fill="none" stroke="white" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>

      
        <nav class="hidden md:flex items-center gap-6 absolute left-1/2 transform -translate-x-1/2">
            <a href="#"
                class="text-sm font-medium pb-1 transition-all border-b-2
        {{ $pageSlug === 'currency' ? 'text-white border-purple-500' : 'text-gray-200 border-transparent hover:text-white hover:border-purple-500' }}">
                Currency
            </a>

            <a href="#"
                class="text-sm font-medium pb-1 transition-all border-b-2
        {{ $pageSlug === 'gift-cards' ? 'text-white border-purple-500' : 'text-gray-200 border-transparent hover:text-white hover:border-purple-500' }}">
                Gift Cards
            </a>

            <a href="#"
                class="text-sm font-medium pb-1 transition-all border-b-2
        {{ $pageSlug === 'boosting' ? 'text-white border-purple-500' : 'text-gray-200 border-transparent hover:text-white hover:border-purple-500' }}">
                Boosting
            </a>

            <a href="#"
                class="text-sm font-medium pb-1 transition-all border-b-2
        {{ $pageSlug === 'items' ? 'text-white border-purple-500' : 'text-gray-200 border-transparent hover:text-white hover:border-purple-500' }}">
                Items
            </a>

            <a href="#"
                class="text-sm font-medium pb-1 transition-all border-b-2
        {{ $pageSlug === 'accounts' ? 'text-white border-purple-500' : 'text-gray-200 border-transparent hover:text-white hover:border-purple-500' }}">
                Accounts
            </a>

            <a href="#"
                class="text-sm font-medium pb-1 transition-all border-b-2
        {{ $pageSlug === 'top-ups' ? 'text-white border-purple-500' : 'text-gray-200 border-transparent hover:text-white hover:border-purple-500' }}">
                Top Ups
            </a>

            <a href="#"
                class="text-sm font-medium pb-1 transition-all border-b-2
        {{ $pageSlug === 'coaching' ? 'text-white border-purple-500' : 'text-gray-200 border-transparent hover:text-white hover:border-purple-500' }}">
                Coaching
            </a>
        </nav>


        <div class="flex items-center gap-4">
            <div class="relative hidden sm:block">
                <input type="text" placeholder="search"
                    class="bg-gray-800 border border-gray-700 rounded-full py-2 pl-4 pr-10 text-sm text-white placeholder-gray-500 focus:outline-none focus:border-purple-500 focus:bg-gray-700 transition-all w-48 focus:w-64">
                <svg class="absolute right-3 top-1/2 -translate-y-1/2 w-5 h-5 text-white pointer-events-none"
                    fill="none" stroke="white" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>

            <div class="flex items-center gap-3">
                <button class="text-white hover:text-white hover:bg-gray-800 p-2 rounded transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="white" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                    </svg>
                </button>

                <button class="text-white hover:text-white hover:bg-gray-800 p-2 rounded transition-all relative">
                    <svg class="w-5 h-5" fill="none" stroke="white" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                    <span
                        class="absolute top-1 right-1 bg-gradient-to-r from-pink-500 to-red-500 text-white text-xs font-bold px-1.5 py-0.5 rounded-full">1</span>
                </button>

                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open"
                        class="flex flex-col items-center gap-1 p-2 rounded-lg text-white hover:text-white hover:bg-gray-800 transition-all focus:outline-none">

                        <div
                            class="w-8 h-8 rounded-full bg-gradient-to-br from-purple-500 to-pink-500 flex items-center justify-center text-sm font-semibold text-white">
                            {{ strtoupper(substr(auth()->user()->full_name, 0, 1)) }}
                        </div>
                    </button>


                    <div x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 transform scale-95"
                        x-transition:enter-end="opacity-100 transform scale-100"
                        x-transition:leave="transition ease-in duration-150"
                        x-transition:leave-start="opacity-100 transform scale-100"
                        x-transition:leave-end="opacity-0 transform scale-95"
                        class="absolute right-0 mt-2 w-56 bg-gray-900 border border-gray-800 rounded-lg shadow-lg overflow-hidden z-50">

                        <div class="px-4 py-3 border-b border-gray-800">
                            <p class="text-sm font-semibold text-white">{{ auth()->user()->full_name }}</p>
                            <p class="text-xs text-gray-400">{{ auth()->user()->email }}</p>
                        </div>

                        <a href="{{ route('user.profile') }}"
                            class="block px-4 py-2 text-sm text-gray-400 hover:text-white hover:bg-gray-800 transition-all">
                            Profile
                        </a>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" wire:click="logout"
                                class="w-full text-left px-4 py-2 text-sm text-gray-400 hover:text-white hover:bg-gray-800 transition-all">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <nav class="md:hidden mt-4 pt-4 border-t border-gray-800 flex flex-wrap gap-3">
        <a href="#" class="text-white text-xs font-medium hover:text-white">Currency</a>
        <a href="#" class="text-white text-xs font-medium hover:text-white">Gift Cards</a>
        <a href="#" class="text-white text-xs font-medium hover:text-white">Boosting</a>
        <a href="#" class="text-white text-xs font-medium hover:text-white">Items</a>
        <a href="#" class="text-white text-xs font-medium hover:text-white">Accounts</a>
        <a href="#" class="text-white text-xs font-medium hover:text-white">Top Ups</a>
        <a href="#" class="text-white text-xs font-medium hover:text-white">Coaching</a>
    </nav>
</header>