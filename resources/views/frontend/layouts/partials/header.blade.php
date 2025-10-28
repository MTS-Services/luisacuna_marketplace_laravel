<header x-data="{ mobileMenuOpen: false }"
    class="sticky top-0 z-50 {{ request()->routeIs('home') ? 'bg-gradient-to-r from-purple-950/50 via-text-white to-purple-950/50' : 'glass-card' }}">
    <div class="container px-4 py-4 flex items-center justify-between">
        <div class=""><a href="{{ route('home') }}">
                <img src="{{ asset('assets/images/header_logo.png') }}" alt=""></a>
        </div>

        @include('partials.user-navigation')

        <div class="flex items-center">
            <button class="btn btn-ghost btn-circle hover:bg-purple-500/20">
                <svg class="w-6 h-6 stroke-black" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M32 6C17.64 6 6 17.1 6 30.48C6 38.01 9.69 44.59 15.48 48.84V58L25.23 52.66C27.38 53.26 29.65 53.56 32 53.56C46.36 53.56 58 42.46 58 29.08C58 15.7 46.36 6 32 6ZM33.18 36.44L26.92 30.72L13.32 36.44L26.08 22.68L32.32 28.4L45.92 22.68L33.18 36.44Z"
                        fill="white" />
                </svg>
            </button>
            <button class="btn btn-ghost btn-circle hover:bg-purple-500/20 mr-2">
                <div class="indicator">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="white">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                    <span class="badge badge-xs badge-primary indicator-item">1</span>
                </div>
            </button>
            <flux:radio.group x-data variant="segmented" x-model="$flux.appearance">
                <flux:radio value="light" icon="sun" />
                <flux:radio value="dark" icon="moon" />
            </flux:radio.group>
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
                            <li><a href="{{ route('user.profile') }}" class="text-white" wire:navigate>Profile</a></li>
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
            <button @click="mobileMenuOpen = !mobileMenuOpen"
                class="md:hidden ml-2 inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="white">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>

    </div>
    {{-- Mobile sidebar --}}
    {{-- <div x-show="mobileMenuOpen" x-cloak @click.outside="mobileMenuOpen = false" x-transition:enter="transition ease-out duration-100" class="absolute top-0 inset-x-0 p-2 transition transform origin-top-right md:hidden glass w-sm">
        <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
            <a href="#" class="text-gray-300 hover:bg-gray-700 hover:text-white block px-3 py-2 rounded-md text-base font-medium">Dashboard</a>
            <a href="#" class="text-gray-300 hover:bg-gray-700 hover:text-white block px-3 py-2 rounded-md text-base font-medium">Team</a>
            <a href="#" class="text-gray-300 hover:bg-gray-700 hover:text-white block px-3 py-2 rounded-md text-base font-medium">Projects</a>
            <a href="#" class="text-gray-300 hover:bg-gray-700 hover:text-white block px-3 py-2 rounded-md text-base font-medium">Calendar</a>
        </div>
    </div> --}}
</header>
