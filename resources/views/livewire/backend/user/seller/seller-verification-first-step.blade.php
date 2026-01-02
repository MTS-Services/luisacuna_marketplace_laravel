<div class="min-h-[70vh] bg-bg-primary py-10 px-4">
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
                <div class="text-sm text-text-white font-normal pt-2">
                    {{ __('Step') }} <span>1</span>/<span>6</span>
                </div>
            </div>

            <div class="p-5 lg:px-15 lg:py-10 bg-bg-info  rounded-2xl">
                <div class="p-5 bg-bg-info shadow rounded-2xl">
                    <h2 class="font-semibold text-text-white text-base lg:text-2xl pb-5 text-left">
                        {{ __('Will you sell on Eldorado as an individual or as a company?') }}</h2>

                    @foreach ($accountTypes as $accountType)
                        <div class="flex items-center gap-2 mb-3">
                            <input type="radio" name="accountType" value="{{ $accountType['value'] }}"
                                wire:model="account_type" id="{{ $accountType['value'] }}" class="accent-pink-500">
                            <label for="{{ $accountType['value'] }}"
                                class="text-base ">{{ $accountType['label'] }}</label>
                        </div>
                    @endforeach

                    <div class="mt-2 text-left">
                        <x-ui.input-error :messages="$errors->get('account_type')" />
                    </div>
                </div>

            </div>
            <div class="flex gap-4 justify-center mt-5! sm:mt-10!">
                <div class="flex justify-center">
                    <x-ui.button type="submit" href="{{ route('user.seller.verification', ['step' => 2]) }}"
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
