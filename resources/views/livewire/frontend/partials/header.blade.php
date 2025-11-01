<header x-data="{ mobileMenuOpen: false, notification: false, dropdown: '' }"
    class="sticky top-0 z-50  {{ request()->routeIs('home') ? 'bg-gradient-to-r from-purple-950/50 via-text-white to-purple-950/50 glass-card shadow-none!' : 'glass-card' }}">
    <div class="2xl:container-wide container  px-4 py-4 flex items-center justify-between relative"
        x-data="{ open: '' }" x-cloak>
        <div class=""><a href="{{ route('home') }}">
                <img src="{{ asset('assets/images/header_logo.png') }}" alt=""></a>
        </div>
        @include('partials.user-navigation')

        <div class="flex items-center">
            <button class="btn btn-ghost btn-circle hover:bg-purple-500/20">
                <flux:icon name="chat-bubble-oval-left" class="w-6 h-6 text-text-white" />
            </button>
            {{-- Notification --}}
            <button class="btn btn-ghost btn-circle hover:bg-purple-500/20 mr-2" @click="notification = !notification">
                <div class="indicator">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 stroke-text-primary" fill="none"
                        viewBox="0 0 24 24" stroke="white">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                    <span class="badge badge-xs badge-primary indicator-item">1</span>
                </div>
            </button>
            <div class="dropdown dropdown-end ml-2 ">
                <div tabindex="0" role="button" class="btn btn-ghost btn-circle avatar">
                    <div class="w-10 rounded-full">
                        <img alt="Tailwind CSS Navbar component"
                            src="https://img.daisyui.com/images/stock/photo-1534528741775-53994a69daeb.webp" />
                    </div>
                </div>
                <ul tabindex="-1"
                    class="menu menu-sm dropdown-content bg-purple-600 rounded-box z-1 mt-3 w-52 p-2 shadow">
                    @auth
                        @if (auth()->guard('web')->check())
                            <li><a href="{{ route('profile') }}" class="text-white" wire:navigate>Profile</a></li>
                        @else
                            <li><a href="{{ route('admin.dashboard') }}" class="text-white" wire:navigate>Dashboard</a></li>
                        @endif
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="">
                                    Logout
                                </button>
                            </form>
                        </li>
                    @else
                        <li><a href="{{ route('login') }}" class="text-white" wire:navigate>Login</a></li>
                        <li><a href="{{ route('register') }}" class="text-white" wire:navigate>Register</a></li>
                    @endauth
                    {{-- <li><a href="#" class="text-white">Settings</a></li> --}}
                </ul>
            </div>

            {{-- <flux:radio.group x-data variant="segmented" x-model="$flux.appearance">
                <flux:radio value="light" icon="sun" />
                <flux:radio value="dark" icon="moon" />
            </flux:radio.group> --}}

            <div class="flex items-center ml-2" x-data>
                <!-- Light Mode Button -->
                <button type="button" @click="$flux.dark = false" :aria-pressed="!$flux.dark"
                    class="flex items-center justify-center w-10 h-8 text-lg rounded-l-full transition-colors duration-200"
                    :class="!$flux.dark ?
                        'bg-zinc-400 text-white' :
                        'bg-transparent text-zinc-600 dark:text-zinc-300'">
                    <flux:icon name="sun" class="w-5 h-5 stroke-white" />
                </button>

                <!-- Dark Mode Button -->
                <button type="button" @click="$flux.dark = true" :aria-pressed="$flux.dark"
                    class="flex items-center justify-center w-10 h-8 text-lg rounded-r-full transition-colors duration-200"
                    :class="$flux.dark ?
                        'bg-zinc-400 text-white' :
                        'bg-transparent text-zinc-600 dark:text-zinc-300'">
                    <flux:icon name="moon" class="w-5 h-5 stroke-current" />
                </button>
            </div>



            <button @click="mobileMenuOpen = !mobileMenuOpen"
                class="md:hidden ml-2 inline-flex items-center justify-center p-2 rounded-md text-text-secondary hover:text-text-white hover:bg-bg-secondary focus:outline-none focus:ring-2 focus:ring-inset focus:ring-text-white">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="white">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>

        {{-- Dropdown --}}
        <livewire:frontend.partials.header-dropdown />

    </div>
    {{-- Mobile sidebar --}}
    <div x-show="mobileMenuOpen" x-cloak @click.outside="mobileMenuOpen = false"
        x-transition:enter="transition ease-out duration-100"
        class="absolute top-18 right-2 w-3/4 bg-bg-primary backdrop:blure-md z-100 rounded-lg transition-all duration-300 h-[calc(100vh-4.5rem)]">
        @include('partials.mobile-user-navigation')
    </div>
    {{-- Notification --}}
    <div x-show="notification" x-cloak @click.outside="notification = false"
        x-transition:enter="transition ease-out duration-100"
        class="absolute top-0 right-0 w-3/4 md:max-w-[380px] bg-bg-primary backdrop:blure-md z-100  transition-all duration-300 h-screen text-text-white shadow-lg overflow-y-auto">
        <div class="mb-2">
            <!-- Header -->
            <div class="flex justify-between items-center p-4 pb-0">
                <h2 class="text-lg font-semibold">Notifications</h2>
                <button @click="notification = false"
                    class="absolute top-3 right-3 text-text-secondary hover:text-gray-600">
                    <flux:icon name="x-mark" class="w-5 h-5 stroke-current" />
                </button>
            </div>
            <div class="mb-3 border-b border-zinc-600">
                <button class="text-sm text-pink-500 hover:text-text-hover ps-4 pb-2">
                    Mark all as read
                </button>
            </div>

            <!-- Notification List -->
            <div class="space-y-3 h-full overflow-y-auto pr-1">
                @for ($i = 0; $i < 5; $i++)
                    <div class="flex gap-2 hover:bg-bg-hover rounded-xl p-4">
                        <div>
                            {{-- Notification icon --}}
                            <div
                                class="w-8 h-8 bg-zinc-200 dark:bg-zinc-300/10 rounded-full flex items-center justify-center mb-2">
                                <flux:icon name="bell" class="w-4 h-4 stroke-purple-500" />
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
</header>
