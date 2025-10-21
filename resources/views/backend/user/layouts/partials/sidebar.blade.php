<div class="h-full z-50">
    <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
        class="fixed h-full lg:static inset-y-0 left-0 z-50 w-64 bg-[#130924] transition-transform duration-300 ease-in-out lg:translate-x-0 overflow-y-auto">
        <div class="flex flex-col h-full">

            <nav class="flex-1 px-3 py-4 space-y-1">
                <div x-data="{ ordersOpen: {{ in_array($pageSlug, ['dashboard', 'profile']) ? 'true' : 'false' }} }">
                    <div class="relative">
                        <!-- Left indicator bar - only shows when dropdown is active -->
                        <div x-show="ordersOpen"
                            class="absolute left-0 top-0 w-2 h-full bg-gradient-to-b from-pink-500 to-purple-600 rounded-l-full z-50">
                        </div>

                        <button @click="ordersOpen = !ordersOpen"
                            class="w-full flex items-center justify-between px-3 bg-black py-3 rounded-lg transition-all text-white hover:bg-gray-500/50">
                            <div class="flex items-center space-x-3">
                                <img src="{{ asset('assets/icons/light.svg') }}" alt="">
                                <span class="text-sm font-medium text-white">Orders</span>
                            </div>

                            <!-- Chevron Icons -->
                            <flux:icon name="chevron-down" x-show="!ordersOpen" class="w-4 h-4 transition-transform"
                                stroke="white" />

                            <flux:icon name="chevron-up" x-show="ordersOpen" class="w-4 h-4 transition-transform"
                                stroke="white" />
                        </button>
                    </div>

                    <div x-show="ordersOpen" x-collapse class="mt-1 ml-8 space-y-1">
                        <a href="{{ route('user.dashboard') }}"
                            class="block px-3 py-2 text-sm rounded-lg transition-all text-white hover:bg-gray-500/50 {{ $pageSlug === 'dashboard' ? 'bg-pink-500' : '' }}">
                            Purchased orders
                        </a>
                        <a href="{{ route('user.profile') }}"
                            class="block px-3 py-2 text-sm rounded-lg transition-all text-white hover:bg-gray-500/50 {{ $pageSlug === 'profile' ? 'bg-pink-500' : '' }}">
                            Sold orders
                        </a>
                    </div>
                </div>

                <div x-data="{ offersOpen: {{ $pageSlug === 'offers' ? 'true' : 'false' }} }">
                    <button @click="offersOpen = !offersOpen"
                        class="w-full flex items-center justify-between px-3 py-2 rounded-lg transition-all text-white hover:bg-gray-500/50 {{ $pageSlug === 'offers' ? 'bg-gradient-to-r from-pink-500 to-purple-600' : '' }}">
                        <div class="flex items-center space-x-3">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="white" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 7h.01M7 3h5m-1 16L17 7m0 0l-5 5m5 0l5-5m-1 2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2h2V7a2 2 0 012-2h4a2 2 0 012 2v2" />
                            </svg>
                            <span class="text-sm font-medium text-white">Offers</span>
                        </div>
                        <svg :class="offersOpen && 'rotate-180'" class="w-4 h-4 transition-transform" fill="none"
                            stroke="white" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="offersOpen" x-collapse class="mt-1 ml-8 space-y-1">
                    </div>
                </div>

                <a href="#"
                    class="flex items-center space-x-3 px-3 py-2 rounded-lg transition-all text-white hover:bg-gray-500/50 {{ $pageSlug === 'loyalty' ? 'bg-gradient-to-r from-pink-500 to-purple-600' : '' }}">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="white" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                    </svg>
                    <span class="text-sm font-medium text-white">Loyalty</span>
                </a>

            </nav>
        </div>
    </aside>
</div>
