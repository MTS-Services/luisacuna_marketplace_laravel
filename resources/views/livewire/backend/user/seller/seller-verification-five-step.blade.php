<div class="min-h-[70vh] bg-bg-primary py-12 px-4">
    <div class="max-w-4xl mx-auto">
        <div class="text-center w-full rounded-2xl bg-bg-secondary px-5 py-8 lg:p-20">
            <div class="mb-6">
                <div class="mx-auto flex flex-row items-center justify-center">
                    <span class="text-8xl pr-2.5">
                        <flux:icon name="shield-check" class="stroke-zinc-500"></flux:icon>
                    </span>
                    <p class="font-semibold text-xl sm:text-2xl ">{{ __('Seller ID verification') }}</p>
                </div>
                <div class="text-sm text-text-primary font-normal pt-2">
                    {{ __('Step') }} <span>5</span>/<span>6</span>
                </div>
            </div>

            <div class="p-5 lg:px-15 lg:py-10 bg-bg-info rounded-2xl">

                @if ($accountType == 0)
                    <h2 class="text-base lg:text-xl font-semibold  mb-8 text-left">
                        {{ __('Take a photo of your ID and swapy.gg in background') }}
                    </h2>

                    <div class="px-0 sm:px-8 text-left">
                        <div class="flex justify-center mb-4 relative">
                            {{-- Image Upload Loading Overlay --}}
                            <div wire:loading.flex wire:target="front_image">
                                <div
                                    class="absolute inset-0 z-10 flex items-center justify-center bg-bg-secondary/60 rounded-2xl backdrop-blur-[2px]">
                                    <div class="flex flex-col items-center">
                                        <div
                                            class="animate-spin rounded-full h-12 w-12 border-4 border-zinc-500 border-t-white mb-3">
                                        </div>
                                        <span class="text-white font-medium">{{ __('Uploading image...') }}</span>
                                    </div>
                                </div>
                            </div>

                            @if ($front_image)
                                <div class="w-[100px] h-[100px] sm:w-[510px] sm:h-[382px]">
                                    <img src="{{ $front_image->temporaryUrl() }}" alt="ID Preview"
                                        class="mx-auto w-full h-full object-cover rounded-xl"
                                        onerror="this.style.display='none'; this.nextElementSibling.style.display='flex'">
                                </div>
                            @else
                                <img src="{{ asset('assets/images/verfy.png') }}" alt="" class="mx-auto">
                            @endif
                        </div>

                        <ul class="space-y-2 font-lato mb-6 ">
                            <li class="flex items-start">
                                <span class="mr-2">•</span>
                                <span class=" font-semibold">
                                    {{ __('Accepted documents: Driver\'s license, Government issued ID or Passport, international student ID.') }}
                                </span>
                            </li>
                            <li class="flex items-start">
                                <span class="mr-2 ">•</span>
                                <span class=" font-semibold">
                                    {{ __('Make sure personal details on the document are clearly visible and easy to read.') }}
                                </span>
                            </li>
                        </ul>

                        <div class="flex items-center max-w-88 mx-auto rounded-lg overflow-hidden">
                            <input type="file" wire:model="front_image" accept="image/*" class="hidden"
                                id="idDocument">

                            <label for="idDocument" wire:loading.class="opacity-50 cursor-not-allowed"
                                wire:target="front_image"
                                class="shrink-0 px-6 py-2 bg-zinc-600 border border-zinc-500 text-zinc-950 font-semibold rounded-3xl hover:text-primary hover:bg-transparent  cursor-pointer transition duration-150 ease-in-out">
                                {{ __('Choose file') }}
                            </label>

                            <div
                                class="p-2 text-sm text-primary-100 truncate w-full bg-bg-light-black shadow rounded-sm ml-2 text-left">
                                @if ($front_image)
                                    {{ $front_image->getClientOriginalName() }}
                                @else
                                    {{ __('No file chosen') }}
                                @endif
                            </div>
                        </div>

                        <p class="text-xs text-text-white text-center mt-2">
                            {{ __('Must be JPEG, PNG or HEIC and cannot exceed 10MB.') }}
                        </p>
                        <x-ui.input-error :messages="$errors->get('front_image')" class="mt-2 flex items-center justify-center" />
                    </div>
                @else
                    <h2 class="text-base lg:text-xl font-semibold mb-8 text-left">
                        {{ __('Take a photo of ultimate beneficial owner ID') }}
                    </h2>

                    <div class="px-8">
                        <div class="flex justify-center mb-6 relative">
                            {{-- Image Upload Loading Overlay --}}
                            <div wire:loading.flex wire:target="front_image">
                                <div
                                    class="absolute inset-0 z-10 flex items-center justify-center bg-bg-secondary/60 rounded-2xl backdrop-blur-[2px]">
                                    <div class="flex flex-col items-center">
                                        <div
                                            class="animate-spin rounded-full h-12 w-12 border-4 border-zinc-500 border-t-white mb-3">
                                        </div>
                                        <span class="text-white font-medium">{{ __('Uploading image...') }}</span>
                                    </div>
                                </div>
                            </div>

                            @if ($front_image)
                                <div class="w-[100px] h-[100px] sm:w-[510px] sm:h-[382px]">
                                    <img src="{{ $front_image->temporaryUrl() }}" alt="UBO ID Preview"
                                        class="mx-auto w-full h-full object-cover rounded-xl"
                                        onerror="this.style.display='none'; this.nextElementSibling.style.display='flex'">
                                </div>
                            @else
                                <img src="{{ asset('assets/images/verfy.png') }}" alt="" class="mx-auto">
                            @endif
                        </div>

                        <ul class="space-y-2 font-lato mb-6">
                            <li class="flex items-start">
                                <span class="mr-2">•</span>
                                <span>
                                    {{ __('Accepted documents: **Driver\'s license, Government issued ID or Passport, international student ID.**') }}
                                </span>
                            </li>
                            <li class="flex items-start">
                                <span class="mr-2">•</span>
                                <span>
                                    {{ __('Make sure personal details on the document are **clearly visible and easy to read.**') }}
                                </span>
                            </li>
                        </ul>

                        <div class="flex items-center max-w-88 mx-auto rounded-lg overflow-hidden">
                            <input type="file" wire:model="front_image" accept="image/*" class="hidden"
                                id="front_image">

                            <label for="front_image" wire:loading.class="opacity-50 cursor-not-allowed"
                                wire:target="front_image"
                                 class="shrink-0 px-6 py-2 bg-zinc-600 border border-zinc-500 text-zinc-950 font-semibold rounded-3xl hover:text-primary hover:bg-transparent  cursor-pointer transition duration-150 ease-in-out">

                                {{ __('Choose file') }}
                            </label>

                            <div
                                class="p-2 text-sm text-primary-100 truncate w-full bg-bg-light-black shadow rounded-sm ml-2 text-left">
                                @if (isset($front_image))
                                    {{ $front_image->getClientOriginalName() }}
                                @else
                                    {{ __('No file chosen') }}
                                @endif
                            </div>
                        </div>
                        <p class="text-xs text-text-white text-center mt-2">
                            {{ __('Must be JPEG, PNG or HEIC and cannot exceed 10MB.') }}
                        </p>

                        {{-- <x-ui.input-error classname="flex justify-center items-center" :messages="$errors->get('front_image')" class="mt-2" /> --}}

                        @error('front_image')
                            <span class="text-xs text-pink-500 text-center mt-2">{{ $message }}</span>
                        @enderror
                    </div>
                @endif
            </div>

            <div class="flex gap-4 justify-center mt-5! sm:mt-10!">
                <div class="flex justify-center">
                    <x-ui.button type="button" wire:click.prevent="previousStep" wire:navigate variant="secondary"
                        class="w-auto py-2!">
                        {{ __('Back') }}
                    </x-ui.button>
                </div>
                <div class="flex justify-center">
                    <x-ui.button type="submit" wire:click="nextStep" wire:loading.attr="disabled"
                        wire:target="front_image" class="w-auto py-2! disabled:opacity-70 disabled:cursor-not-allowed">
                        {{-- Show 'Next' by default, show 'Wait' while uploading --}}
                        <span wire:loading.remove wire:target="front_image,nextStep" class="group-hover:text-primary!">{{ __('Next') }}</span>
                        <span wire:loading wire:target="front_image,nextStep">{{ __('Please wait...') }}</span>
                    </x-ui.button>
                </div>
            </div>
        </div>
    </div>
</div>
