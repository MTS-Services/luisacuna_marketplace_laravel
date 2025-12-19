<div class="min-h-[70vh] bg-bg-primary py-12 px-4">
    <div class="max-w-4xl mx-auto">

        @if (session('success'))
            <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                {{ session('error') }}
            </div>
        @endif

        <div class="text-center w-full rounded-2xl bg-bg-secondary px-5 py-8 lg:p-20">
            <div class="mb-6">
                <div class="mx-auto flex flex-row items-center justify-center">
                    <span class="text-8xl pr-2.5">
                        <flux:icon name="shield-check" class="stroke-zinc-500"></flux:icon>
                    </span>
                    <p class="font-semibold text-2xl ">{{ __('Seller ID verification') }}</p>
                </div>
                <div class="text-sm text-text-primary font-normal pt-2">
                    Step <span>3</span>/<span>6</span>
                </div>
            </div>

            <div class="p-5 lg:px-15 lg:py-10 bg-bg-info  rounded-2xl">

                <div class="p-5 bg-bg-info shadow rounded-2xl">
                    <h2 class="font-semibold text-text-primary text-base  lg:text-2xl pb-5 text-left">
                        {{ __('Selling experience:') }}</h2>

                    @foreach ($sellingExperiences as $sellingExperience)
                        <div class="flex items-center gap-2">
                            <input type="radio" wire:model="selling_experience"
                                value="{{ $sellingExperience['value'] }}" id="{{ $sellingExperience['value'] }}"
                                class="accent-pink-500">
                            <label for="{{ $sellingExperience['value'] }}">{{ $sellingExperience['label'] }}</label>
                        </div>
                    @endforeach

                    <div class="mt-2 ">
                        <x-ui.input-error :messages="$errors->get('selling_experience')" />
                    </div>

                </div>
            </div>

            <div class="flex justify-center space-x-4 pt-10">
                {{-- <a wire:click.prevent="previousStep" wire:navigate class="px-8 cursor-pointer py-2  hover:bg-zinc-50 rounded-lg">
                    BACK
                </a>
                <button wire:click="nextStep" class="px-8 py-2 text-white rounded-lg transition" 
                    :class="{
                        'bg-zinc-600 hover:bg-zinc-700': $wire.selectedCategories.length > 0,
                        'bg-zinc-200 text-zinc-950 cursor-pointer!': $wire.selectedCategories.length === 0
                    }">
                    NEXT
                </button> --}}
                <!-- Submit button -->
                <div class=" flex justify-center px-2 sm:px-6 mt-5 sm:mt-11">
                    <x-ui.button type="submit" wire:click.prevent="previousStep" wire:navigate
                        class="w-auto py-2! text-white text-base! font-semibold!">
                        {{ __('BACK') }}
                    </x-ui.button>
                </div>
                <div class="  flex justify-center px-2 sm:px-6 mt-5 sm:mt-11">
                    <x-ui.button type="submit" wire:click="nextStep" class="w-auto py-2!  text-base! font-semibold!">
                        {{ __('NEXT') }}
                    </x-ui.button>
                </div>
            </div>

        </div>

    </div>
</div>
