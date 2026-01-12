@props([
    'target' => null,
    'style' => 'grid',
])

<div wire:loading wire:target="{{ $target }}" class="absolute inset-0 z-20">
    <div x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
        class="grid grid-cols-2 lg:grid-cols-3 2xl:grid-cols-4 gap-4 lg:gap-6 w-full h-full bg-bg-primary/40 backdrop-blur-[2px]">

        @for ($i = 0; $i < 8; $i++)
            <div
                class="bg-bg-primary dark:bg-bg-secondary rounded-2xl p-4 border border-zinc-800 space-y-4 animate-pulse">

                {{-- Top Section: Logo & Tag --}}
                <div class="flex items-center justify-between">
                    <div class="w-6 h-6 rounded bg-zinc-700"></div>
                    <div class="h-5 w-16 rounded-2xl bg-zinc-700"></div>
                </div>

                {{-- Middle Section: Units/Quantity --}}
                <div class="mt-4">
                    <div class="h-5 w-20 rounded bg-zinc-700"></div>
                </div>

                {{-- Title/Name Section --}}
                <div class="space-y-2">
                    <div class="h-3 w-full rounded bg-zinc-700/60"></div>
                    <div class="h-3 w-2/3 rounded bg-zinc-700/60"></div>
                </div>

                {{-- Bottom Section: Price --}}
                <div class="pt-2">
                    <div class="h-6 w-24 rounded bg-pink-500/20"></div>
                </div>
            </div>
        @endfor

    </div>
</div>
