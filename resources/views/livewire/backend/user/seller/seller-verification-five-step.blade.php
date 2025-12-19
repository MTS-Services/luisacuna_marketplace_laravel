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
                    Step <span>5</span>/<span>6</span>
                </div>
            </div>

            <div class="p-5 lg:px-15 lg:py-10 bg-bg-info rounded-2xl">

                @if ($accountType == 0)
                    <h2 class="text-base lg:text-xl font-semibold  mb-8 text-left">
                        {{ __('Take a photo of your ID and swapy.gg in
                                                background') }}
                    </h2>

                    <div class="px-8 text-left">
                        <div class="flex justify-center mb-4">
                            <img src="{{ asset('assets/images/verfy.png') }}" alt="" class="mx-auto">
                        </div>

                        <ul class="space-y-2  font-lato mb-6 ">
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

                        <div class="flex items-center  max-w-88 mx-auto  rounded-lg overflow-hidden">
                            <input type="file" wire:model="front_image" accept="image/*" class="hidden"
                                id="idDocument">

                            <label for="idDocument"
                                class="shrink-0 px-6 py-1.5 bg-zinc-600 text-white font-semibold rounded-3xl hover:bg-gray-800 cursor-pointer transition duration-150 ease-in-out">
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
                        <x-ui.input-error :messages="$errors->get('front_image')" class="mt-2" />
                    </div>
                @else
                    <h2 class="text-base lg:text-xl font-semibold  mb-8 text-left">
                        Take a photo of ultimate beneficial owner ID
                    </h2>

                    <div class="px-8">
                        {{-- Placeholder for the ID illustration image from the provided screenshot --}}
                        <div class="flex justify-center mb-6">
                            <img src="{{ asset('assets/images/ubo-verification-image.webp') }}"
                                alt="Ultimate beneficial owner ID illustration" class="mx-auto">
                        </div>

                        <ul class="space-y-2 font-lato mb-6">
                            <li class="flex items-start">
                                <span class="mr-2">•</span>
                                <span>
                                    Accepted documents: **Driver's license, Government issued ID or Passport,
                                    international student ID.**
                                </span>
                            </li>
                            <li class="flex items-start">
                                <span class="mr-2">•</span>
                                <span>
                                    Make sure personal details on the document are **clearly visible and easy to
                                    read.**
                                </span>
                            </li>
                        </ul>

                        <div
                            class="flex items-center max-w-88 mx-auto border border-zinc-100 rounded-lg overflow-hidden">
                            <input type="file" wire:model="front_image" accept="image/*" class="hidden"
                                id="front_image">

                            <label for="front_image"
                                class="shrink-0 px-6 py-1.5 bg-zinc-600 text-white font-semibold rounded-3xl hover:bg-gray-800 cursor-pointer transition duration-150 ease-in-out">
                                Choose file
                            </label>

                            <div
                                class="p-2 text-sm text-primary-100 truncate w-full bg-bg-light-black shadow rounded-sm ml-2 text-left">
                                @if (isset($front_image))
                                    {{ $front_image->getClientOriginalName() }}
                                @else
                                    No file selected
                                @endif
                            </div>
                        </div>
                        <p class="text-xs text-text-white text-center mt-2">
                            Must be JPEG, PNG or HEIC and cannot exceed 10MB.
                        </p>
                        @error('ultimateBeneficialOwnerIdDocument')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                @endif
            </div>
            <div>

            </div>
            <div class="flex justify-center space-x-4 pt-10">
                {{-- <a wire:click.prevent="previousStep" wire:navigate
                    class="px-8 py-2 cursor-pointer text-text-white  rounded-lg hover:bg-gray-50">
                    BACK
                </a>
                <button wire:click="nextStep" class="px-8 py-2 bg-zinc-600 hover:bg-zinc-700 text-white rounded-lg ">
                    NEXT
                </button> --}}
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
