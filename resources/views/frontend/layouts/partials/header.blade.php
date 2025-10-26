<header x-data="{ mobileMenuOpen: false }"
    class="sticky top-0 z-50 {{ request()->routeIs('home') ? 'bg-gradient-to-r from-purple-950 via-black to-purple-950' : 'glass-card' }}">
    <div class="container px-4 py-4 flex items-center justify-between">
        <div class="text-2xl font-bold gradient-text text-white"><a href="{{ route('home') }}">
                <img src="{{ asset('assets/images/header_logo.png') }}" alt=""></a>
        </div>

        <nav class="hidden md:flex gap-8 text-sm items-center">
            {{-- <a href="#" class="hover:text-purple-400 transition text-white">Currency</a> --}}
            <a href="#" class="navbar_style group active">
                <span class="relative z-10">Currency</span>
                <span class="navbar_indicator active"></span>
            </a>
            <a href="#" class="navbar_style group">
                <span class="relative z-10">Gift Cards</span>
                <span class="navbar_indicator"></span>
            </a>
            <a href="#" class="navbar_style group">
                <span class="relative z-10">Boosting</span>
                <span class="navbar_indicator"></span>
            </a>
            <a href="#" class="navbar_style group">
                <span class="relative z-10">Items</span>
                <span class="navbar_indicator"></span>
            </a>
            <a href="#" class="navbar_style group">
                <span class="relative z-10">Accounts</span>
                <span class="navbar_indicator"></span>
            </a>
            <a href="#" class="navbar_style group">
                <span class="relative z-10">Top Ups</span>
                <span class="navbar_indicator"></span>
            </a>
            <a href="#" class="navbar_style group">
                <span class="relative z-10">Coaching</span>
                <span class="navbar_indicator"></span>
            </a>
            {{-- Search --}}
            <button
                class="flex items-center gap-2 px-4 py-2 border border-white rounded-full text-white bg-transparent hover:bg-white/10 transition max-w-fit">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="white" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                </svg>
                <input type="text" placeholder="Search" class="outline-none focus:ring-0">
            </button>
        </nav>

        <div class="">
            <button class="btn btn-ghost btn-circle hover:bg-purple-500/20">
                <svg class="w-6 h-6" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M32 6C17.64 6 6 17.1 6 30.48C6 38.01 9.69 44.59 15.48 48.84V58L25.23 52.66C27.38 53.26 29.65 53.56 32 53.56C46.36 53.56 58 42.46 58 29.08C58 15.7 46.36 6 32 6ZM33.18 36.44L26.92 30.72L13.32 36.44L26.08 22.68L32.32 28.4L45.92 22.68L33.18 36.44Z"
                        fill="white" />
                </svg>
            </button>
            <button class="btn btn-ghost btn-circle hover:bg-purple-500/20">
                <div class="indicator">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="white">
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
                            <li><a href="{{ route('user.profile') }}" class="text-white" wire:navigate>Profile</a></li>
                        @else
                            <li><a href="{{ route('admin.dashboard') }}" class="text-white" wire:navigate>Dashboard</a></li>
                        @endif
                    @else
                        <li><a href="{{ route('login') }}" class="text-white" wire:navigate>Login</a></li>
                        <li><a href="{{ route('register') }}" class="text-white" wire:navigate>Register</a></li>
                    @endauth
                    {{-- <li><a href="#" class="text-white">Settings</a></li> --}}
                </ul>
            </div>
        </div>

        <button @click="mobileMenuOpen = !mobileMenuOpen" class="md:hidden">☰</button>
    </div>
</header>

{{-- <div class="navbar bg-base-100 shadow-sm">
    <div class="flex-1">
        <a class="btn btn-ghost text-xl">daisyUI</a>
    </div>
    <div class="flex gap-2">
        <input type="text" placeholder="Search" class="input input-bordered w-24 md:w-auto" />
        <div class="dropdown dropdown-end">
            <div tabindex="0" role="button" class="btn btn-ghost btn-circle avatar">
                <div class="w-10 rounded-full">
                    <img alt="Tailwind CSS Navbar component"
                        src="https://img.daisyui.com/images/stock/photo-1534528741775-53994a69daeb.webp" />
                </div>
            </div>
            <ul tabindex="-1" class="menu menu-sm dropdown-content bg-base-100 rounded-box z-1 mt-3 w-52 p-2 shadow">
                <li>
                    <a class="justify-between">
                        Profile
                        <span class="badge">New</span>
                    </a>
                </li>
                <li><a>Settings</a></li>
                <li><a>Logout</a></li>
            </ul>
        </div>
    </div>
</div> --}}
