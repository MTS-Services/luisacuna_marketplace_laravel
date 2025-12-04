<div x-show="filter"
    class="glass-card bg-bg-primary text-text-white p-6 rounded-lg w-full absolute top-16 right-0 z-10 md:hidden">
    <!-- Header -->
    <div class="flex justify-between items-center border-b border-gray-700 pb-4 mb-4">
        <h2 class="text-lg font-semibold">Seller list</h2>
    </div>

    <!-- Toggle Buttons -->
    <div class="flex justify-between mb-6 space-x-3">

        {{--  Recommendation --}}

        <div class="flex-nowrap gap-5 relative flex md:hidden" x-data="{ open: false, selectedOption: '', selectedValue: '' }" @click.away="open = false">

            <!-- Hidden Input Field -->
            <input type="hidden" name="recommendation" x-model="selectedValue">

            <div class="flex justify-between rounded-full border border-zinc-700 bg-bg-primary items-center w-auto px-3 py-2 cursor-pointer"
                @click="open = !open">
                <span x-text="selectedOption || '{{ __('Recomendation') }}'"></span>
                <flux:icon name="chevron-down" class="w-5 h-5 transition-transform duration-200"
                    x-bind:class="open ? 'rotate-180' : ''" />
            </div>

            <div class="absolute top-[110%] left-0 w-50 rounded bg-bg-primary border border-zinc-700 z-20 overflow-hidden origin-top"
                x-show="open" x-transition:enter="transition ease-out duration-300 transform"
                x-transition:enter-start="opacity-0 scale-y-0" x-transition:enter-end="opacity-100 scale-y-100"
                x-transition:leave="transition ease-in duration-200 transform"
                x-transition:leave-start="opacity-100 scale-y-100" x-transition:leave-end="opacity-0 scale-y-0"
                @click.stop>
                <div class="px-5 py-5">
                    <ol class="list space-y-2">
                        <li class="py-3 px-4 text-text-primary bg-bg-secondary cursor-pointer hover:text-text-secondary hover:bg-bg-hover rounded transition-colors duration-150"
                            @click="selectedOption = '{{ __('Platform') }}'; selectedValue = ''; $wire.selectedPlatform = ''; open = false; $wire.call('serachFilter')">
                            {{ __('Platform') }}
                        </li>
                        <li class="py-3 px-4 text-text-primary bg-bg-secondary cursor-pointer hover:text-text-secondary hover:bg-bg-hover rounded transition-colors duration-150"
                            @click="selectedOption = 'Device 1'; selectedValue = 'device1'; $wire.selectedPlatform = 'device1'; open = false; $wire.call('serachFilter')">
                            Device 1
                        </li>
                        <li class="py-3 px-4 text-text-primary bg-bg-secondary cursor-pointer hover:text-text-secondary hover:bg-bg-hover rounded transition-colors duration-150"
                            @click="selectedOption = 'Device 2'; selectedValue = 'device2'; $wire.selectedPlatform = 'device2'; open = false; $wire.call('serachFilter')">
                            Device 2
                        </li>
                    </ol>
                </div>
            </div>
        </div>

        <button
            class="xs:px-2 px-5 py-2 rounded-full bg-bg-secondary/70 text-text-white font-semibold flex items-center gap-2">
            <span class="w-4 h-4 bg-green rounded-full"></span>
            <span>Online Seller</span>
        </button>


    </div>

    <!-- Dropdown Filters -->
    {{-- <div class="space-y-4 h-[calc(100vh-360px)] overflow-y-auto"> --}}
    <div class="space-y-4 h-[calc(100vh-360px)] overflow-x-hidden">
        <div>
            <label class="text-sm text-gray-400">Platform</label>
            <div class="flex-nowrap w-full gap-5 mt-2 relative flex md:hidden" x-data="{ open: false, selectedOption: '', selectedValue: '' }"
                @click.away="open = false">

                <!-- Hidden Input Field -->
                <input type="hidden" name="platform" x-model="selectedValue">

                <!-- Dropdown Trigger -->
                <div class="flex justify-between w-full border-b border-zinc-700 bg-bg-primary items-center py-2 cursor-pointer"
                    @click="open = !open">
                    <span x-text="selectedOption || '{{ __('Platform') }}'"></span>
                    <flux:icon name="chevron-down" class="w-5 h-5 transition-transform duration-200"
                        x-bind:class="open ? 'rotate-180' : ''" />
                </div>

                <!-- Dropdown Menu with Smooth Animation -->
                <div class="absolute top-[110%] left-0 w-full bg-bg-primary z-20 overflow-hidden origin-top"
                    x-show="open" x-transition:enter="transition ease-out duration-300 transform"
                    x-transition:enter-start="opacity-0 scale-y-0" x-transition:enter-end="opacity-100 scale-y-100"
                    x-transition:leave="transition ease-in duration-200 transform"
                    x-transition:leave-start="opacity-100 scale-y-100" x-transition:leave-end="opacity-0 scale-y-0"
                    @click.stop>
                    <div class="py-5">
                        <ol class="list space-y-2">
                            <li class="py-3 px-1 text-text-primary bg-bg-primary cursor-pointer hover:text-text-secondary hover:bg-bg-hover rounded transition-colors duration-150"
                                @click="selectedOption = '{{ __('Platform') }}'; selectedValue = ''; $wire.selectedPlatform = ''; open = false; $wire.call('serachFilter')">
                                {{ __('Platform') }}
                            </li>
                            <li class="py-3 px-1 text-text-primary bg-bg-primary cursor-pointer hover:text-text-secondary hover:bg-bg-hover rounded transition-colors duration-150"
                                @click="selectedOption = 'Device 1'; selectedValue = 'device1'; $wire.selectedPlatform = 'device1'; open = false; $wire.call('serachFilter')">
                                Device 1
                            </li>
                            <li class="py-3 px-1 text-text-primary bg-bg-primary cursor-pointer hover:text-text-secondary hover:bg-bg-hover rounded transition-colors duration-150"
                                @click="selectedOption = 'Device 2'; selectedValue = 'device2'; $wire.selectedPlatform = 'device2'; open = false; $wire.call('serachFilter')">
                                Device 2
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div>
            <label class="text-sm text-gray-400">Price</label>
            <div class="flex-nowrap gap-5 relative flex md:hidden" x-data="{ open: false, selectedMin: '', selectedMax: '' }" @click.away="open = false">

                <div class="price-input flex justify-between border-b border-zinc-700 bg-bg-primary items-center w-full py-2 cursor-pointer"
                    @click="open = !open">
                    <span x-text="selectedMin && selectedMax ? `$${selectedMin} - $${selectedMax}` : 'Price'"></span>
                    <flux:icon name="chevron-down" class="w-5 h-5 transition-transform duration-200"
                        x-bind:class="open ? 'rotate-180' : ''" />
                </div>

                <div class="price-dropdown absolute top-[110%] left-0 w-full bg-bg-primary z-20 overflow-hidden origin-top"
                    x-show="open" x-transition:enter="transition ease-out duration-300 transform"
                    x-transition:enter-start="opacity-0 scale-y-0" x-transition:enter-end="opacity-100 scale-y-100"
                    x-transition:leave="transition ease-in duration-200 transform"
                    x-transition:leave-start="opacity-100 scale-y-100" x-transition:leave-end="opacity-0 scale-y-0"
                    @click.stop>
                    <div class="py-5">
                        <div class="flex justify-center gap-2 flex-nowrap">
                            <div class="relative flex-1">
                                <span
                                    class="absolute left-3 top-1/2 -translate-y-1/2 text-text-primary pointer-events-none">$</span>
                                <x-ui.input type="text" placeholder="Min" wire:model="minPrice"
                                    class="border-zinc-700 pl-7" x-model="selectedMin" />
                            </div>
                            <div class="relative flex-1">
                                <span
                                    class="absolute left-3 top-1/2 -translate-y-1/2 text-text-primary pointer-events-none">$</span>
                                <x-ui.input type="text" placeholder="Max" wire:model="maxPrice"
                                    class="border-zinc-700 pl-7" x-model="selectedMax" />
                            </div>
                            <x-ui.button class="py-2! px-3! w-auto! rounded! flex md:hidden bg-transparent!"
                                :variant="'primary'"
                                @click="selectedMin = ''; selectedMax = ''; $wire.minPrice = ''; $wire.maxPrice = ''; $wire.call('serachFilter')">
                                <flux:icon name="trash" class="w-5 h-5" />
                            </x-ui.button>
                        </div>
                        <ol class="list pt-2.5 space-y-2">
                            <li class="py-3 px-1 text-text-primary bg-bg-secondary cursor-pointer hover:text-text-secondary hover:bg-bg-hover rounded transition-colors duration-150"
                                data-min="100" data-max="500"
                                @click="selectedMin = $el.dataset.min; selectedMax = $el.dataset.max; $wire.minPrice = $el.dataset.min; $wire.maxPrice = $el.dataset.max; open = false; $wire.call('serachFilter')">
                                $100 to $500
                            </li>
                            <li class="py-3 px-1 text-text-primary bg-bg-secondary cursor-pointer hover:text-text-secondary hover:bg-bg-hover rounded transition-colors duration-150"
                                data-min="500" data-max="1000"
                                @click="selectedMin = $el.dataset.min; selectedMax = $el.dataset.max; $wire.minPrice = $el.dataset.min; $wire.maxPrice = $el.dataset.max; open = false; $wire.call('serachFilter')">
                                $500 to $1000
                            </li>
                        </ol>
                    </div>
                </div>
            </div>

        </div>

        <div>
            <label class="text-sm text-gray-400">Delivery Time</label>
            <div class="flex-nowrap gap-5 relative flex md:hidden" x-data="{ open: false, selectedOption: '', selectedValue: '' }"
                @click.away="open = false">

                <!-- Hidden Input Field -->
                <input type="hidden" name="delivery_time" x-model="selectedValue">

                <div class="flex justify-between border-b border-zinc-700 bg-bg-primary items-center w-full py-2 cursor-pointer"
                    @click="open = !open">
                    <span x-text="selectedOption || '{{ __('Select Delivery Time') }}'"></span>
                    <flux:icon name="chevron-down" class="w-5 h-5 transition-transform duration-200"
                        x-bind:class="open ? 'rotate-180' : ''" />
                </div>

                <div class="absolute top-[110%] left-0 w-full bg-bg-primary z-20 overflow-hidden origin-top"
                    x-show="open" x-transition:enter="transition ease-out duration-300 transform"
                    x-transition:enter-start="opacity-0 scale-y-0" x-transition:enter-end="opacity-100 scale-y-100"
                    x-transition:leave="transition ease-in duration-200 transform"
                    x-transition:leave-start="opacity-100 scale-y-100" x-transition:leave-end="opacity-0 scale-y-0"
                    @click.stop>
                    <div class="py-5">
                        <ol class="list space-y-2">
                            <li class="py-3 px-1 text-text-primary bg-bg-secondary cursor-pointer hover:text-text-secondary hover:bg-bg-hover rounded transition-colors duration-150"
                                @click="selectedOption = '{{ __('Select Delivery Time') }}'; selectedValue = ''; $wire.selectedDeliveryTime = ''; open = false; $wire.call('serachFilter')">
                                {{ __('Select Delivery Time') }}
                            </li>
                            <li class="py-3 px-1 text-text-primary bg-bg-secondary cursor-pointer hover:text-text-secondary hover:bg-bg-hover rounded transition-colors duration-150"
                                @click="selectedOption = '{{ __('Instant Delivery') }}'; selectedValue = 'instant'; $wire.selectedDeliveryTime = 'instant'; open = false; $wire.call('serachFilter')">
                                {{ __('Instant Delivery') }}
                            </li>
                            <li class="py-3 px-1 text-text-primary bg-bg-secondary cursor-pointer hover:text-text-secondary hover:bg-bg-hover rounded transition-colors duration-150"
                                @click="selectedOption = '{{ __('In a Week') }}'; selectedValue = 'week'; $wire.selectedDeliveryTime = 'week'; open = false; $wire.call('serachFilter')">
                                {{ __('In a Week') }}
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Buttons -->
    <div class="flex justify-between gap-4 mt-8">
        <x-ui.button class="py-2" variant='secondary'>
            {{ __('Reset') }}
        </x-ui.button>
        <x-ui.button class="py-2">
            {{ __('Confirm') }}
        </x-ui.button>
    </div>
</div>