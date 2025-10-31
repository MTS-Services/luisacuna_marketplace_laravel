<nav class="hidden md:flex gap-8 text-sm items-center">
    <button 
        x-on:mouseenter="open = (open == 'currency' || open == '' || open != 'currency' ? 'currency' : ''); $wire.toggleDropdown('currency')"
        class="navbar_style group " :class="{'active' : open == 'currency' || {{ request()->has('game-category') && request()->get('game-category') == 'currency' ? 'true' : 'false' }} }">
        <span class="relative z-10">Currency</span>
        <span class="navbar_indicator" :class="{'active' : open == 'currency' || {{ request()->has('game-category') && request()->get('game-category') == 'currency' ? 'true' : 'false' }} }"></span>
    </button>

    {{-- Gift Cards --}}
    <button 
        x-on:mouseenter="open = (open == 'gift-cards' || open == '' || open != 'gift-cards' ? 'gift-cards' : ''); $wire.toggleDropdown('gift-cards')"
        class="navbar_style group " :class="{'active' : open == 'gift-cards' || {{request()->has('game-category' ) && request()->get('game-category') == 'gift-cards' ? 'true' : 'false' }} }">
        <span class="relative z-10">Gift Cards</span>
        <span class="navbar_indicator " :class="{'active' : open == 'gift-cards' || {{request()->has('game-category' ) && request()->get('game-category') == 'gift-cards' ? 'true' : 'false' }} }"></span>
    </button>

    {{-- Boosting Dropdown --}}
    <button 
        x-on:mouseenter="open = (open == 'boosting' || open == '' || open != 'boosting' ? 'boosting' : ''); $wire.toggleDropdown('boosting')"
        class="navbar_style group" :class="{'active' : open == 'boosting' || {{request()->has('game-category' ) && request()->get('game-category') == 'boosting' ? 'true' : 'false' }} }">
        <span class="relative z-10">Boosting</span>
        <span class="navbar_indicator" :class="{'active' : open == 'boosting' || {{request()->has('game-category' ) && request()->get('game-category') == 'boosting' ? 'true' : 'false' }} }"></span>
    </button>

    {{-- Items Dropdown --}}
    <button 
        x-on:mouseenter="open = (open == 'items' || open == '' || open != 'items' ? 'items' : ''); $wire.toggleDropdown('items')"
        class="navbar_style group" :class="{'active' : open == 'items' || {{request()->has('game-category' ) && request()->get('game-category') == 'items' ? 'true' : 'false' }} }">
        <span class="relative z-10">Items</span>
        <span class="navbar_indicator" :class="{'active' : open == 'items' || {{request()->has('game-category' ) && request()->get('game-category') == 'items' ? 'true' : 'false' }} }"></span>
    </button>

    {{-- Accounts Dropdown --}}
    <button 
        x-on:mouseenter="open = (open == 'accounts' || open == '' || open != 'accounts' ? 'accounts' : ''); $wire.toggleDropdown('accounts')"
        class="navbar_style group" :class="{'active' : open == 'accounts' || {{request()->has('game-category' ) && request()->get('game-category') == 'accounts' ? 'true' : 'false' }} }">
        <span class="relative z-10">Accounts</span>
        <span class="navbar_indicator" :class="{'active' : open == 'accounts' || {{request()->has('game-category' ) && request()->get('game-category') == 'accounts' ? 'true' : 'false' }} }"></span>
    </button>

    {{-- Top Ups --}}
    <button 
        x-on:mouseenter="open = (open == 'topups' || open == '' || open != 'topups' ? 'topups' : ''); $wire.toggleDropdown('topups')"
        class="navbar_style group" :class="{'active' : open == 'topups' || {{request()->has('game-category' ) && request()->get('game-category') == 'topups' ? 'true' : 'false' }} }">
        <span class="relative z-10">Top Ups</span>
        <span class="navbar_indicator" :class="{'active' : open == 'topups' || {{request()->has('game-category' ) && request()->get('game-category') == 'topups' ? 'true' : 'false' }} }"></span>
    </button>

    {{-- Coaching --}}
    <button 
        x-on:mouseenter="open = (open == 'coaching' || open == '' || open != 'coaching' ? 'coaching' : ''); $wire.toggleDropdown('coaching')"
        class="navbar_style group" :class="{'active' : open == 'coaching' || {{request()->has('game-category' ) && request()->get('game-category') == 'coaching' ? 'true' : 'false' }} }">
        <span class="relative z-10">Coaching</span>
        <span class="navbar_indicator" :class="{'active' : open == 'coaching' || {{request()->has('game-category' ) && request()->get('game-category') == 'coaching' ? 'true' : 'false' }} }"></span>
    </button>
    <div class="relative hidden xl:block">
        <flux:icon
            name="magnifying-glass"
            class="w-4 h-4 absolute left-3 top-1/2 transform -translate-y-1/2 stroke-text-primary"
        />

        <input type="text" placeholder="Search"
            class="border dark:border-white border-gray-600 rounded-full py-1.5 pl-8 pr-2 text-sm focus:outline-none focus:border-purple-500 focus:bg-bg-primary transition-all w-22 focus:w-64 bg-transparent placeholder:text-text-primary">
    </div>
</nav>
