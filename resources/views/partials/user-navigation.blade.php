<nav class="hidden md:flex gap-8 text-sm items-center">
    {{-- <a href="#" class="hover:text-purple-400 transition text-white">Currency</a> --}}
    <a wire:navigate href="{{ route('currency') }}" class="navbar_style group active">
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
    {{-- <button
        class="flex items-center gap-2 px-4 py-2 border border-white rounded-full text-white bg-transparent hover:bg-white/10 transition max-w-fit">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="white"
            class="w-5 h-5">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
        </svg>
        <input type="text" placeholder="Search" class="outline-none focus:ring-0">
    </button> --}}
    <!-- Desktop Search -->
    <div class="relative hidden xl:block">
        <flux:icon name="magnifying-glass" class="w-4 h-4 absolute left-3 top-1/2 transform -translate-y-1/2 text-white"
            stroke="white" />
        <input type="text" placeholder="Search"
            class="border dark:border-white border-gray-600 rounded-full py-1.5 pl-8 pr-2 text-sm text-text-white placeholder-text-text-white focus:outline-none focus:border-purple-500 focus:bg-gray-800 transition-all w-22 focus:w-64 bg-transparent">
    </div>
</nav>
