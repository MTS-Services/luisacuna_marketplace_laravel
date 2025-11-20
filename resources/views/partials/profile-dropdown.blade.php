{{-- Profile Dropdown Component - components/profile-dropdown.blade.php --}}
<div x-data="{ open: false }" class="relative">
    <button @click="open = !open"
        class="flex items-center rounded-lg text-text-white transition-all focus:outline-none mr-3 ml-1.5">
        <div class="w-7 h-7 lg:w-9 lg:h-9 rounded-full shadow-lg overflow-hidden">
            <img src="{{ storage_url(auth()->user()->avatar) }}" class="w-full h-full object-cover"
                alt="{{ auth()->user()->full_name ?? 'User Avatar' }}">
        </div>
    </button>

    <!-- Dropdown Menu -->
    <div x-show="open" x-cloak @click.away="open = false" x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 transform scale-95" x-transition:enter-end="opacity-100 transform scale-100"
        x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 transform scale-100"
        x-transition:leave-end="opacity-0 transform scale-95"
        class="absolute right-0 mt-2 w-56 sm:w-64 xl:w-90 2xl:w-96 bg-bg-primary rounded-xl shadow-2xl overflow-hidden z-50">

        <!-- User Info Header -->
        <div class="px-2 py-5 flex items-center justify-between shadow-lg bg-bg-secondary">
            <div class="flex items-center gap-2">
                <div class="w-10 h-10 lg:w-14 lg:h-14 rounded-full shadow-lg overflow-hidden">
                    <img src="{{ storage_url(auth()->user()->avatar) }}" class="w-full h-full object-cover"
                        alt="{{ auth()->user()->full_name ?? 'User Avatar' }}">
                </div>
                <div class="flex flex-col gap-1.5">
                    <p class="text-base font-semibold text-text-white truncate">
                        {{ auth()->user()->full_name }}
                    </p>
                    <p class="text-xs text-zinc-400 truncate">{{ auth()->user()->email }}</p>
                </div>
            </div>
            <div>
                <x-ui.button href="{{ route('user.seller.verification') }}" wire:navigate
                    class="m-auto! py-1! lg:py-2!">
                    {{ __('Sell') }}
                </x-ui.button>
            </div>
        </div>

        <div class="flex-1 px-3 py-4 space-y-2 max-h-[calc(100vh-200px)] overflow-y-auto">
            <!-- Orders Dropdown -->
            <div x-data="{
                ordersOpen: {{ in_array($pageSlug, ['purchased_orders', 'sold_orders']) ? 'true' : 'false' }},
                isActive: {{ in_array($pageSlug, ['purchased_orders', 'sold_orders']) ? 'true' : 'false' }}
            }">
                <button x-cloak @click="ordersOpen = !ordersOpen"
                    :class="isActive ? 'bg-pink-300 dark:bg-zinc-950 relative' : 'bg-pink-400 dark:bg-zinc-950'"
                    class="w-full flex items-center justify-between px-2 sm:px-3 py-2.5 sm:py-3 rounded-lg transition-all text-text-white hover:bg-pink-500/50">
                    <div class="flex items-center space-x-2 sm:space-x-3">
                        <flux:icon name="shopping-cart" class="w-5 h-5 sm:w-6 sm:h-6 text-text-white" />
                        <span class="text-xs font-medium text-text-white">{{ __('Orders') }}</span>
                        <div x-show="isActive" x-cloak
                            class="absolute left-0 top-0 w-1.5 sm:w-2 h-full bg-gradient-to-b from-pink-500 to-zinc-600 rounded-l-full z-50">
                        </div>
                    </div>
                    <flux:icon name="chevron-down" x-show="!ordersOpen" x-cloak
                        class="w-3.5 h-3.5 sm:w-4 sm:h-4 transition-transform text-text-white" />
                    <flux:icon name="chevron-up" x-show="ordersOpen" x-cloak
                        class="w-3.5 h-3.5 sm:w-4 sm:h-4 transition-transform text-text-white" />
                </button>

                <div x-show="ordersOpen" x-collapse x-cloak class="mt-1 ml-6 sm:ml-8 space-y-1">
                    <a href="{{ route('user.purchased-orders') }}" wire:navigate @click="$root.sidebarOpen = false"
                        class="block px-2 sm:px-3 py-2 text-xs rounded-lg transition-all text-text-white hover:bg-pink-500/50 {{ $pageSlug === 'purchased_orders' ? 'bg-pink-500' : 'bg-pink-300 dark:bg-zinc-950' }}">
                        {{ __('Purchased orders') }}
                    </a>
                    <a href="{{ route('user.sold-orders') }}" wire:navigate @click="$root.sidebarOpen = false"
                        class="block px-2 sm:px-3 py-2 text-xs rounded-lg transition-all text-text-white hover:bg-pink-500/50 {{ $pageSlug === 'sold_orders' ? 'bg-pink-500' : 'bg-pink-300 dark:bg-zinc-950' }}">
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
                    :class="isActive ? 'bg-pink-300 dark:bg-zinc-950 relative' : 'bg-pink-400 dark:bg-zinc-950'"
                    class="w-full flex items-center justify-between px-2 sm:px-3 py-2.5 sm:py-3 rounded-lg transition-all text-text-white hover:bg-pink-500/50">
                    <div class="flex items-center space-x-2 sm:space-x-3">
                        <x-phosphor-tag class="w-5 h-5 rotate-90 fill-text-text-white" />
                        <span class="text-xs font-medium text-text-white">Offers</span>
                        <div x-show="isActive" x-cloak
                            class="absolute left-0 top-0 w-1.5 sm:w-2 h-full bg-gradient-to-b from-pink-500 to-zinc-600 rounded-l-full z-50">
                        </div>
                    </div>
                    <flux:icon name="chevron-down" x-show="!ordersOpen" x-cloak
                        class="w-3.5 h-3.5 sm:w-4 sm:h-4 transition-transform text-text-white" />
                    <flux:icon name="chevron-up" x-show="ordersOpen" x-cloak
                        class="w-3.5 h-3.5 sm:w-4 sm:h-4 transition-transform text-text-white" />
                </button>

                <div x-show="ordersOpen" x-collapse x-cloak class="mt-1 ml-6 sm:ml-8 space-y-1">
                    <a href="{{ route('user.currency') }}" wire:navigate @click="$root.sidebarOpen = false"
                        class="block px-2 sm:px-3 py-2 text-xs rounded-lg transition-all text-text-white hover:bg-pink-500/50 {{ $pageSlug === 'currency' ? 'bg-pink-500' : 'bg-pink-300 dark:bg-zinc-950' }}">
                        {{ __('Currency') }}
                    </a>
                    <a href="{{ route('user.accounts') }}" wire:navigate @click="$root.sidebarOpen = false"
                        class="block px-2 sm:px-3 py-2 text-xs rounded-lg transition-all text-text-white hover:bg-pink-500/50 {{ $pageSlug === 'accounts' ? 'bg-pink-500' : 'bg-pink-300 dark:bg-zinc-950' }}">
                        {{ __('Accounts') }}
                    </a>
                    <a href="{{ route('user.top-ups') }}" wire:navigate @click="$root.sidebarOpen = false"
                        class="block px-2 sm:px-3 py-2 text-xs rounded-lg transition-all text-text-white hover:bg-pink-500/50 {{ $pageSlug === 'top-ups' ? 'bg-pink-500' : 'bg-pink-300 dark:bg-zinc-950' }}">
                        {{ __('Top Ups') }}
                    </a>
                    <a href="{{ route('user.items') }}" wire:navigate @click="$root.sidebarOpen = false"
                        class="block px-2 sm:px-3 py-2 text-xs rounded-lg transition-all text-text-white hover:bg-pink-500/50 {{ $pageSlug === 'items' ? 'bg-pink-500' : 'bg-pink-300 dark:bg-zinc-950' }}">
                        {{ __('Items') }}
                    </a>
                    <a href="{{ route('user.gift-cards') }}" wire:navigate @click="$root.sidebarOpen = false"
                        class="block px-2 sm:px-3 py-2 text-xs rounded-lg transition-all text-text-white hover:bg-pink-500/50 {{ $pageSlug === 'gift-cards' ? 'bg-pink-500' : 'bg-pink-300 dark:bg-zinc-950' }}">
                        {{ __('Gift Cards') }}
                    </a>
                </div>
            </div>

            <!-- Boosting Dropdown -->
            <div x-data="{
                boostingOpen: {{ in_array($pageSlug, ['my-requests', 'received-requests']) ? 'true' : 'false' }},
                isActive: {{ in_array($pageSlug, ['my-requests', 'received-requests']) ? 'true' : 'false' }}
            }">
                <button x-cloak @click="boostingOpen = !boostingOpen"
                    :class="isActive ? 'bg-pink-300 dark:bg-zinc-950 relative' : 'bg-pink-400 dark:bg-zinc-950'"
                    class="w-full flex items-center justify-between px-2 sm:px-3 py-2.5 sm:py-3 rounded-lg transition-all text-text-white hover:bg-pink-500/50">
                    <div class="flex items-center space-x-2 sm:space-x-3">
                        <x-phosphor name="circles-four" variant="solid"
                            class="w-5 h-5 rotate-90 fill-text-text-white" />
                        <span class="text-xs font-medium text-text-white">Boosting</span>
                        <div x-show="isActive" x-cloak
                            class="absolute left-0 top-0 w-1.5 sm:w-2 h-full bg-gradient-to-b from-pink-500 to-zinc-600 rounded-l-full z-50">
                        </div>
                    </div>
                    <flux:icon name="chevron-down" x-show="!boostingOpen" x-cloak
                        class="w-3.5 h-3.5 sm:w-4 sm:h-4 transition-transform text-text-white" />
                    <flux:icon name="chevron-up" x-show="boostingOpen" x-cloak
                        class="w-3.5 h-3.5 sm:w-4 sm:h-4 transition-transform text-text-white" />
                </button>

                <div x-show="boostingOpen" x-collapse x-cloak class="mt-1 ml-6 sm:ml-8 space-y-1">
                    <a href="{{ route('user.my-requests') }}" wire:navigate @click="$root.sidebarOpen = false"
                        class="block px-2 sm:px-3 py-2 text-xs rounded-lg transition-all text-text-white hover:bg-pink-500/50 {{ $pageSlug === 'my-requests' ? 'bg-pink-500' : 'bg-pink-300 dark:bg-zinc-950' }}">
                        {{ __('My Requests') }}
                    </a>
                    <a href="{{ route('user.received-requests') }}" wire:navigate @click="$root.sidebarOpen = false"
                        class="block px-2 sm:px-3 py-2 text-xs rounded-lg transition-all text-text-white hover:bg-pink-500/50 {{ $pageSlug === 'received-requests' ? 'bg-pink-500' : 'bg-pink-300 dark:bg-zinc-950' }}">
                        {{ __('Received Requests') }}
                    </a>
                </div>
            </div>

            <!-- Loyalty Link -->
            <a href="{{ route('user.loyalty') }}" wire:navigate @click="$root.sidebarOpen = false"
                class="flex items-center space-x-2 sm:space-x-3 px-2 sm:px-3 py-2 rounded-lg transition-all text-text-white hover:bg-pink-500/50 {{ $pageSlug === 'loyalty' ? 'bg-pink-500' : 'bg-pink-300 dark:bg-zinc-950' }}">
                <flux:icon name="trophy" class="w-4 h-4 sm:w-5 sm:h-5 text-text-white" />
                <span class="text-xs font-medium text-text-white">{{ __('Loyalty') }}</span>
            </a>

            <!-- Wallet Link -->
            <a href="{{ route('user.wallet') }}" wire:navigate @click="$root.sidebarOpen = false"
                class="flex items-center space-x-2 sm:space-x-3 px-2 sm:px-3 py-2 rounded-lg transition-all text-text-white hover:bg-pink-500/50 {{ $pageSlug === 'wallet' ? 'bg-pink-500' : 'bg-pink-300 dark:bg-zinc-950' }}">
                <x-phosphor name="cardholder" variant="regular" class="w-4 h-4 sm:w-5 sm:h-5 text-text-white" />
                <span class="text-xs font-medium text-text-white">{{ __('Wallet') }}</span>
            </a>

            <!-- Messages Link -->
            <a href="{{ route('user.messages') }}" wire:navigate @click="$root.sidebarOpen = false"
                class="flex items-center space-x-2 sm:space-x-3 px-2 sm:px-3 py-2 rounded-lg transition-all text-text-white hover:bg-pink-500/50 {{ $pageSlug === 'messages' ? 'bg-pink-500' : 'bg-pink-300 dark:bg-zinc-950' }}">
                <flux:icon name="chat-bubble-bottom-center-text" class="w-4 h-4 sm:w-5 sm:h-5 text-text-white" />
                <span class="text-xs font-medium text-text-white">{{ __('Messages') }}</span>
            </a>

            <!-- Feedback Link -->
            <a href="{{ route('user.feedback') }}" wire:navigate @click="$root.sidebarOpen = false"
                class="flex items-center space-x-2 sm:space-x-3 px-2 sm:px-3 py-2 rounded-lg transition-all text-text-white hover:bg-pink-500/50 {{ $pageSlug === 'feedback' ? 'bg-pink-500' : 'bg-pink-300 dark:bg-zinc-950' }}">
                <flux:icon name="star" class="w-4 h-4 sm:w-5 sm:h-5 text-text-white" />
                <span class="text-xs font-medium text-text-white">{{ __('Feedback') }}</span>
            </a>

            <!-- Settings Link -->
            <a href="{{ route('user.account-settings') }}" wire:navigate @click="$root.sidebarOpen = false"
                class="flex items-center space-x-2 sm:space-x-3 px-2 sm:px-3 py-2 rounded-lg transition-all text-text-white hover:bg-pink-500/50 {{ $pageSlug === 'account-settings' ? 'bg-pink-500' : 'bg-pink-300 dark:bg-zinc-950' }}">
                <x-phosphor name="gear" class="w-4 h-4 sm:w-5 sm:h-5 fill-text-text-white" />
                <span class="text-xs font-medium text-text-white">{{ __('Account Settings') }}</span>
            </a>

            <div class="my-2 px-2">
                <div class="border-t border-zinc-800"></div>
            </div>


            <div class="space-y-1">
                {{-- Language Selector --}}
                {{-- Language Selector with Centered Popup --}}
                <div x-data="{ open: false }">
                    <!-- Trigger Button -->
                    <button @click="open = !open"
                        class="text-xs font-medium flex items-center space-x-2 sm:space-x-3 px-2 sm:px-3 py-2 rounded-lg transition-all text-text-white hover:bg-pink-500/50 bg-pink-300 dark:bg-zinc-950 w-full">
                        <x-phosphor-globe class="w-5 h-5" />
                        <span class="flex items-center justify-between gap-1 text-text-white w-full">
                            {{ strtoupper(session('locale', 'en')) == 'EN' ? 'En' : 'Fr' }} |
                            {{ session('currency', 'USD-$') }}
                            <x-phosphor-caret-right class="w-4 h-4" />
                        </span>
                    </button>

                    <!-- Centered Popup Modal - Rendered at body level using Portal -->
                    <template x-teleport="body">
                        <div x-show="open" x-cloak @click.self="open = false" @keydown.escape.window="open = false"
                            x-transition.opacity.duration.200ms
                            style="position: fixed; top: 0; left: 0; right: 0; bottom: 0; z-index: 9999;"
                            class="flex items-center justify-center bg-black/50 backdrop-blur-sm">

                            <!-- Popup Content -->
                            <div x-show="open" @click.away="open = false"
                                x-transition:enter="transition ease-out duration-300"
                                x-transition:enter-start="opacity-0 transform scale-95 translate-y-4"
                                x-transition:enter-end="opacity-100 transform scale-100 translate-y-0"
                                x-transition:leave="transition ease-in duration-200"
                                x-transition:leave-start="opacity-100 transform scale-100 translate-y-0"
                                x-transition:leave-end="opacity-0 transform scale-95 translate-y-4"
                                class="relative w-11/12 max-w-md rounded-lg shadow-2xl p-4 dark:bg-zinc-950 bg-bg-primary m-4">

                                <div class="flex justify-between items-center mb-4">
                                    <h2 class="text-sm font-semibold flex gap-2 items-center text-text-white">
                                        <x-phosphor-globe class="w-6 h-6" /> Choose your language & currency
                                    </h2>
                                    <button @click="open = false"
                                        class="hover:bg-zinc-800/50 rounded-lg p-1 transition-all">
                                        <x-phosphor-x class="w-5 h-5 text-gray-500 hover:text-text-white" />
                                    </button>
                                </div>

                                <x-language-switcher />
                            </div>
                        </div>
                    </template>
                </div>





                {{-- Theme Switcher --}}

                <div x-model="$flux.appearance" x-data
                    class="text-xs font-medium flex items-center space-x-2 sm:space-x-3 px-2 sm:px-3 py-2 rounded-lg transition-all text-text-white hover:bg-pink-500/50 bg-pink-300 dark:bg-zinc-950 w-full justify-between">

                    <span class="flex items-center gap-2 text-text-white">

                        <flux:icon name="moon" class="w-5 h-5 stroke-current" />
                        Dark theme
                    </span>

                    <!-- Perfect Switch -->
                    <button x-on:click="$flux.dark = !$flux.dark"
                        class="relative w-12 h-6 rounded-full transition-all duration-300 flex items-center border border-zinc-600 bg-transparent dark:bg-white">
                        <span
                            class="translate-x-1 dark:translate-x-7 absolute w-4 h-4 bg-zinc-500 rounded-full transition-all duration-300">
                        </span>
                    </button>
                </div>

                <!-- Profile & Logout -->


                <a href="{{ route('profile', auth()->user()->username) }}" wire:navigate @click="open = false"
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
