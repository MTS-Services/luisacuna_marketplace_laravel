<div class="bg-bg-primary">
    <div class="container pb-48">
        <livewire:frontend.partials.breadcrumb :gameSlug="'currency'" :categorySlug="'sell currency'" />
        @if ($currentStep === 1)
            <div class="bg-bg-secondary rounded-2xl mb-10 p-4 sm:p-10 md:p-20">
                <h2 class="text-text-white text-2xl xl:text-40px font-semibold text-center">{{ __('Bulk Upload') }}</h2>

                <div class="mt-10">
                    <div class="">
                        <button wire:click="selectUploadMethod('web')"
                            class="w-full flex justify-between items-center p-4 bg-bg-info hover:bg-zinc-700/30 transition rounded-xl">
                            <div class="flex items-center gap-2 sm:gap-4">
                                <div class="bg-bg-info p-1 sm:p-4 rounded-xl">
                                    <x-phosphor name="paperclip" variant="regular" class="w-8 h-8 text-zinc-400" />
                                </div>
                                <div>
                                    <p class="text-base sm:text-3xl font-semibold text-text-white text-start">WEB</p>
                                    <p class="text-text-white font-normal text-base sm:text-base mt-1 text-start">
                                        {{ __('Create multiple offers via web interface') }}</p>
                                </div>
                            </div>

                            <svg class="w-6 h-6 fill-white" viewBox="0 0 256 256">
                                <path
                                    d="M181.66,133.66l-80,80a8,8,0,0,1-11.32-11.32L164.69,128,90.34,53.66a8,8,0,0,1,11.32-11.32l80,80A8,8,0,0,1,181.66,133.66Z">
                                </path>
                            </svg>
                        </button>
                    </div>
                    <div class="mt-10">
                        <button wire:click="selectUploadMethod('csv')"
                            class="w-full flex justify-between items-center p-4 bg-bg-info hover:bg-zinc-700/30 transition rounded-xl">
                            <div class="flex items-center gap-2 sm:gap-4">
                                <div class="bg-bg-info p-1 sm:p-4 rounded-xl">
                                    <x-phosphor name="squares-four" variant="regular" class="w-8 h-8 text-zinc-400" />
                                </div>
                                <div>
                                    <p class="text-base sm:text-3xl font-semibold text-text-white text-start">CSV</p>
                                    <p class="text-text-white font-normal text-base sm:text-base mt-1 text-start">
                                        {{ __('Create multiple offers by uploading a CSV file') }}</p>
                                </div>
                            </div>

                            <svg class="w-6 h-6 fill-white" viewBox="0 0 256 256">
                                <path
                                    d="M181.66,133.66l-80,80a8,8,0,0,1-11.32-11.32L164.69,128,90.34,53.66a8,8,0,0,1,11.32-11.32l80,80A8,8,0,0,1,181.66,133.66Z">
                                </path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        @endif

        {{-- Step 2: Choose Game --}}
        @if ($currentStep === 2)
            <div class="bg-bg-secondary rounded-2xl mb-10 p-4 sm:p-10 md:p-20">
                <h2 class="text-2xl sm:text-40px font-semibold text-center text-text-white mb-3">
                    {{ __('Sell Game Currency') }}
                </h2>
                <h2 class="text-xl sm:text-2xl text-center text-text-white mb-5 sm:mb-10">{{ __('Step 1/2') }}</h2>

                <div class="p-5 sm:p-10 bg-bg-info rounded-2xl">
                    <h2 class="text-xl xxs:text-2xl font-semibold text-center text-text-white mb-2 sm:mb-7">
                        {{ __('Choose Game') }}
                    </h2>

                    <x-ui.custom-select :rounded="'rounded'" :label="__('Select a game')" :wireModel="'gameId'" class="border-0!" />

                    @error('gameId')
                        <p class="text-pink-500 text-center mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex gap-4 justify-center mt-5! sm:mt-10!">
                    <div class="flex md:w-auto!">
                        <x-ui.button wire:click="back"
                            class="w-fit! py-2! px-4! text-text-white">{{ __('Back') }}</x-ui.button>
                    </div>
                    <div class="flex md:w-auto!">
                        <x-ui.button wire:click="selectGame"
                            class="w-fit! py-2! px-4!">{{ __('Next') }}</x-ui.button>
                    </div>
                </div>
            </div>
        @endif

        {{-- Step 3: Item Details (Region & Server) --}}
        @if ($currentStep === 3)
            <div class="bg-bg-secondary rounded-2xl mb-10 p-4 sm:p-10 md:p-20">
                <h2 class="text-2xl sm:text-40px font-semibold text-center text-text-white mb-3">
                    {{ __('Sell Game Currency') }}
                </h2>
                <h2 class="text-xl sm:text-2xl text-center text-text-white mb-5 sm:mb-10">{{ __('Step 2/2') }}</h2>

                <div class="p-5 sm:p-10 bg-bg-info rounded-2xl">
                    <h2 class="text-2xl xxs:text-3xl font-semibold text-text-white mb-2 sm:mb-7">
                        {{ __('Item details') }}
                    </h2>

                    <div class="w-full">
                        <x-ui.label :for="'region'" :value="'Region:'"
                            class="mb-5! text-xl! xxs:text-2xl! font-semibold!"></x-ui.label>
                        <x-ui.custom-select :rounded="'rounded'" :label="__('Select a region')" :wireModel="'regionId'"
                            class="border-0! w-full!" :mdWidth="'md:w-full'" :mdLeft="'md:left-0'" :border="'border-transparent'" />

                        @error('regionId')
                            <p class="text-pink-500 text-center mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="w-full mt-5">
                        <x-ui.label :for="'server'" :value="'Server:'"
                            class="mb-5! text-xl! xxs:text-2xl! font-semibold!"></x-ui.label>
                        <x-ui.custom-select :rounded="'rounded'" :label="__('Select Server')" :wireModel="'serverId'"
                            class="border-0! w-full!" :mdWidth="'md:w-full'" :mdLeft="'md:left-0'" :border="'border-transparent'" />

                        @error('serverId')
                            <p class="text-pink-500 text-center mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="bg-bg-info p-6 rounded-2xl mt-7">
                        <p class="text-text-white font-normal text-base xxs:text-xl">
                            <span class="text-pink-500">{{ __('NOTE!') }}</span>
                            {{ __('Selecting a server also creates offers for both factions (Horde and Alliance). If you don`t need one, delete it afterward.') }}
                        </p>
                    </div>
                </div>

                <div class="flex gap-4 justify-center mt-5! sm:mt-10!">
                    <div class="flex md:w-auto!">
                        <x-ui.button wire:click="back"
                            class="w-fit! py-2! px-4! text-text-white">{{ __('Back') }}</x-ui.button>
                    </div>
                    <div class="flex md:w-auto!">
                        <x-ui.button wire:click="selectServerAndRegion"
                            class="w-fit! py-2! px-4!">{{ __('Next') }}</x-ui.button>
                    </div>
                </div>
            </div>
        @endif

        {{-- Step 4: CSV Upload --}}
        @if ($currentStep === 4)
            <div class="bg-bg-secondary rounded-2xl mb-10 p-4 sm:p-10 md:p-20">
                <h2 class="text-2xl sm:text-40px font-semibold text-center text-text-white mb-3">
                    {{ __('Bulk Upload') }}</h2>

                <div class="bg-bg-info p-6 rounded-2xl my-10">
                    <p class="text-pink-500 font-normal text-2xl">{{ __('NOTE!') }}</p>
                    <p class="text-text-white font-normal text-lg xxs:text-xl">
                        {{ __('Bulk upload is available only on currency category at the moment.') }}
                    </p>
                </div>

                <div>
                    <h3 class="text-text-white font-semibold text-xl xxs:text-2xl mb-4">
                        {{ __('1. Download the bulk upload template file.') }}</h3>
                    <div class="flex items-center gap-2">
                        <x-phosphor name="paperclip" variant="regular" class="w-5 h-5 fill-pink-500" />
                        <p class="text-pink-500 text-xs xxs:text-base font-normal">{{ __('WOW Example') }}</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <x-phosphor name="paperclip" variant="regular" class="w-5 h-5 fill-pink-500" />
                        <p class="text-pink-500 text-xs xxs:text-base font-normal">{{ __('WOW Mists of Pandaria Example') }}</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <x-phosphor name="paperclip" variant="regular" class="w-5 h-5 fill-pink-500" />
                        <p class="text-pink-500 text-xs xxs:text-base font-normal">{{ __('WOW Classic Era Example') }}</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <x-phosphor name="paperclip" variant="regular" class="w-5 h-5 fill-pink-500" />
                        <p class="text-pink-500 text-xs xxs:text-base font-normal">{{ __('New World Example') }}</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <x-phosphor name="paperclip" variant="regular" class="w-5 h-5 fill-pink-500" />
                        <p class="text-pink-500 text-xs xxs:text-base font-normal">{{ __('Lost Ark Example') }}</p>
                    </div>
                    <h3 class="text-text-white font-semibold text-xl xxs:text-2xl mt-3 xxs:mt-6">
                        {{ __('2. Fill in the required fields in the template file.') }}</h3>
                    <h3 class="text-text-white font-semibold text-xl xxs:text-2xl mt-3 xxs:mt-6">
                        {{ __('3. Edit your template file') }}</h3>
                    <h3 class="text-text-white font-semibold text-xl xxs:text-2xl mt-3 xxs:mt-6">
                        {{ __('4. Upload edited file') }}</h3>
                </div>

                <div class="block xxs:flex gap-4 mt-5! sm:mt-10!">
                    <div class="flex md:w-auto!">
                        <x-ui.button wire:click=""
                            class="w-fit! py-2! px-4! text-text-white">{{ __('Upload images') }}</x-ui.button>
                    </div>
                    <label for="file-input-alt"
                        class="bg-bg-primary text-text-white font-medium py-2 px-4 rounded-lg cursor-pointer transition-colors inline-block hover:bg-opacity-90 mt-2 xxs:mt-0">
                        {{ __('Choose File') }}
                    </label>
                    <input id="file-input-alt" type="file" wire:model="file" accept=".csv" class="hidden w-full">

                    @if ($file)
                        <span class="text-text-white py-2">{{ $file->getClientOriginalName() }}</span>
                    @endif
                </div>

                <p class="text-text-white block! mt-2">{{ __('Must be CSV and cannot exceed 1MB.') }}</p>

                @error('file')
                    <p class="text-pink-500 mt-2">{{ $message }}</p>
                @enderror

                <div class="flex gap-4 mt-9">
                    <div class="flex md:w-auto!">
                        <x-ui.button wire:click="back"
                            class="w-fit! py-2! px-4! text-text-white">{{ __('Back') }}</x-ui.button>
                    </div>
                    <div class="flex md:w-auto!">
                        <x-ui.button wire:click="uploadFile"
                            class="w-fit! py-2! px-4!">{{ __('Upload') }}</x-ui.button>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
