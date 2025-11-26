<section class="absolute container top-full left-0 right-0 z-50 mt-0" x-data x-show="open != ''" x-transition x-cloak
    x-effect="$wire.setGameCategorySlug(open)" @mouseleave="open = ''">
    <div class="relative" x-on:click.outside="open = ''">
        {{-- 🌟 Dropdown Content --}}
        <div
            class="dark:bg-zinc-800 bg-white flex flex-col lg:flex-row items-start justify-between rounded-lg shadow-lg px-4 lg:px-10 max-h-[500px]">

            {{-- Popular Games Section --}}
            <div class="w-full lg:w-2/3 pt-6 order-2 lg:order-1 overflow-y-auto pr-4">
                <h3
                    class="dark:text-white text-gray-900 text-base font-semibold pt-2 mb-6 sticky top-0 dark:bg-zinc-800 bg-white pb-2">
                    Popular {{ ucfirst($gameCategorySlug) }}
                </h3>
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-2.5 pb-6">
                    @forelse($this->content['popular'] ?? [] as $item)
                        <a href="{{ route('game.index', ['gameSlug' => $item['slug'], 'categorySlug' => $gameCategorySlug]) }}"
                            wire:navigate>
                            <div
                                class="flex items-center gap-2.5 p-2 dark:hover:bg-purple-500/10 hover:bg-purple-100 rounded-lg transition cursor-pointer">
                                <div class="w-6 h-6 flex-shrink-0 ">
                                    <img src="{{ asset($item['logo']) }}" alt="{{ $item['name'] }}"
                                        class="w-full h-full object-contain rounded-lg">
                                </div>
                                <p class="text-base font-normal dark:text-white text-gray-900">{{ $item['name'] }}</p>
                            </div>
                        </a>
                    @empty
                        <div class="col-span-2 text-center py-8">
                            <p class="dark:text-gray-400 text-gray-600">No popular games found</p>
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- Search and All Games Section --}}
            <div class="w-full lg:w-1/3 p-6 order-1 lg:order-2 flex flex-col max-h-[500px]">
                {{-- Search Bar --}}
                <div class="mb-6 flex-shrink-0">
                    <div class="relative">
                        <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search games..."
                            class="w-full dark:bg-zinc-700 bg-gray-100 dark:text-white text-gray-900 border-0 rounded-full px-4 py-2.5 pl-4 pr-10 focus:outline-none focus:ring-2 dark:focus:ring-purple-500 focus:ring-purple-400 placeholder:text-gray-500 dark:placeholder:text-gray-400" />
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

                {{-- All Games List with Scrolling --}}
                <div class="flex-1 overflow-hidden flex flex-col">
                    <p class="text-xs font-semibold dark:text-gray-400 text-gray-600 px-2.5 mb-4 flex-shrink-0">
                        All Games
                    </p>

                    <div class="overflow-y-auto pr-2 space-y-2 flex-1 custom-scrollbar">
                        @forelse($this->content['all'] ?? [] as $gameItem)
                            <a href="{{ route('game.index', [
                                'gameSlug' => $gameItem['slug'],
                                'categorySlug' => $gameCategorySlug,
                            ]) }}"
                                wire:navigate>

                                <div
                                    class="flex items-center gap-2.5 p-2.5 dark:hover:bg-purple-500/10 hover:bg-purple-100 rounded-lg transition cursor-pointer">

                                    <div class="w-6 h-6 flex-shrink-0">
                                        @if(is_array($gameItem) && isset($gameItem['logo']))
                                            <img src="{{ storage_url($gameItem['logo']) }}"  
                                                alt="{{ is_array($gameItem) ? $gameItem['name'] : $gameItem }}"
                                                class="w-full h-full object-contain rounded-lg">
                                        @else
                                            <div
                                                class="w-full h-full rounded bg-gradient-to-br from-purple-500 to-purple-600 flex items-center justify-center">
                                                <span class="text-white text-xs font-bold">
                                                    {{ substr($gameItem['name'], 0, 1) }}
                                                </span>
                                            </div>
                                        @endif
                                    </div>

                                    <p class="text-sm font-normal dark:text-white text-gray-900">
                                        {{ $gameItem['name'] }}
                                    </p>
                                </div>
                            </a>
                        @empty
                            <div class="text-center py-8">
                                <p class="dark:text-gray-400 text-gray-600 text-sm">
                                    @if ($search)
                                        No games found matching "{{ $search }}"
                                    @else
                                        No games available
                                    @endif
                                </p>
                            </div>
                        @endforelse
                    </div>
                </div>

            </div>

        </div>
    </div>
</section>
