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
                    <p class="font-semibold text-xl sm:text-2xl ">{{ __('Seller ID verification') }}</p>
                </div>
                <div class="text-sm text-text-primary font-normal pt-2">
                    {{ __('Step') }} <span>2</span>/<span>6</span>
                </div>
            </div>

            <div class="p-5 lg:px-15 lg:py-10 bg-bg-info rounded-2xl">
                <div class="p-5 bg-bg-info rounded-2xl">
                    <h2 class="font-semibold text-text-primary text-base lg:text-2xl pb-5 text-left">
                        {{ __('Select the categories you\'ll be selling in:') }}</h2>

                    @foreach ($categories as $value => $label)
                        <div class="flex items-center gap-3 mb-3">
                            <label class="relative inline-flex items-center cursor-pointer text-base!">
                                <input type="checkbox" wire:model="selectedCategories" value="{{ $value }}"
                                    class="radio bg-transparent checked:before:bg-pink-500! checked:border-pink-500 border-pink-500 scale-75!"
                                    checked>
                                <span class="ml-2">{{ $label }}</span>
                            </label>
                        </div>
                    @endforeach
                    <div class="mt-2 text-left">
                        <x-ui.input-error :messages="$errors->get('selectedCategories')" />
                    </div>
                </div>
            </div>

            <div class="flex gap-4 justify-center mt-5! sm:mt-10!">
                <div class="flex justify-center">
                    <x-ui.button type="submit" wire:click.prevent="previousStep" wire:navigate
                        variant="secondary" class="w-auto py-2!">
                        {{ __('Back') }}
                    </x-ui.button>
                </div>
                <div class="flex justify-center">
                    <x-ui.button type="submit" wire:click="nextStep"
                        class="w-auto py-2!">{{ __('Next') }}</x-ui.button>
                </div>
            </div>
        </div>
    </div>
</div>
