<div class="h-full z-50">
    <aside x-cloak :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
        class="fixed h-full lg:static inset-y-0 left-0 z-50 w-64 sm:w-72 md:w-80 lg:w-68 bg-bg-primary/80 transition-transform duration-300 ease-in-out lg:translate-x-0 overflow-y-auto">

        <div class="flex flex-col h-full">
            <!-- Mobile Close Button -->
            <div class="lg:hidden flex items-center justify-between px-4 py-3 border-b border-zinc-800">
                <span class="text-text-white font-semibold text-lg">{{ __('Menu') }}</span>
                <button @click="sidebarOpen = false" class="text-text-white hover:text-zinc-300">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <nav class="flex-1 px-3 py-4 space-y-2">
                <!-- Orders Dropdown -->
                <div x-data="{
                    ordersOpen: {{ in_array($pageSlug, ['purchased_orders', 'sold_orders']) ? 'true' : 'false' }},
                    isActive: {{ in_array($pageSlug, ['purchased_orders', 'sold_orders']) ? 'true' : 'false' }}
                }">
                    <!-- Orders button -->


                    <button x-cloak @click="ordersOpen = !ordersOpen"
                        :class="isActive
                            ?
                            'relative bg-[#1A0D2E] hover:bg-[#1a050f]' :
                            'relative bg-[#1A0D2E] hover:bg-[#1a050f63]'"
                        class="w-full bg-pink-400 dark:bg-zinc-950 flex items-center justify-between px-3 sm:px-4 py-2.5 sm:py-3 rounded-lg transition-all text-text-white overflow-hidden border border-zinc-800 hover:border-pink-600 ">

                        <!-- Left section -->
                        <span class="absolute left-0 top-0 h-full w-1.5 rounded-l-sm bg-pink-500"></span>
                        <div class="relative flex items-center space-x-2 sm:space-x-3">
                            <!-- Default left bar -->

                            <!-- Icon -->
                            <flux:icon name="shopping-cart" class="w-5 h-5 sm:w-6 sm:h-6 text-text-white" />

                            <!-- Label -->
                            <span class="text-xs sm:text-sm lg:text-base font-medium text-text-white">Orders</span>

                            <!-- Active gradient indicator -->
                            <div x-show="isActive" x-cloak
                                class="absolute left-0 top-0 w-1.5 sm:w-2 h-full from-pink-500 to-zinc-600 rounded-l-full z-50 transition-all">
                            </div>
                        </div>

                        <!-- Right section (chevrons) -->
                        <div class="flex items-center">
                            <flux:icon name="chevron-down" x-show="!ordersOpen" x-cloak
                                class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-text-white transition-transform duration-200" />
                            <flux:icon name="chevron-up" x-show="ordersOpen" x-cloak
                                class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-text-white transition-transform duration-200" />
                        </div>
                    </button>


                    <!-- Dropdown links -->
                    <div x-show="ordersOpen" x-collapse x-cloak class="mt-1 ml-6 sm:ml-8 space-y-1">
                        <a href="{{ route('user.purchased-orders') }}" wire:navigate @click="$root.sidebarOpen = false"
                            class="block px-2 sm:px-3 py-2 text-xs sm:text-sm lg:text-base rounded-lg transition-all text-text-white hover:bg-pink-500/50 {{ $pageSlug === 'purchased_orders' ? 'bg-pink-500' : 'bg-pink-300 dark:bg-zinc-950' }}">
                            {{ __('Purchased orders') }}
                        </a>
                        <a href="{{ route('user.sold-orders') }}" wire:navigate @click="$root.sidebarOpen = false"
                            class="block px-2 sm:px-3 py-2 text-xs sm:text-sm lg:text-base rounded-lg transition-all text-text-white hover:bg-pink-500/50 {{ $pageSlug === 'sold_orders' ? 'bg-pink-500' : 'bg-pink-300 dark:bg-zinc-950' }}">
                            {{ __('Sold orders') }}
                        </a>
                    </div>
                </div>
                <!-- Offers Dropdown -->
                <div x-data="{
                    ordersOpen: {{ in_array($pageSlug, ['currency', 'accounts', 'top-ups', 'items', 'gift-cards']) ? 'true' : 'false' }},
                    isActive: {{ in_array($pageSlug, ['currency', 'accounts', 'top-ups', 'items', 'gift-cards']) ? 'true' : 'false' }}
                }">

                    <button x-cloak @click="ordersOpen = !ordersOpen"
                        :class="isActive
                            ?
                            'relative bg-[#1A0D2E] hover:bg-[#1a050f]' :
                            'relative bg-[#1A0D2E] hover:bg-[#1a050f63]'"
                        class="w-full bg-pink-400 dark:bg-zinc-950 flex items-center justify-between px-3 sm:px-4 py-2.5 sm:py-3 rounded-lg transition-all text-text-white overflow-hidden border border-zinc-800 hover:border-pink-500 ">

                        <!-- Left section -->
                        <span class="absolute left-0 top-0 h-full w-1.5 rounded-l-sm bg-pink-500"></span>
                        <div class="relative flex items-center space-x-2 sm:space-x-3">
                            <!-- Default left bar -->

                            <!-- Icon -->
                            {{-- <flux:icon name="shopping-cart" class="w-5 h-5 sm:w-6 sm:h-6 text-text-white" /> --}}

                            <!-- Label -->
                            <x-phosphor-tag class="w-5 h-5 rotate-90 fill-text-text-white" />
                            <span class="text-xs sm:text-sm lg:text-base font-medium text-text-white">Offers</span>

                            <!-- Active gradient indicator -->
                            <div x-show="isActive" x-cloak
                                class="absolute left-0 top-0 w-1.5 sm:w-2 h-full from-pink-500 to-zinc-600 rounded-l-full z-50 transition-all">
                            </div>
                        </div>

                        <!-- Right section (chevrons) -->
                        <div class="flex items-center">
                            <flux:icon name="chevron-down" x-show="!ordersOpen" x-cloak
                                class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-text-white transition-transform duration-200" />
                            <flux:icon name="chevron-up" x-show="ordersOpen" x-cloak
                                class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-text-white transition-transform duration-200" />
                        </div>
                    </button>



                    <!-- Dropdown links -->
                    <div x-show="ordersOpen" x-collapse x-cloak class="mt-1 ml-6 sm:ml-8 space-y-1">
                        <a href="{{ route('user.currency') }}" wire:navigate @click="$root.sidebarOpen = false"
                            class="block px-2 sm:px-3 py-2 text-xs sm:text-sm lg:text-base rounded-lg transition-all text-text-white hover:bg-pink-500/50 {{ $pageSlug === 'currency' ? 'bg-pink-500' : 'bg-pink-300 dark:bg-zinc-950' }}">
                            {{ __('Currency') }}
                        </a>
                        <a href="{{ route('user.accounts') }}" wire:navigate @click="$root.sidebarOpen = false"
                            class="block px-2 sm:px-3 py-2 text-xs sm:text-sm lg:text-base rounded-lg transition-all text-text-white hover:bg-pink-500/50 {{ $pageSlug === 'accounts' ? 'bg-pink-500' : 'bg-pink-300 dark:bg-zinc-950' }}">
                            {{ __('Accounts') }}
                        </a>
                        <a href="{{ route('user.top-ups') }}" wire:navigate @click="$root.sidebarOpen = false"
                            class="block px-2 sm:px-3 py-2 text-xs sm:text-sm lg:text-base rounded-lg transition-all text-text-white hover:bg-pink-500/50 {{ $pageSlug === 'top-ups' ? 'bg-pink-500' : 'bg-pink-300 dark:bg-zinc-950' }}">
                            {{ __('Top Ups') }}
                        </a>
                        <a href="{{ route('user.items') }}" wire:navigate @click="$root.sidebarOpen = false"
                            class="block px-2 sm:px-3 py-2 text-xs sm:text-sm lg:text-base rounded-lg transition-all text-text-white hover:bg-pink-500/50 {{ $pageSlug === 'items' ? 'bg-pink-500' : 'bg-pink-300 dark:bg-zinc-950' }}">
                            {{ __('Items') }}
                        </a>
                        <a href="{{ route('user.gift-cards') }}" wire:navigate @click="$root.sidebarOpen = false"
                            class="block px-2 sm:px-3 py-2 text-xs sm:text-sm lg:text-base rounded-lg transition-all text-text-white hover:bg-pink-500/50 {{ $pageSlug === 'gift-cards' ? 'bg-pink-500' : 'bg-pink-300 dark:bg-zinc-950' }}">
                            {{ __('Gift Cards') }}
                        </a>
                    </div>
                </div>
                <!-- Boosting Link -->
                <div x-data="{
                    boostingOpen: {{ in_array($pageSlug, ['my-requests', 'received-requests']) ? 'true' : 'false' }},
                    isActive: {{ in_array($pageSlug, ['my-requests', 'received-requests']) ? 'true' : 'false' }}
                }">


                    <button x-cloak @click="boostingOpen = !boostingOpen"
                        :class="isActive
                            ?
                            'relative bg-[#1A0D2E] hover:bg-[#1a050f]' :
                            'relative bg-[#1A0D2E] hover:bg-[#1a050f63]'"
                        class="w-full bg-pink-400 dark:bg-zinc-950 flex items-center justify-between px-3 sm:px-4 py-2.5 sm:py-3 rounded-lg transition-all text-text-white overflow-hidden border border-zinc-800 hover:border-pink-500 ">

                        <!-- Left section -->
                        <span class="absolute left-0 top-0 h-full w-1.5 rounded-l-sm bg-pink-500"></span>
                        <div class="relative flex items-center space-x-2 sm:space-x-3">
                            <!-- Default left bar -->


                            <!-- Label -->
                            <x-phosphor name="circles-four" variant="solid"
                                class="w-5 h-5 rotate-90 fill-text-text-white" />
                            <span class="text-xs sm:text-sm lg:text-base font-medium text-text-white">Boosting</span>

                            <!-- Active gradient indicator -->
                            <div x-show="isActive" x-cloak
                                class="absolute left-0 top-0 w-1.5 sm:w-2 h-full from-pink-500 to-zinc-600 rounded-l-full z-50 transition-all">
                            </div>
                        </div>

                        <!-- Right section (chevrons) -->
                        <div class="flex items-center">
                            <flux:icon name="chevron-down" x-show="!boostingOpen" x-cloak
                                class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-text-white transition-transform duration-200" />
                            <flux:icon name="chevron-up" x-show="boostingOpen" x-cloak
                                class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-text-white transition-transform duration-200" />
                        </div>
                    </button>



                    <!-- Dropdown links -->
                    <div x-show="boostingOpen" x-collapse x-cloak class="mt-1 ml-6 sm:ml-8 space-y-1">
                        <a href="{{ route('user.my-requests') }}" wire:navigate @click="$root.sidebarOpen = false"
                            class="block px-2 sm:px-3 py-2 text-xs sm:text-sm lg:text-base rounded-lg transition-all text-text-white hover:bg-pink-500/50 ">
                            {{ __('My Requests') }}
                        </a>

                        <a href="{{ route('user.received-requests') }}" wire:navigate
                            @click="$root.sidebarOpen = false"
                            class="block px-2 sm:px-3 py-2 text-xs sm:text-sm lg:text-base rounded-lg transition-all text-text-white hover:bg-pink-500/50 {{ $pageSlug === 'received-requests' ? 'bg-pink-500' : 'bg-pink-300 dark:bg-zinc-950' }}">
                            {{ __('Received Requests') }}
                        </a>
                    </div>
                </div>


                <!-- Loyalty Link -->
                <a href="{{ route('user.loyalty') }}" wire:navigate @click="$root.sidebarOpen = false"
                    :class="isActive
                        ?
                        'relative bg-[#1A0D2E] hover:bg-[#1a050f]' :
                        'relative bg-[#1A0D2E] hover:bg-[#1a050f63]'"
                    class="relative w-full bg-pink-400 dark:bg-zinc-950 flex items-center justify-start gap-2 px-3 sm:px-4 py-2.5 sm:py-3 rounded-lg transition-all text-text-white overflow-hidden border border-zinc-800 hover:border-pink-500">

                    <!-- Left highlight bar -->
                    <span class="absolute left-0 top-0 h-full w-1.5 bg-pink-500 rounded-l-lg"></span>

                    <!-- Icon and text -->
                    <flux:icon name="trophy" class="w-4 h-4 sm:w-5 sm:h-5 text-text-white" />
                    <span class="text-xs sm:text-sm lg:text-base font-medium text-text-white">
                        {{ __('Loyalty') }}
                    </span>
                </a>

                <!-- Wallet Link -->
                <a href="{{ route('user.wallet') }}" wire:navigate @click="$root.sidebarOpen = false"
                    :class="isActive
                        ?
                        'relative bg-[#1A0D2E] hover:bg-[#1a050f]' :
                        'relative bg-[#1A0D2E] hover:bg-[#1a050f63]'"
                    class="relative w-full bg-pink-400 dark:bg-zinc-950 flex items-center justify-start gap-2 px-3 sm:px-4 py-2.5 sm:py-3 rounded-lg transition-all text-text-white overflow-hidden border border-zinc-800 hover:border-pink-500 {{ $pageSlug === 'wallet' ? 'bg-pink-500' : 'bg-pink-300 dark:bg-zinc-950'}}">
                    <span class="absolute left-0 top-0 h-full w-1.5 bg-pink-500 rounded-l-lg"></span>
                    <x-phosphor name="cardholder" variant="regular" class="w-4 h-4 sm:w-5 sm:h-5 text-text-white" />
                    <span
                        class="text-xs sm:text-sm lg:text-base font-medium text-text-white">{{ __('Wallet') }}</span>
                </a>

                <!-- messages Link -->
                <a href="{{ route('user.messages') }}" wire:navigate @click="$root.sidebarOpen = false"
                    :class="isActive
                        ?
                        'relative bg-[#1A0D2E] hover:bg-[#1a050f]' :
                        'relative bg-[#1A0D2E] hover:bg-[#1a050f63]'"
                    class="relative w-full bg-pink-400 dark:bg-zinc-950 flex items-center justify-start gap-2 px-3 sm:px-4 py-2.5 sm:py-3 rounded-lg transition-all text-text-white overflow-hidden border border-zinc-800 hover:border-pink-500 {{ $pageSlug === 'messages' ? 'bg-pink-500' : 'bg-pink-300 dark:bg-zinc-950'}}">
                    <span class="absolute left-0 top-0 h-full w-1.5 bg-pink-500 rounded-l-lg"></span>
                    <flux:icon name="chat-bubble-bottom-center-text" class="w-4 h-4 sm:w-5 sm:h-5 text-text-white" />
                    <span
                        class="text-xs sm:text-sm lg:text-base font-medium text-text-white">{{ __('Messages') }}</span>
                </a>


                <!-- notification Link -->
                <a href="{{ route('user.notification') }}" wire:navigate @click="$root.sidebarOpen = false"
                    :class="isActive
                        ?
                        'relative bg-[#1A0D2E] hover:bg-[#1a050f]' :
                        'relative bg-[#1A0D2E] hover:bg-[#1a050f]'"
                    class="relative w-full bg-pink-400 dark:bg-zinc-950 flex items-center justify-start gap-2 px-3 sm:px-4 py-2.5 sm:py-3 rounded-lg transition-all text-text-white overflow-hidden border border-zinc-800 hover:border-pink-500 {{ $pageSlug === 'notification' ? 'bg-pink-500' : 'bg-pink-300 dark:bg-zinc-950'}}">
                    <span class="absolute left-0 top-0 h-full w-1.5 bg-pink-500 rounded-l-lg"></span>
                    <flux:icon name="bell" class="w-4 h-4 sm:w-5 sm:h-5 text-text-white" />
                    <span
                        class="text-xs sm:text-sm lg:text-base font-medium text-text-white">{{ __('Notification') }}</span>
                </a>

                <!-- Feedback Link -->
                <a href="{{ route('user.feedback') }}" wire:navigate @click="$root.sidebarOpen = false"
                    :class="isActive
                        ?
                        'relative bg-[#1A0D2E] hover:bg-[#1a050f]' :
                        'relative bg-[#1A0D2E] hover:bg-[#1a050f]'"
                    class="relative w-full bg-pink-400 dark:bg-zinc-950 flex items-center justify-start gap-2 px-3 sm:px-4 py-2.5 sm:py-3 rounded-lg transition-all text-text-white overflow-hidden border border-zinc-800 hover:border-pink-500 {{ $pageSlug === 'feedback' ? 'bg-pink-500' : 'bg-pink-300 dark:bg-zinc-950'}}">
                    <span class="absolute left-0 top-0 h-full w-1.5 bg-pink-500 rounded-l-lg"></span>
                    <flux:icon name="star" class="w-4 h-4 sm:w-5 sm:h-5 text-text-white" />
                    <span
                        class="text-xs sm:text-sm lg:text-base font-medium text-text-white">{{ __('Feedback') }}</span>
                </a>



                {{-- settings --}}
                <a href="{{ route('user.account-settings') }}" wire:navigate @click="$root.sidebarOpen = false"
                    :class="isActive
                        ?
                        'relative bg-[#1A0D2E] hover:bg-[#1a050f]' :
                        'relative bg-[#1A0D2E] hover:bg-[#1a050f]'"
                    class="relative w-full bg-pink-400 dark:bg-zinc-950 flex items-center justify-start gap-2 px-3 sm:px-4 py-2.5 sm:py-3 rounded-lg transition-all text-text-white overflow-hidden border border-zinc-800 hover:border-pink-500 {{ $pageSlug === 'account-settings' ? 'bg-pink-500' : 'bg-pink-300 dark:bg-zinc-950'}}">
                    <span class="absolute left-0 top-0 h-full w-1.5 bg-pink-500 rounded-l-lg"></span>
                    <x-phosphor name="gear" class="w-4 h-4 sm:w-5 sm:h-5 fill-text-text-white" />
                    <span
                        class="text-xs sm:text-sm lg:text-base font-medium text-text-white">{{ __('Account Settings') }}</span>
                </a>


                <!-- View Profile Link -->
                <a href="{{ route('user.profile') }}" wire:navigate @click="$root.sidebarOpen = false"
                    :class="isActive
                        ?
                        'relative bg-[#1A0D2E] hover:bg-[#1a050f]' :
                        'relative bg-[#1A0D2E] hover:bg-[#1a050f]'"
                    class="relative w-full bg-pink-400 dark:bg-zinc-950 flex items-center justify-start gap-2 px-3 sm:px-4 py-2.5 sm:py-3 rounded-lg transition-all text-text-white overflow-hidden border border-zinc-800 hover:border-pink-500 {{ $pageSlug === 'user.profile' ? 'bg-pink-500' : 'bg-pink-300 dark:bg-zinc-950'}}">
                    <span class="absolute left-0 top-0 h-full w-1.5 bg-pink-500 rounded-l-lg"></span>
                    <flux:icon name="user" class="w-4 h-4 sm:w-5 sm:h-5 text-text-white" />
                    <span
                        class="text-xs sm:text-sm lg:text-base font-medium text-text-white">{{ __('View Profile') }}</span>
                </a>


            </nav>
        </div>
    </aside>
</div>
