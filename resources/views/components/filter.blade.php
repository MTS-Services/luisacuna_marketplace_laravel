@props(
    [
        'sortOrder' => 'asc',
    ]
)
<div>



    <div class="flex items-center justify-between gap-4 mt-3.5">
        <div class="search w-full">
            <x-ui.input type="text" wire:model.live.debounce.300ms="search" placeholder="Search..."
                class="form-input w-full rounded-full! border border-zinc-700" />
        </div>
        <div class="min-w-30 flex items-center justify-between gap-2 relative" x-data={filter:false}>

            {{-- Filter Button --}}
            <button @click="filter = !filter"
                class="flex items-center gap-2 px-4 py-2.5 bg-bg-primary rounded-full border! border-zinc-700!">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2l-7 7v5l-4 4v-9L3 6V4z" />
                </svg>
                <span class="text-text-white text-sm">
                    @if ($sortOrder === 'asc')
                        {{ __('a-z') }}
                    @elseif($sortOrder === 'desc')
                        {{ __('z-a') }}
                    @else
                        {{ __('Default') }}
                    @endif
                </span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                    </path>
                </svg>
            </button>

            {{-- Dropdown --}}
            <div class="absolute top-12 right-[-7%] z-10 shadow-glass-card min-w-31" x-show="filter" x-transition
                x-cloak @click.outside="filter = false">
                <div class="bg-bg-primary rounded-md p-4">
                    <div class="flex flex-col gap-2">
                        <button wire:click="sortBy('asc')" @click="filter = false"
                            class="text-left px-3 py-2 rounded transition {{ $sortOrder === 'asc' ? 'bg-bg-hover' : 'hover:bg-bg-hover' }}">
                            {{ __('A-Z') }}
                        </button>
                        <button wire:click="sortBy('desc')" @click="filter = false"
                            class="text-left px-3 py-2 rounded transition {{ $sortOrder === 'desc' ? 'bg-bg-hover' : 'hover:bg-bg-hover' }}">
                            {{ __('Z-A') }}
                        </button>
                        <button wire:click="sortBy('default')" @click="filter = false"
                            class="text-left px-3 py-2 rounded transition {{ $sortOrder === 'default' ? 'bg-bg-hover' : 'hover:bg-bg-hover' }}">
                            {{ __('Default') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
