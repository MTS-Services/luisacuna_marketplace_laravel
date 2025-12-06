<div class="space-y-6">
    {{-- <div class=" p-4 w-full">
        <div class="flex flex-col lg:flex-row justify-between items-stretch lg:items-center gap-3 lg:gap-4">

            <!-- Left Side: Filters -->
            <div class="flex flex-col sm:flex-row gap-3 w-full lg:w-auto">

                <!-- Game Filter -->
                <div class="relative w-full sm:w-40 lg:w-44">
                    <x-ui.select class="bg-surface-card border border-border-primary py-1.5! rounded-lg">
                        <option value="">{{ __('All Game') }}</option>
                        @foreach ($games as $game)
                            <option value="{{ $game->id }}">{{ $game->name }}</option>
                        @endforeach
                    </x-ui.select>
                </div>

                <!-- Status Filter -->
                <div class="relative w-full sm:w-40 lg:w-44">
                    <x-ui.select class="bg-surface-card border border-border-primary py-1.5! rounded-lg">
                        <option value="">{{ __('All Requests') }}</option>
                        <option value="active">{{ __('In progress') }}</option>
                        <option value="paused">{{ __('Completed') }}</option>
                        <option value="closed">{{ __('Disputed') }}</option>
                        <option value="closed">{{ __('Cancelled') }}</option>
                    </x-ui.select>
                </div>
            </div>
            <!-- New Offer Button -->
            <x-ui.button class="w-full sm:w-fit! py-2!">
                <span
                    class="text-text-btn-primary group-hover:text-text-btn-secondary">{{ __('Create request') }}</span>
            </x-ui.button>
        </div>
    </div>
    <div>
        <x-ui.user-table :data="$items" :columns="$columns"
            emptyMessage="No data found. Add your first data to get started." class="rounded-lg overflow-hidden" />
        <x-frontend.pagination-ui :pagination="$pagination" />
    </div> --}}



{{-- Wrapper div with Alpine.js data -  --}}
<div x-data="{ showGameDropdown: false }">

    {{-- Page Content --}}
    <div class="space-y-6">
        <div class="p-4 w-full">
            <div class="flex flex-col lg:flex-row justify-between items-stretch lg:items-center gap-3 lg:gap-4">
                <!-- Left Side: Filters -->
                <div class="flex flex-col sm:flex-row gap-3 w-full lg:w-auto">
                    <!-- Game Filter -->
                    <div class="relative w-full sm:w-40 lg:w-44">
                        <x-ui.select class="bg-surface-card border border-border-primary py-1.5! rounded-lg">
                            <option value="">{{ __('All Game') }}</option>
                            @foreach ($games as $game)
                                <option value="{{ $game->id }}">{{ $game->name }}</option>
                            @endforeach
                        </x-ui.select>
                    </div>
                    <!-- Status Filter -->
                    <div class="relative w-full sm:w-40 lg:w-44">
                        <x-ui.select class="bg-surface-card border border-border-primary py-1.5! rounded-lg">
                            <option value="">{{ __('All Requests') }}</option>
                            <option value="active">{{ __('In progress') }}</option>
                            <option value="paused">{{ __('Completed') }}</option>
                            <option value="closed">{{ __('Disputed') }}</option>
                            <option value="closed">{{ __('Cancelled') }}</option>
                        </x-ui.select>
                    </div>
                </div>
                
                <!-- New Offer Button -->
                <x-ui.button 
                    class="w-full sm:w-fit! py-2!"
                    @click="showGameDropdown = !showGameDropdown; console.log('Button clicked, showGameDropdown:', showGameDropdown)">
                    <span class="text-text-btn-primary group-hover:text-text-btn-secondary">
                        {{ __('Create request') }}
                    </span>
                </x-ui.button>
            </div>
        </div>

        <div>
            <x-ui.user-table :data="$items" :columns="$columns"
                emptyMessage="No data found. Add your first data to get started." class="rounded-lg overflow-hidden" />
            <x-frontend.pagination-ui :pagination="$pagination" />
        </div>
    </div>

    {{-- Game Selection Dropdown - Same style as Category Hover --}}
    <section class="fixed inset-x-0 top-[72px] z-50" 
             x-show="showGameDropdown" 
             x-transition
             @click.outside="showGameDropdown = false"
             style="margin-top: 0;">
        <div class="container mx-auto px-4">
            <div class="dark:bg-zinc-800 bg-white flex flex-col lg:flex-row items-start justify-between rounded-lg shadow-2xl px-4 lg:px-10 max-h-[500px]">

                {{-- Popular Games Section --}}
                <div class="w-full lg:w-2/3 pt-6 order-2 lg:order-1 overflow-y-auto pr-4">
                    <h3 class="dark:text-white text-gray-900 text-base font-semibold pt-2 mb-6 sticky top-0 dark:bg-zinc-800 bg-white pb-2">
                        Popular Games
                    </h3>
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-2.5 pb-6">
                        @php
                            $popularGames = [
                                [
                                    'name' => 'New World Coins Currency',
                                    'categorySlug' => 'currency',
                                    'icon' => 'Frame 100.png',
                                    'slug' => 'new-world-coins',
                                ],
                                [
                                    'name' => 'Worldforge Legends Currency',
                                    'categorySlug' => 'currency',
                                    'icon' => 'Frame 94.png',
                                    'slug' => 'worldforge-legends',
                                ],
                                [
                                    'name' => 'Exilecon Official Trailer Accounts',
                                    'categorySlug' => 'accounts',
                                    'icon' => 'Frame 93.png',
                                    'slug' => 'exilecon-official-trailer',
                                ],
                                [
                                    'name' => 'Path of Exile 2 Currency',
                                    'categorySlug' => 'currency',
                                    'icon' => 'Frame 103.png',
                                    'slug' => 'path-of-exile-2-currency',
                                ],
                                [
                                    'name' => 'Throne and Liberty Lucent Currency',
                                    'categorySlug' => 'currency',
                                    'icon' => 'Frame 105.png',
                                    'slug' => 'throne-and-liberty-lucent',
                                ],
                                [
                                    'name' => 'Blade Ball Tokens Currency',
                                    'categorySlug' => 'currency',
                                    'icon' => 'Frame 97.png',
                                    'slug' => 'blade-ball-tokens',
                                ],
                                [
                                    'name' => 'EA Sports FC Currency',
                                    'categorySlug' => 'currency',
                                    'icon' => 'Frame1001.png',
                                    'slug' => 'ea-sports-fc-coins',
                                ],
                                [
                                    'name' => 'Realmwalker: New Dawn Accounts',
                                    'categorySlug' => 'accounts',
                                    'icon' => 'Frame 111.png',
                                    'slug' => 'realmwalker-new-dawn',
                                ],
                            ];
                        @endphp

                        @foreach ($popularGames as $item)
                            <a href="{{ route('game.index', ['gameSlug' => $item['slug'], 'categorySlug' => $item['categorySlug']]) }}"
                                wire:navigate
                                @click="showGameDropdown = false">
                                <div class="flex items-center gap-2.5 p-2 dark:hover:bg-purple-500/10 hover:bg-purple-100 rounded-lg transition cursor-pointer">
                                    <div class="w-6 h-6 flex-shrink-0">
                                        <img src="{{ asset('assets/images/game_icon/' . $item['icon']) }}"
                                            alt="{{ $item['name'] }}"
                                            class="w-full h-full object-contain rounded-lg">
                                    </div>
                                    <p class="text-base font-normal dark:text-white text-gray-900">{{ $item['name'] }}</p>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>

                {{-- Search and All Games Section --}}
                <div class="w-full lg:w-1/3 p-6 order-1 lg:order-2 flex flex-col max-h-[500px]">
                    {{-- Search Bar --}}
                    <div class="mb-6 flex-shrink-0">
                        <div class="relative">
                            <input type="text" 
                                   wire:model.live.debounce.300ms="gameSearch" 
                                   placeholder="Search games..."
                                   class="w-full dark:bg-zinc-700 bg-gray-100 dark:text-white text-gray-900 border-0 rounded-full px-4 py-2.5 pl-4 pr-10 focus:outline-none focus:ring-2 dark:focus:ring-purple-500 focus:ring-purple-400 placeholder:text-gray-500 dark:placeholder:text-gray-400" />
                            <button class="absolute right-3 top-1/2 -translate-y-1/2 dark:text-gray-400 text-gray-500 hover:text-purple-500 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    {{-- All Games List --}}
                    <div class="flex-1 overflow-hidden flex flex-col">
                        <p class="text-xs font-semibold dark:text-gray-400 text-gray-600 px-2.5 mb-4 flex-shrink-0">
                            All Games
                        </p>

                        <div class="overflow-y-auto pr-2 space-y-2 flex-1 custom-scrollbar">
                            @forelse($games ?? [] as $gameItem)
                                <a href="{{ route('game.index', ['gameSlug' => $gameItem->slug ?? '', 'categorySlug' => 'currency']) }}"
                                    wire:navigate
                                    @click="showGameDropdown = false">
                                    <div class="flex items-center gap-2.5 p-2.5 dark:hover:bg-purple-500/10 hover:bg-purple-100 rounded-lg transition cursor-pointer">
                                        <div class="w-6 h-6 flex-shrink-0">
                                            @if(isset($gameItem->logo))
                                                <img src="{{ asset($gameItem->logo) }}"  
                                                    alt="{{ $gameItem->name }}"
                                                    class="w-full h-full object-contain rounded-lg">
                                            @else
                                                <div class="w-full h-full rounded bg-gradient-to-br from-purple-500 to-purple-600 flex items-center justify-center">
                                                    <span class="text-white text-xs font-bold">
                                                        {{ substr($gameItem->name, 0, 1) }}
                                                    </span>
                                                </div>
                                            @endif
                                        </div>
                                        <p class="text-sm font-normal dark:text-white text-gray-900">
                                            {{ $gameItem->name }}
                                        </p>
                                    </div>
                                </a>
                            @empty
                                <div class="text-center py-8">
                                    <p class="dark:text-gray-400 text-gray-600 text-sm">
                                        No games available
                                    </p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

</div>

{{-- Custom Scrollbar CSS --}}
<style>
.custom-scrollbar::-webkit-scrollbar {
    width: 6px;
}

.custom-scrollbar::-webkit-scrollbar-track {
    background: transparent;
}

.custom-scrollbar::-webkit-scrollbar-thumb {
    background: #6b7280;
    border-radius: 3px;
}

.custom-scrollbar::-webkit-scrollbar-thumb:hover {
    background: #9333ea;
}
</style>
</div>
