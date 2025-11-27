<div x-data="{ open: false }" class="relative z-40 hover:scale-105 transition-transform duration-200">
    <!-- Trigger Button -->
    <button @click="open = !open" class="flex items-center gap-1 text-text-white hover:text-black">
        <x-phosphor-globe class="w-5 h-5" />
        <span>
            {{ strtoupper( $locale ) }} | 
            {{ session('currency', 'USD-$') }}
        </span>
        <x-phosphor-caret-down class="w-4 h-4" />
    </button>

    <!-- Dropdown Modal -->
    <div x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-100" x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95" class="absolute z-50 mt-2 right-16 w-80 origin-top-right">
        <div x-transition
             class="dark:bg-zinc-950 bg-bg-primary rounded-2xl shadow-xl w-98 p-6 relative">
            <!-- Header -->
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-base font-semibold flex gap-2 items-center text-text-white">
                    <x-phosphor-globe class="w-6 h-6" /> Choose your language & currency
                </h2>
                <button @click="open = false">
                    <x-phosphor-x class="w-5 h-5 text-gray-500 hover:text-text-white" />
                </button>
            </div>
            <x-language-switcher/>
        </div>
    </div>
</div>