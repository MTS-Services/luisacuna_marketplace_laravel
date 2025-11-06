<header x-data="{ mobileMenuOpen: false, notification: false, dropdown: '', globalSearchModal: false, open: '' }" x-cloak
    class="sticky top-0 z-50  {{ request()->routeIs('home') ? 'bg-linear-to-r from-zinc-950/50 via-text-text-white to-zinc-950/50 glass-card shadow-none!' : 'glass-card' }}">
    <div class="{{ request()->routeIs('user.*') ? '' : '2xl:container-wide container' }} px-4 py-4 flex items-center justify-between relative"
        x-cloak>
        <div class=""><a href="{{ route('home') }}">
                <img src="{{ asset('assets/images/header_logo.png') }}" alt=""></a>
        </div>
        @include('partials.user-navigation')

        <div class="flex items-center">
            <button @click="globalSearchModal = true"
                class="md:hidden btn btn-ghost btn-circle hover:bg-zinc-500/20 mr-2">
                <flux:icon name="magnifying-glass" class="w-6 h-6 text-text-text-white" />
            </button>
            @auth
                <button class="btn btn-ghost btn-circle hover:bg-zinc-500/20">
                    <flux:icon name="chat-bubble-oval-left" class="w-6 h-6 text-text-text-white" />
                </button>

                <button class="btn btn-ghost btn-circle hover:bg-zinc-500/20 mr-2" @click="notification = !notification">
                    <div class="indicator">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 stroke-text-primary" fill="none"
                            viewBox="0 0 24 24" stroke="white">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                        <span class="badge badge-xs badge-primary indicator-item">1</span>
                    </div>
                </button>
            @endauth
            <div class="flex items-center ml-2" x-data>
                <!-- Light Mode Button -->
                <button type="button" @click="$flux.dark = false" :aria-pressed="!$flux.dark"
                    class="flex items-center justify-center w-10 h-8 text-lg rounded-l-full transition-colors duration-200 hidden md:flex"
                    :class="!$flux.dark ?
                        'bg-zinc-400 text-text-white' :
                        'bg-transparent text-zinc-600 dark:text-zinc-300'">
                    <flux:icon name="sun" class="w-5 h-5 stroke-white" />
                </button>

                <!-- Dark Mode Button -->
                <button type="button" @click="$flux.dark = true" :aria-pressed="$flux.dark"
                    class="flex items-center justify-center w-10 h-8 text-lg rounded-r-full transition-colors duration-200 hidden md:flex"
                    :class="$flux.dark ?
                        'bg-zinc-400 text-text-white' :
                        'bg-transparent text-zinc-600 dark:text-zinc-300'">
                    <flux:icon name="moon" class="w-5 h-5 stroke-current" />
                </button>

                <div x-show="$flux.dark" class="md:hidden">
                    <flux:icon name="moon" class="w-5 h-5 stroke-current" @click="$flux.dark = false" />
                </div>
                <div x-show="!$flux.dark" class="md:hidden">
                    <flux:icon name="sun" class="w-5 h-5 stroke-current" @click="$flux.dark = true" />
                </div>
            </div>
            @auth
                <!-- User Profile Dropdown -->
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open"
                        class="flex items-center p-1 sm:p-1.5 rounded-lg text-text-white transition-all focus:outline-none">
                        <div class="w-7 h-7 sm:w-9 sm:h-9 md:w-14 md:h-14 rounded-full shadow-lg overflow-hidden">
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
                        class="absolute right-0 mt-2 w-56 sm:w-64 xl:w-90 2xl:w-96 bg-bg-primary  rounded-xl shadow-2xl overflow-hidden z-50">

                        <!-- User Info Header -->
                        <div class="px-4 py-5 shadow-lg bg-bg-secondary">
                            <p class="text-sm font-semibold text-text-white truncate">
                                {{ auth()->user()->full_name }}
                            </p>
                            <p class="text-xs text-zinc-400 truncate">{{ auth()->user()->email }}</p>
                        </div>

                        <div class="flex-1 px-3 py-4 space-y-2 max-h-[calc(100vh-200px)] overflow-y-auto">
                            <!-- Orders Dropdown -->
                            <div x-data="{
                                ordersOpen: {{ in_array($pageSlug, ['purchased_orders', 'sold_orders']) ? 'true' : 'false' }},
                                isActive: {{ in_array($pageSlug, ['purchased_orders', 'sold_orders']) ? 'true' : 'false' }}
                            }">
                                <!-- Orders button -->
                                <button x-cloak @click="ordersOpen = !ordersOpen"
                                    :class="isActive ? 'bg-pink-300 dark:bg-zinc-950 relative' : 'bg-pink-400 dark:bg-zinc-950'"
                                    class="w-full flex items-center justify-between px-2 sm:px-3 py-2.5 sm:py-3 rounded-lg transition-all text-text-white hover:bg-pink-500/50">
                                    <div class="flex items-center space-x-2 sm:space-x-3">
                                        <flux:icon name="shopping-cart" class="w-5 h-5 sm:w-6 sm:h-6 text-text-white" />
                                        <span class="text-xs  font-medium text-text-white">{{ __('Orders') }}</span>

                                        <!-- Left indicator bar -->
                                        <div x-show="isActive" x-cloak
                                            class="absolute left-0 top-0 w-1.5 sm:w-2 h-full bg-linear-to-b from-pink-500 to-zinc-600 rounded-l-full z-50">
                                        </div>
                                    </div>

                                    <!-- Chevron Icons -->
                                    <flux:icon name="chevron-down" x-show="!ordersOpen" x-cloak
                                        class="w-3.5 h-3.5 sm:w-4 sm:h-4 transition-transform text-text-white" />
                                    <flux:icon name="chevron-up" x-show="ordersOpen" x-cloak
                                        class="w-3.5 h-3.5 sm:w-4 sm:h-4 transition-transform text-text-white" />
                                </button>

                                <!-- Dropdown links -->
                                <div x-show="ordersOpen" x-collapse x-cloak class="mt-1 ml-6 sm:ml-8 space-y-1">
                                    <a href="{{ route('user.purchased-orders') }}" wire:navigate
                                        @click="$root.sidebarOpen = false"
                                        class="block px-2 sm:px-3 py-2 text-xs  rounded-lg transition-all text-text-white hover:bg-pink-500/50 {{ $pageSlug === 'purchased_orders' ? 'bg-pink-500' : 'bg-pink-300 dark:bg-zinc-950' }}">
                                        {{ __('Purchased orders') }}
                                    </a>
                                    <a href="{{ route('user.sold-orders') }}" wire:navigate
                                        @click="$root.sidebarOpen = false"
                                        class="block px-2 sm:px-3 py-2 text-xs  rounded-lg transition-all text-text-white hover:bg-pink-500/50 {{ $pageSlug === 'sold_orders' ? 'bg-pink-500' : 'bg-pink-300 dark:bg-zinc-950' }}">
                                        {{ __('Sold orders') }}
                                    </a>
                                </div>
                            </div>
                            <!-- Offers Dropdown -->
                            <div x-data="{
                                ordersOpen: {{ in_array($pageSlug, ['currency', 'accounts', 'top-ups', 'items', 'gift-cards']) ? 'true' : 'false' }},
                                isActive: {{ in_array($pageSlug, ['currency', 'accounts', 'top-ups', 'items', 'gift-cards']) ? 'true' : 'false' }}
                            }">
                                <!-- Offers button -->
                                <button x-cloak @click="ordersOpen = !ordersOpen"
                                    :class="isActive ? 'bg-pink-300 dark:bg-zinc-950 relative' : 'bg-pink-400 dark:bg-zinc-950'"
                                    class="w-full flex items-center justify-between px-2 sm:px-3 py-2.5 sm:py-3 rounded-lg transition-all text-text-white hover:bg-pink-500/50">
                                    <div class="flex items-center space-x-2 sm:space-x-3">
                                        <x-phosphor-tag class="w-5 h-5 rotate-90 fill-text-text-white" />
                                        <span class="text-xs  font-medium text-text-white">Offers</span>

                                        <!-- Left indicator bar -->
                                        <div x-show="isActive" x-cloak
                                            class="absolute left-0 top-0 w-1.5 sm:w-2 h-full bg-gradient-to-b from-pink-500 to-zinc-600 rounded-l-full z-50">
                                        </div>
                                    </div>

                                    <!-- Chevron Icons -->
                                    <flux:icon name="chevron-down" x-show="!ordersOpen" x-cloak
                                        class="w-3.5 h-3.5 sm:w-4 sm:h-4 transition-transform text-text-white" />
                                    <flux:icon name="chevron-up" x-show="ordersOpen" x-cloak
                                        class="w-3.5 h-3.5 sm:w-4 sm:h-4 transition-transform text-text-white" />
                                </button>

                                <!-- Dropdown links -->
                                <div x-show="ordersOpen" x-collapse x-cloak class="mt-1 ml-6 sm:ml-8 space-y-1">
                                    <a href="{{ route('user.currency') }}" wire:navigate
                                        @click="$root.sidebarOpen = false"
                                        class="block px-2 sm:px-3 py-2 text-xs  rounded-lg transition-all text-text-white hover:bg-pink-500/50 {{ $pageSlug === 'currency' ? 'bg-pink-500' : 'bg-pink-300 dark:bg-zinc-950' }}">
                                        {{ __('Currency') }}
                                    </a>
                                    <a href="{{ route('user.accounts') }}" wire:navigate
                                        @click="$root.sidebarOpen = false"
                                        class="block px-2 sm:px-3 py-2 text-xs  rounded-lg transition-all text-text-white hover:bg-pink-500/50 {{ $pageSlug === 'accounts' ? 'bg-pink-500' : 'bg-pink-300 dark:bg-zinc-950' }}">
                                        {{ __('Accounts') }}
                                    </a>
                                    <a href="{{ route('user.top-ups') }}" wire:navigate
                                        @click="$root.sidebarOpen = false"
                                        class="block px-2 sm:px-3 py-2 text-xs  rounded-lg transition-all text-text-white hover:bg-pink-500/50 {{ $pageSlug === 'top-ups' ? 'bg-pink-500' : 'bg-pink-300 dark:bg-zinc-950' }}">
                                        {{ __('Top Ups') }}
                                    </a>
                                    <a href="{{ route('user.items') }}" wire:navigate @click="$root.sidebarOpen = false"
                                        class="block px-2 sm:px-3 py-2 text-xs  rounded-lg transition-all text-text-white hover:bg-pink-500/50 {{ $pageSlug === 'items' ? 'bg-pink-500' : 'bg-pink-300 dark:bg-zinc-950' }}">
                                        {{ __('Items') }}
                                    </a>
                                    <a href="{{ route('user.gift-cards') }}" wire:navigate
                                        @click="$root.sidebarOpen = false"
                                        class="block px-2 sm:px-3 py-2 text-xs  rounded-lg transition-all text-text-white hover:bg-pink-500/50 {{ $pageSlug === 'gift-cards' ? 'bg-pink-500' : 'bg-pink-300 dark:bg-zinc-950' }}">
                                        {{ __('Gift Cards') }}
                                    </a>
                                </div>
                            </div>
                            <!-- Boosting Link -->
                            <div x-data="{
                                boostingOpen: {{ in_array($pageSlug, ['my-requests', 'received-requests']) ? 'true' : 'false' }},
                                isActive: {{ in_array($pageSlug, ['my-requests', 'received-requests']) ? 'true' : 'false' }}
                            }">
                                <!-- Boosting button -->
                                <button x-cloak @click="boostingOpen = !boostingOpen"
                                    :class="isActive ? 'bg-pink-300 dark:bg-zinc-950 relative' : 'bg-pink-400 dark:bg-zinc-950'"
                                    class="w-full flex items-center justify-between px-2 sm:px-3 py-2.5 sm:py-3 rounded-lg transition-all text-text-white hover:bg-pink-500/50">
                                    <div class="flex items-center space-x-2 sm:space-x-3">
                                        <x-phosphor name="circles-four" variant="solid"
                                            class="w-5 h-5 rotate-90 fill-text-text-white" />
                                        <span class="text-xs  font-medium text-text-white">Boosting</span>

                                        <!-- Left indicator bar -->
                                        <div x-show="isActive" x-cloak
                                            class="absolute left-0 top-0 w-1.5 sm:w-2 h-full bg-gradient-to-b from-pink-500 to-zinc-600 rounded-l-full z-50">
                                        </div>
                                    </div>

                                    <!-- Chevron Icons -->
                                    <flux:icon name="chevron-down" x-show="!boostingOpen" x-cloak
                                        class="w-3.5 h-3.5 sm:w-4 sm:h-4 transition-transform text-text-white" />
                                    <flux:icon name="chevron-up" x-show="boostingOpen" x-cloak
                                        class="w-3.5 h-3.5 sm:w-4 sm:h-4 transition-transform text-text-white" />
                                </button>

                                <!-- Dropdown links -->
                                <div x-show="boostingOpen" x-collapse x-cloak class="mt-1 ml-6 sm:ml-8 space-y-1">
                                    <a href="{{ route('user.my-requests') }}" wire:navigate
                                        @click="$root.sidebarOpen = false"
                                        class="block px-2 sm:px-3 py-2 text-xs  rounded-lg transition-all text-text-white hover:bg-pink-500/50 {{ $pageSlug === 'my-requests' ? 'bg-pink-500' : 'bg-pink-300 dark:bg-zinc-950' }}">
                                        {{ __('My Requests') }}
                                    </a>
                                    <a href="{{ route('user.received-requests') }}" wire:navigate
                                        @click="$root.sidebarOpen = false"
                                        class="block px-2 sm:px-3 py-2 text-xs  rounded-lg transition-all text-text-white hover:bg-pink-500/50 {{ $pageSlug === 'received-requests' ? 'bg-pink-500' : 'bg-pink-300 dark:bg-zinc-950' }}">
                                        {{ __('Received Requests') }}
                                    </a>
                                </div>
                            </div>
                            <!-- Loyalty Link -->
                            <a href="{{ route('user.loyalty') }}" wire:navigate @click="$root.sidebarOpen = false"
                                class="flex items-center space-x-2 sm:space-x-3 px-2 sm:px-3 py-2 rounded-lg transition-all text-text-white hover:bg-pink-500/50 {{ $pageSlug === 'loyalty' ? 'bg-pink-500' : 'bg-pink-300 dark:bg-zinc-950' }}">
                                <flux:icon name="trophy" class="w-4 h-4 sm:w-5 sm:h-5 text-text-white" />
                                <span class="text-xs  font-medium text-text-white">{{ __('Loyalty') }}</span>
                            </a>
                            <!-- Wallet Link -->
                            <a href="{{ route('user.wallet') }}" wire:navigate @click="$root.sidebarOpen = false"
                                class="flex items-center space-x-2 sm:space-x-3 px-2 sm:px-3 py-2 rounded-lg transition-all text-text-white hover:bg-pink-500/50 {{ $pageSlug === 'wallet' ? 'bg-pink-500' : 'bg-pink-300 dark:bg-zinc-950' }}">
                                <x-phosphor name="cardholder" variant="regular"
                                    class="w-4 h-4 sm:w-5 sm:h-5 text-text-white" />
                                <span class="text-xs  font-medium text-text-white">{{ __('Wallet') }}</span>
                            </a>
                            <!-- messages Link -->
                            <a href="{{ route('user.messages') }}" wire:navigate @click="$root.sidebarOpen = false"
                                class="flex items-center space-x-2 sm:space-x-3 px-2 sm:px-3 py-2 rounded-lg transition-all text-text-white hover:bg-pink-500/50 {{ $pageSlug === 'messages' ? 'bg-pink-500' : 'bg-pink-300 dark:bg-zinc-950' }}">
                                <flux:icon name="chat-bubble-bottom-center-text"
                                    class="w-4 h-4 sm:w-5 sm:h-5 text-text-white" />
                                <span class="text-xs  font-medium text-text-white">{{ __('Messages') }}</span>
                            </a>
                            <!-- Feedback Link -->
                            <a href="{{ route('user.feedback') }}" wire:navigate @click="$root.sidebarOpen = false"
                                class="flex items-center space-x-2 sm:space-x-3 px-2 sm:px-3 py-2 rounded-lg transition-all text-text-white hover:bg-pink-500/50 {{ $pageSlug === 'feedback' ? 'bg-pink-500' : 'bg-pink-300 dark:bg-zinc-950' }}">
                                <flux:icon name="star" class="w-4 h-4 sm:w-5 sm:h-5 text-text-white" />
                                <span class="text-xs  font-medium text-text-white">{{ __('Feedback') }}</span>
                            </a>
                            {{-- settings --}}
                            <a href="{{ route('user.account-settings') }}" wire:navigate
                                @click="$root.sidebarOpen = false"
                                class="flex items-center space-x-2 sm:space-x-3 px-2 sm:px-3 py-2 rounded-lg transition-all text-text-white hover:bg-pink-500/50 {{ $pageSlug === 'account-settings' ? 'bg-pink-500' : 'bg-pink-300 dark:bg-zinc-950' }}">
                                <x-phosphor name="gear" class="w-4 h-4 sm:w-5 sm:h-5 fill-text-text-white" />
                                <span class="text-xs  font-medium text-text-white">{{ __('Account Settings') }}</span>
                            </a>
                            <!-- View Profile Link -->
                            {{-- <a href="{{ route('user.profile') }}" wire:navigate @click="$root.sidebarOpen = false"
                            class="flex items-center space-x-2 sm:space-x-3 px-2 sm:px-3 py-2 rounded-lg transition-all text-text-white hover:bg-pink-500/50 {{ $pageSlug === 'profile' ? 'bg-pink-500' : 'bg-pink-300 dark:bg-zinc-950' }}">
                            <flux:icon name="user" class="w-4 h-4 sm:w-5 sm:h-5 text-text-white" />
                            <span
                                class="text-xs  font-medium text-text-white">{{ __('View Profile') }}</span>
                        </a> --}}
                            <div class="my-2 px-2">
                                <div class="border-t border-zinc-800"></div>
                            </div>
                            <!-- Profile & Logout -->
                            <div class="space-y-1">
                                <a href="{{ route('user.profile') }}" wire:navigate @click="open = false"
                                    class="flex items-center gap-2 px-3 py-2 text-sm rounded-lg transition-all {{ $pageSlug === 'profile' ? 'bg-zinc-800 text-white' : 'text-zinc-300 hover:text-white hover:bg-zinc-800/50' }}">
                                    <flux:icon name="user" class="w-4 h-4" />
                                    <span>View Profile</span>
                                </a>

                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                        class="w-full flex items-center gap-2 px-3 py-2 text-sm text-red-400 hover:text-red-300 hover:bg-red-500/10 rounded-lg transition-all">
                                        <flux:icon name="arrow-right-start-on-rectangle" class="w-4 h-4" />
                                        <span>Logout</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <a href="{{ route('login') }}">
                    <flux:icon name="user-circle" class="w-6 h-6
                     text-text-text-white ml-2" />
                </a>
            @endauth



            {{-- Mobile menu button --}}
            <button @click="mobileMenuOpen = !mobileMenuOpen"
                class="md:hidden ml-2 inline-flex items-center justify-center p-2 rounded-md text-text-secondary hover:text-text-text-white hover:bg-bg-secondary focus:outline-none focus:ring-2 focus:ring-inset focus:ring-text-text-text-white">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>
    </div>
    {{-- Mobile sidebar --}}
    <div x-show="mobileMenuOpen" x-cloak @click.outside="mobileMenuOpen = false"
        x-transition:enter="transition ease-out duration-100"
        class="absolute top-0 right-0 w-3/4 max-w-[380px] bg-bg-primary backdrop:blure-md z-100 rounded-lg transition-all duration-300 h-auto p-4 shadow-lg overflow-y-auto ">
        <div class="flex justify-between items-center bg-bg-secondary p-2 rounded-lg mb-2">
            <h2 class="text-lg font-semibold">Category</h2>
            <button @click="mobileMenuOpen = false">
                <flux:icon name="x-mark" class="w-5 h-5 stroke-current hover:stroke-pink-600" />
            </button>
        </div>

        @include('partials.mobile-user-navigation')
    </div>
    {{-- Notification --}}
    <div x-show="notification" x-cloak @click.outside="notification = false"
        x-transition:enter="transition ease-out duration-100"
        class="absolute top-0 right-0 w-[90%] xs:w-3/4 md:max-w-[680px] bg-bg-primary backdrop:blure-md z-100   transition-all duration-300 min-h-[98vh] text-text-text-white shadow-lg overflow-y-auto">
        <div class="mb-2">
            <!-- Header -->
            <div class="flex justify-between items-center p-4 pb-0">
                <h2 class="text-lg font-semibold">Notifications</h2>
                <button @click="notification = false"
                    class="absolute top-3 right-3 text-text-secondary hover:text-gray-600">
                    <flux:icon name="x-mark" class="w-5 h-5 stroke-current hover:stroke-pink-600" />
                </button>
            </div>
            <div class="mb-3 border-b border-zinc-600">
                <button class="text-sm text-pink-500 hover:text-text-hover ps-4 pb-2">
                    Mark all as read
                </button>
            </div>

            <!-- Notification List -->
            <div class="space-y-4 h-full overflow-y-auto pr-1">
                @for ($i = 0; $i < 7; $i++)
                    <div class="flex gap-2 md:gap-4 hover:bg-bg-hover rounded-xl p-4">
                        <div>
                            {{-- Notification icon --}}
                            <div
                                class="w-8 h-8 bg-zinc-200 dark:bg-zinc-300/10 rounded-full flex items-center justify-center mb-2">
                                <flux:icon name="bell" class="w-4 h-4 stroke-zinc-500" />
                            </div>
                        </div>
                        <div class="w-full">
                            <h3 class="font-semibold text-sm">Digimon Super Rumble is HERE!</h3>
                            <p class="text-sm text-text-secondary/80 mt-1">
                                Hello dear sellers, just now we've added Digimon Super Rumble game to Accounts and
                                Currency
                                categories.
                                You can start listing your offers any minute now.
                            </p>
                        </div>
                        <div class="w-20">
                            <span class="text-xs text-pink-500">9m ago</span>
                        </div>
                    </div>
                @endfor
            </div>
        </div>
    </div>


    {{-- Dropdown --}}
    <livewire:frontend.partials.header-dropdown />

    {{-- Global Search Modal --}}
    <livewire:frontend.partials.search-modal>
</header>
