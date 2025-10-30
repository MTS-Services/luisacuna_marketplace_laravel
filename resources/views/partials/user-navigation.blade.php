<nav class="hidden md:flex gap-8 text-sm items-center">
   {{-- Currency Dropdown --}}
    <button 
        x-on:click="open = (open == 'currency' ? '' : 'currency'); $wire.toggleDropdown('currency')"
        class="navbar_style group" :class="{'active' : open == 'currency' }">
        <span class="relative z-10">Currency</span>
        <span class="navbar_indicator" :class="{'active' : open == 'currency' }"></span>
    </button>

    {{-- Gift Cards --}}
    <button 
            x-on:click="open = (open == 'gift-cards' ? '' : 'gift-cards'); $wire.toggleDropdown('gift-cards')"
        class="navbar_style group " :class="{'active' : open == 'gift-cards' }">
        <span class="relative z-10">Gift Cards</span>
        <span class="navbar_indicator " :class="{'active' : open == 'gift-cards' }"></span>
    </button>

    {{-- Boosting Dropdown --}}
    <button 
            x-on:click="open = (open == 'boosting' ? '' : 'boosting'); $wire.toggleDropdown('boosting')"
        class="navbar_style group" :class="{'active' : open == 'boosting' }">
        <span class="relative z-10">Boosting</span>
        <span class="navbar_indicator" :class="{'active' : open == 'boosting' }"></span>
    </button>

    {{-- Items Dropdown --}}
    <button 
            x-on:click="open = (open == 'items' ? '' : 'items'); $wire.toggleDropdown('items')"
        class="navbar_style group" :class="{'active' : open == 'items' }">
        <span class="relative z-10">Items</span>
        <span class="navbar_indicator" :class="{'active' : open == 'items' }"></span>
    </button>

    {{-- Accounts Dropdown --}}
    <button 
        x-on:click="open = (open == 'accounts' ? '' : 'accounts'); $wire.toggleDropdown('accounts')"
        class="navbar_style group" :class="{'active' : open == 'accounts' }">
        <span class="relative z-10">Accounts</span>
        <span class="navbar_indicator" :class="{'active' : open == 'accounts' }"></span>
    </button>

    {{-- Top Ups --}}
    <button 
        x-on:click="open = (open == 'topups' ? '' : 'topups'); $wire.toggleDropdown('topups')"
        class="navbar_style group" :class="{'active' : open == 'topups' }">
        <span class="relative z-10">Top Ups</span>
        <span class="navbar_indicator" :class="{'active' : open == 'topups' }"></span>
    </button>

    {{-- Coaching --}}
    <button 
        x-on:click="open = (open == 'coaching' ? '' : 'coaching'); $wire.toggleDropdown('coaching')"
        class="navbar_style group" :class="{'active' : open == 'coaching' }">
        <span class="relative z-10">Coaching</span>
        <span class="navbar_indicator" :class="{'active' : open == 'coaching' }"></span>
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
