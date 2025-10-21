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
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M17.0306 9.96928C17.1004 10.0389 17.1557 10.1217 17.1934 10.2127C17.2312 10.3038 17.2506 10.4013 17.2506 10.4999C17.2506 10.5985 17.2312 10.6961 17.1934 10.7871C17.1557 10.8782 17.1004 10.9609 17.0306 11.0305L14.0306 14.0305C13.961 14.1003 13.8783 14.1556 13.7872 14.1933C13.6962 14.2311 13.5986 14.2505 13.5 14.2505C13.4014 14.2505 13.3038 14.2311 13.2128 14.1933C13.1217 14.1556 13.039 14.1003 12.9694 14.0305L10.5 11.5602L8.03062 14.0305C7.88989 14.1713 7.69902 14.2503 7.5 14.2503C7.30098 14.2503 7.1101 14.1713 6.96937 14.0305C6.82864 13.8898 6.74958 13.6989 6.74958 13.4999C6.74958 13.3009 6.82864 13.11 6.96937 12.9693L9.96937 9.96928C10.039 9.89955 10.1217 9.84423 10.2128 9.80649C10.3038 9.76874 10.4014 9.74932 10.5 9.74932C10.5986 9.74932 10.6962 9.76874 10.7872 9.80649C10.8783 9.84423 10.961 9.89955 11.0306 9.96928L13.5 12.4396L15.9694 9.96928C16.039 9.89955 16.1217 9.84423 16.2128 9.80649C16.3038 9.76874 16.4014 9.74932 16.5 9.74932C16.5986 9.74932 16.6962 9.76874 16.7872 9.80649C16.8783 9.84423 16.961 9.89955 17.0306 9.96928ZM21.75 11.9999C21.7504 13.6832 21.3149 15.338 20.486 16.803C19.6572 18.2681 18.4631 19.4937 17.02 20.3604C15.577 21.2271 13.9341 21.7054 12.2514 21.7488C10.5686 21.7922 8.9033 21.3992 7.4175 20.608L4.22531 21.6721C3.96102 21.7602 3.6774 21.773 3.40624 21.709C3.13509 21.645 2.88711 21.5068 2.69011 21.3098C2.49311 21.1128 2.35486 20.8648 2.29087 20.5937C2.22688 20.3225 2.23967 20.0389 2.32781 19.7746L3.39187 16.5824C2.69639 15.2748 2.30793 13.826 2.256 12.3458C2.20406 10.8657 2.49001 9.39316 3.09213 8.04003C3.69425 6.6869 4.59672 5.48873 5.73105 4.53646C6.86537 3.58419 8.20173 2.90285 9.63869 2.54416C11.0756 2.18548 12.5754 2.15886 14.0242 2.46635C15.473 2.77383 16.8327 3.40733 18.0001 4.31875C19.1675 5.23018 20.1119 6.39558 20.7616 7.7265C21.4114 9.05741 21.7494 10.5189 21.75 11.9999ZM20.25 11.9999C20.2496 10.7344 19.9582 9.48593 19.3981 8.3511C18.838 7.21627 18.0244 6.2255 17.0201 5.45544C16.0159 4.68537 14.8479 4.15666 13.6067 3.91021C12.3654 3.66375 11.084 3.70616 9.86178 4.03415C8.63951 4.36215 7.50909 4.96693 6.55796 5.80171C5.60682 6.6365 4.86049 7.6789 4.37668 8.84828C3.89288 10.0177 3.68458 11.2827 3.7679 12.5454C3.85122 13.8082 4.22393 15.0349 4.85719 16.1305C4.91034 16.2225 4.94334 16.3247 4.954 16.4304C4.96467 16.5361 4.95276 16.6429 4.91906 16.7437L3.75 20.2499L7.25625 19.0799C7.35707 19.0463 7.46386 19.0346 7.56956 19.0454C7.67526 19.0562 7.77746 19.0894 7.86937 19.1427C9.12354 19.8681 10.5466 20.2505 11.9955 20.2513C13.4443 20.2521 14.8678 19.8713 16.1228 19.1473C17.3777 18.4232 18.4199 17.3815 19.1444 16.1268C19.8689 14.8721 20.2502 13.4488 20.25 11.9999Z"
                            fill="white" />
                    </svg>
                </button>

                <button class="text-white hover:text-white hover:bg-gray-800 p-2 rounded transition-all relative">
                    <svg class="w-5 h-5" fill="none" stroke="white" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                    <span
                        class="absolute top-0 right-0 bg-gradient-to-r from-pink-500 to-red-500 text-white text-xs font-bold px-1.5 py-0.5 rounded-full">1</span>
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
