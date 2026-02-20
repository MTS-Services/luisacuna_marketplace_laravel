<div class="bg-bg-primary">
    <div class="container pb-10">
        <livewire:frontend.partials.breadcrumb :gameSlug="''" :categorySlug="$categoryName" />
        <div class="w-full mx-auto rounded-2xl">
            <div class="bg-bg-secondary p-4 sm:p-10 md:p-20 rounded-2xl">
                <h2 class="text-2xl sm:text-40px font-semibold text-center text-text-white mb-3">
                    {{ __('Sell') }} {{ $categoryName }}
                </h2>
                <h2 class="text-xl sm:text-2xl text-center text-text-white mb-5 sm:mb-10">{{ __('Step 1/2') }}</h2>

                <div class="p-5 sm:p-10 bg-bg-info rounded-2xl">
                    <h2 class="text-2xl font-semibold text-center text-text-white mb-2 sm:mb-7">
                        {{ __('Choose Game') }}
                    </h2>

                    <div class="mx-auto w-full sm:w-1/2">
                        <x-ui.custom-select :wireModel="'gameId'" :dropDownClass="'border-0!'" class="rounded-md! border-0! bg-bg-info!"
                            label="Select Game">
                            @forelse ($games as $item)
                                <x-ui.custom-option :value="$item->id" :label="$item->name" />
                            @empty
                                <x-ui.custom-option :value="null" :label="__('No game found')" disabled />
                            @endforelse
                        </x-ui.custom-select>
                    </div>
                    @error('gameId')
                        <p class="text-pink-500 text-center mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex gap-4 justify-center mt-5! sm:mt-10!">
                    <a href="{{ route('user.offers') }}" class="flex md:w-auto!">
                        <x-ui.button class="w-fit! py-2! px-4!">{{ __('Back') }}</x-ui.button>
                    </a>
                    @if ($games->count() > 0)
                        <div wire:click="selectGame" class="flex md:w-auto!">
                            <x-ui.button class="w-fit! py-2! px-4!">
                                <span
                                    class="text-text-btn-primary group-hover:text-text-btn-secondary">{{ __('Next') }}</span>
                            </x-ui.button>
                        </div>
                    @endif
                </div>

                <div class="text-center mt-5">
                    <p class="inline-block text-center text-text-white text-xs sm:text-base font-normal">
                        {{ __('Can\'t find the game you want to sell? Contact our ') }}
                    </p>
                    <p class="inline-block text-pink-500 text-xs sm:text-base font-normal ml-1">
                        {{ __(' customer support') }}
                    </p>
                    <p class="inline-block text-text-white text-xs sm:text-base font-normal">
                        {{ __('  to suggest a game.') }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
