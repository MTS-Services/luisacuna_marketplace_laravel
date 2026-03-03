<section x-show="globalSearchModal != false" x-clock class="absolute top-4 left-0 right-0 w-3xl mx-auto z-50 mt-0">
    <div class="container mx-auto relative">

        {{-- Loading Spinner (Kept from original) --}}
        <div wire:loading.flex wire:target="search"
            class="absolute inset-0 bg-bg-primary/70 backdrop-blur-sm flex flex-col items-center justify-center rounded-lg z-50 mx-4 lg:px-10">
            <div class="relative flex items-center justify-center w-12 h-12">
                <div class="absolute w-12 h-12 border-4 border-purple-500/30 rounded-full"></div>
                <div
                    class="absolute w-12 h-12 border-4 border-purple-500 border-t-transparent rounded-full animate-spin">
                </div>
            </div>
            <p class="text-sm text-purple-300 mt-3 font-medium tracking-wide">{{ __('Loading content...') }}</p>
        </div>

        {{-- Centered modal structure like the image, using dark theme colors --}}
        <div class="bg-bg-primary flex flex-col rounded-lg shadow-2xl py-4 px-4  h-[70vh]"
            x-on:click.outside="globalSearchModal= false">

            {{-- Search Bar Section (Large, centered input) --}}
            <div class="p-4">
                <div class="relative">
                    <input type="text" wire:model="search" placeholder="search"
                        class="w-full text-text-white bg-bg-primary text-sm border items-center flex rounded-full border-purple-500/50 focus:outline-none focus:border-purple-500 px-4 py-1 pl-4 pr-10 placeholder:text-gray-500 dark:placeholder:text-gray-400" />
                    <button
                        class="absolute right-3 top-1/2 -translate-y-1/2 dark:text-gray-400 text-gray-500 hover:text-purple-500 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </button>
                </div>
            </div>

            {{-- Popular Games --}}
            <div class="px-4 py-3 flex-1 overflow-y-auto">
                <h3 class="text-xs font-semibold text-text-white/70 uppercase tracking-wider mb-2 pt-1 px-2.5">
                    {{ __('POPULAR GAMES') }}
                </h3>
                <div class="space-y-1 pb-4">
                    @forelse ($popular_games as $item)
                        <a href="{{ route('game.index', ['gameSlug' => $item->slug, 'categorySlug' => $item->categories->first()?->slug ?? 'currency']) }}"
                            wire:navigate
                            class="flex items-center gap-3 p-2 hover:bg-purple-500/10 rounded-lg transition cursor-pointer">
                            <div class="w-6 h-6 flex items-center justify-center">
                                <img src="{{ storage_url($item->logo) }}" alt="{{ $item->name }}"
                                    class="w-full h-full object-contain">
                            </div>
                            <p class="text-base lg:text-lg font-normal text-text-white">
                                {{ $item->translatedName(app()->getLocale()) }}
                            </p>
                        </a>
                    @empty
                        <div class="text-center py-4">
                            <p class="text-text-white/50 text-sm">{{ __('No popular games yet.') }}</p>
                        </div>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
</section>
