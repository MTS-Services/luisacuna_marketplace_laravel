@props(['currencies' => []])
<div x-data="{ open: false }" class="relative z-40 transition-transform duration-200">
    <button @click="open = !open" class="flex items-center gap-1 text-text-white hover:text-black">
        <x-phosphor-globe class="w-5 h-5" />
        <span class="text-xs xxs:text-base">
            {{ strtoupper($locale) }} |
            {{ session('currency', 'USD') }}-{{ session('currency_symbol', '$') }}
        </span>
        <x-phosphor-caret-down class="w-4 h-4" />
    </button>

    <div x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-100" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="absolute z-50 mt-2 right-[-120%] md:right-16 w-80 md:origin-top-right">

        <div class="dark:bg-zinc-950 bg-bg-primary rounded-2xl shadow-xl w-auto! md:w-98 p-6 relative">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-base font-semibold flex gap-2 items-center text-text-white">
                    <x-phosphor-globe class="w-6 h-6" /> {{ __('Choose your language & currency') }}
                </h2>
                <button @click="open = false">
                    <x-phosphor-x class="w-5 h-5 text-gray-500 hover:text-text-white" />
                </button>
            </div>

            <x-language-switcher :currencies="$currencies" />
        </div>
    </div>
</div>
