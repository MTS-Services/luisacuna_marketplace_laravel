<div class="bg-bg-primary">
    <div class="container pb-10">
        <livewire:frontend.partials.breadcrumb :gameSlug="'currency'" :categorySlug="'sell currency'" />
        @if ($currentStep === 1)
            <div class="bg-bg-secondary rounded-2xl p-4 sm:p-10 md:p-20">
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

                            <svg class="w-6 h-6 fill-text-white" viewBox="0 0 256 256">
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

                            <svg class="w-6 h-6 fill-text-white" viewBox="0 0 256 256">
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
            <div class="bg-bg-secondary rounded-2xl p-4 sm:p-10 md:p-20">
                <h2 class="text-2xl sm:text-40px font-semibold text-center text-text-white mb-3">
                    {{ __('Sell Game Currency') }}
                </h2>
                <h2 class="text-xl sm:text-2xl text-center text-text-white mb-5 sm:mb-10">{{ __('Step 1/2') }}</h2>

                <div class="p-5 sm:p-10 bg-bg-info rounded-2xl">
                    <h2 class="text-xl xxs:text-2xl font-semibold text-center text-text-white mb-2 sm:mb-7">
                        {{ __('Choose Game') }}
                    </h2>

                    {{-- <x-ui.custom-select :rounded="'rounded'" :label="__('Select a game')" :wireModel="'gameId'" class="border-0!" /> --}}



                    <div class="mx-auto w-full sm:w-1/2">
                        <x-ui.custom-select :wireModel="'gameId'" :dropDownClass="'border-0!'" class="rounded-md! border-0!">
                            <x-ui.custom-option :value="null" :label="__('Select a game')" />
                            @foreach ($games as $item)
                                <x-ui.custom-option :value="$item->id" :label="$item->name" />
                            @endforeach
                        </x-ui.custom-select>
                    </div>

                    @error('gameId')
                        <p class="text-pink-500 text-center mt-2">{{ $message }}</p>
                    @enderror
                </div>



                <div class="flex justify-center mt-5! sm:mt-10!">
                    <div class="flex justify-center px-2 sm:px-6">
                        <x-ui.button wire:click="back" variant="secondary" class="w-auto py-2!">
                            {{ __('Back') }}
                        </x-ui.button>
                    </div>
                    <div class="flex justify-center px-2 sm:px-6">
                        <x-ui.button wire:click="selectGame" class="w-auto py-2!">{{ __('Next') }}</x-ui.button>
                    </div>
                </div>
            </div>
        @endif

        {{-- Step 3: Item Details (Region & Server) --}}
        @if ($currentStep === 30)
            <div class="bg-bg-secondary rounded-2xlp-4 sm:p-10 md:p-20">
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
                        {{-- <x-ui.custom-select :rounded="'rounded'" :label="__('Select a region')" :wireModel="'regionId'"
                            class="border-0! w-full!" :mdWidth="'md:w-full'" :mdLeft="'md:left-0'" :border="'border-transparent'" /> --}}
                        <div class="">
                            <x-ui.custom-select :wireModel="'regionId'" :dropDownClass="'border-0!'" class="rounded-md! border-0!">
                                <x-ui.custom-option :value="null" :label="__('Select a region')" />
                                {{-- @foreach ($games as $item)
                                <x-ui.custom-option :value="$item->id" :label="$item->name" />
                            @endforeach --}}
                            </x-ui.custom-select>
                        </div>

                        @error('regionId')
                            <p class="text-pink-500 text-center mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="w-full mt-5">
                        <x-ui.label :for="'server'" :value="'Server:'"
                            class="mb-5! text-xl! xxs:text-2xl! font-semibold! w-full!"></x-ui.label>
                        {{-- <x-ui.custom-select :rounded="'rounded'" :label="__('Select Server')" :wireModel="'serverId'"
                            class="border-0! w-full!" :mdWidth="'md:w-full'" :mdLeft="'md:left-0'" :border="'border-transparent'" /> --}}


                        <div class="">
                            <x-ui.custom-select :wireModel="'serverId'" :dropDownClass="'border-0!'" class="rounded-md! border-0!">
                                <x-ui.custom-option :value="null" :label="__('Select Server')" />
                                {{-- @foreach ($games as $item)
                                <x-ui.custom-option :value="$item->id" :label="$item->name" />
                            @endforeach --}}
                            </x-ui.custom-select>
                        </div>

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
                <div class="flex justify-center mt-5! sm:mt-10!">
                    <div class="flex justify-center px-2 sm:px-6">
                        <x-ui.button wire:click="back" variant="secondary" class="w-auto py-2!">
                            {{ __('Back') }}
                        </x-ui.button>
                    </div>
                    <div class="flex justify-center px-2 sm:px-6">
                        <x-ui.button wire:click="selectServerAndRegion"
                            class="w-auto py-2!">{{ __('Next') }}</x-ui.button>
                    </div>
                </div>
            </div>
        @endif

        {{-- Step 4: CSV Upload --}}
        @if ($currentStep === 3)
            <div class="bg-bg-secondary rounded-2xl p-4 sm:p-10 md:p-20">
                <h2 class="text-2xl sm:text-40px font-semibold text-center text-text-white mb-3">
                    {{ __('Bulk Upload') }}
                </h2>

                {{-- <div class="bg-bg-info p-6 rounded-2xl my-10">
                    <p class="text-pink-500 font-normal text-2xl">{{ __('NOTE!') }}</p>
                    <p class="text-text-white font-normal text-lg xxs:text-xl">
                        {{ __('Bulk upload is available only on currency category at the moment.') }}
                    </p>
                </div> --}}

                <div>
                    <h3 class="text-text-white font-semibold text-xl xxs:text-2xl mb-4">
                        {{ __('1. Download the bulk upload template file.') }}
                    </h3>

                    @if ($gameId)
                        <div class="flex items-center gap-2 mb-4 p-4 border border-pink-500/30 rounded-lg bg-pink-500/10 cursor-pointer"
                            wire:click="downloadTemplate">
                            <x-phosphor name="download-simple" variant="regular" class="w-6 h-6 fill-pink-500" />
                            <p class="text-pink-500 text-xs xxs:text-base font-bold">
                                {{ __('Click here to download template for selected game') }}
                            </p>
                        </div>
                    @else
                        <p class="text-yellow-500 text-sm mb-4 italic">
                            {{ __('Please select a game first to download the correct template.') }}</p>
                    @endif

                    <div class="flex flex-col gap-2 opacity-60">
                        <p class="text-text-white text-sm mb-1">{{ __('Sample Examples:') }}</p>
                        <div class="flex items-center gap-2">
                            <x-phosphor name="paperclip" variant="regular" class="w-5 h-5 fill-pink-500" />
                            <p class="text-pink-500 text-xs xxs:text-base font-normal cursor-not-allowed">
                                {{ __('WOW Example') }}</p>
                        </div>
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
                        <x-ui.button class="w-fit! py-2! px-4! text-text-white opacity-50" disabled>
                            {{ __('Upload images') }}
                        </x-ui.button>
                    </div>

                    <label for="file-input-alt"
                        class="bg-bg-primary text-text-white font-medium py-2 px-4 rounded-lg cursor-pointer transition-colors inline-block hover:bg-opacity-90 mt-2 xxs:mt-0">
                        {{ __('Choose CSV File') }}
                    </label>
                    <input id="file-input-alt" type="file" wire:model="file" accept=".csv" class="hidden w-full">

                    @if ($file)
                        <span class="text-green-500 py-2 font-semibold">
                            <x-phosphor name="check-circle" class="inline w-5 h-5" />
                            {{ $file->getClientOriginalName() }}
                        </span>
                    @endif
                </div>

                <p class="text-text-white block! mt-2 text-sm">{{ __('File must be CSV and cannot exceed 1MB.') }}</p>

                @error('file')
                    <p class="text-pink-500 mt-2 bg-pink-500/10 p-2 rounded">{{ $message }}</p>
                @enderror

                @if (session()->has('success'))
                    <p x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 10000)"
                        class="text-green-500 mt-2 bg-green-500/10 p-2 rounded">
                        {{ session('success') }}
                    </p>
                @endif


                <div class="flex justify-start mt-5! sm:mt-10!">
                    <x-ui.button wire:click="uploadFile" wire:loading.attr="disabled"
                        class="w-auto py-2! disabled:opacity-50 text-white! hover:text-black!">
                        <span wire:loading.remove>{{ __('Confirm & Upload') }}</span>
                        <span wire:loading>{{ __('Processing...') }}</span>
                    </x-ui.button>
                </div>
            </div>
        @endif
    </div>
</div>
