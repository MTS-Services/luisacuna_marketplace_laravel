<header>
    <div class="flex items-center justify-between container mx-auto px-4">
        <a href="{{ route('home') }}" wire:navigate>
            <h1 class="text-2xl font-bold">B33 Rentals</h1>
        </a>
        <button wire:click="logout">
            Logout
        </button>
    </div>
</header>
