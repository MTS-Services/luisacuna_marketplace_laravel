<div class="h-[99vh]">
    <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
        class="sidebar h-full fixed lg:static inset-y-0 left-0 z-50 w-64 bg-zinc-250 border-r  transition-transform duration-300 ease-in-out lg:translate-x-0">

        <div class="flex flex-col h-full">
            <div class="flex items-center justify-between px-6 py-5 border-b border-gray-800">
                <div class="flex items-center space-x-2">
                    <div class="logo-gradient text-2xl font-bold">MDB</div>
                </div>
                <button @click="sidebarOpen = false" class="lg:hidden text-gray-400 hover:text-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <nav class="flex-1 px-4 py-6 overflow-y-auto">
                <div x-data="{ ordersOpen: {{ $pageSlug === 'dashboard' || $pageSlug === 'profile' ? 'true' : 'false' }} }">
                    <button @click="ordersOpen = !ordersOpen"
                        class="menu-item w-full flex items-center justify-between px-3 py-2.5 rounded-lg transition-colors {{ in_array($pageSlug, ['dashboard', 'profile',]) ? 'menu-active' : '' }}">
                        <div class="flex items-center space-x-3">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                            <span>Orders</span>
                        </div>
                        <svg :class="ordersOpen && 'rotate-180'" class="w-4 h-4 transition-transform" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <div x-show="ordersOpen" x-collapse class="ml-4 mt-2 space-y-1">
                        <a href="{{ route('user.dashboard') }}"
                            class="submenu-item flex items-center px-3 py-2 rounded-lg transition-colors {{ $pageSlug === 'dashboard' ? 'submenu-active' : '' }}">
                            <span>dashboard</span>
                        </a>
                        <a href="{{ route('user.profile') }}"
                            class="submenu-item flex items-center px-3 py-2 rounded-lg transition-colors {{ $pageSlug === 'profile' ? 'submenu-active' : '' }}">
                            <span>Profile</span>
                        </a>
                    </div>
                </div>

                <div x-data="{ offersOpen: false }" class="mt-2">
                    <button @click="offersOpen = !offersOpen"
                        class="menu-item w-full flex items-center justify-between px-3 py-2.5 rounded-lg transition-colors">
                        <div class="flex items-center space-x-3">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                            </svg>
                            <span>Offers</span>
                        </div>
                        <svg :class="offersOpen && 'rotate-180'" class="w-4 h-4 transition-transform" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                </div>

                <div x-data="{ boostingOpen: false }" class="mt-2">
                    <button @click="boostingOpen = !boostingOpen"
                        class="menu-item w-full flex items-center justify-between px-3 py-2.5 rounded-lg transition-colors">
                        <div class="flex items-center space-x-3">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                            <span>Boosting</span>
                        </div>
                        <svg :class="boostingOpen && 'rotate-180'" class="w-4 h-4 transition-transform" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                </div>

                <a href="#"
                    class="menu-item flex items-center space-x-3 px-3 py-2.5 rounded-lg transition-colors mt-2 {{ $pageSlug === 'loyalty' ? 'menu-active' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                    </svg>
                    <span>Loyalty</span>
                </a>

                <a href="#"
                    class="menu-item flex items-center space-x-3 px-3 py-2.5 rounded-lg transition-colors mt-2 {{ $pageSlug === 'wallet' ? 'menu-active' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                    </svg>
                    <span>Wallet</span>
                </a>

                <a href="#"
                    class="menu-item flex items-center space-x-3 px-3 py-2.5 rounded-lg transition-colors mt-2 {{ $pageSlug === 'messages' ? 'menu-active' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                    </svg>
                    <span>Messages</span>
                </a>

                <a href="#"
                    class="menu-item flex items-center space-x-3 px-3 py-2.5 rounded-lg transition-colors mt-2 {{ $pageSlug === 'notification' ? 'menu-active' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                    <span>Notification</span>
                </a>

                <a href="#"
                    class="menu-item flex items-center space-x-3 px-3 py-2.5 rounded-lg transition-colors mt-2 {{ $pageSlug === 'feedback' ? 'menu-active' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                    </svg>
                    <span>Feedback</span>
                </a>

                <a href="#"
                    class="menu-item flex items-center space-x-3 px-3 py-2.5 rounded-lg transition-colors mt-2 {{ $pageSlug === 'account-settings' ? 'menu-active' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <span>Account settings</span>
                </a>

                <a href="#"
                    class="menu-item flex items-center space-x-3 px-3 py-2.5 rounded-lg transition-colors mt-2 {{ $pageSlug === 'profile' ? 'menu-active' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    <span>View Profile</span>
                </a>
            </nav>
        </div>
    </aside>

    <div x-show="mobileMenuOpen" @click="mobileMenuOpen = false"
        x-transition:enter="transition-opacity ease-linear duration-300" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-linear duration-300"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
        class="fixed inset-0 bg-black bg-opacity-50 z-40 lg:hidden">
    </div>
</div>
