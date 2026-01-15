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
                    {{ __('Step') }} <span>6</span>/<span>6</span>
                </div>
            </div>

            <div class="p-5 lg:px-15 lg:py-10 bg-bg-info  rounded-2xl">


                @if (!$accountType == 0)
                    <div>
                        <h2 class="text-base lg:text-2xl leading-2 font-semibold  mb-4 text-left">
                            {{ __('Take a selfie with your ID') }}</h2>
                        <div class="flex justify-center mb-6 relative">
                            {{-- Image Upload Loading Overlay --}}
                            <div wire:loading wire:target="selfie_image"
                                class="absolute inset-0 z-10 flex items-center justify-center bg-bg-secondary  rounded-2xl backdrop-blur-[2px]">
                                <div class="flex flex-col items-center">
                                    <div
                                        class="animate-spin rounded-full h-12 w-12 border-4 border-zinc-500 border-t-white mb-3">
                                    </div>
                                    <span class="text-white font-medium">{{ __('Uploading image... 100%') }}</span>
                                </div>
                            </div>
                            @if ($selfie_image)
                                <div class="w-[100px] h-[100px] sm:w-[510px] sm:h-[382px]">
                                    <img src="{{ $selfie_image->temporaryUrl() }}" alt="Selfie with ID illustration"
                                        class="mx-auto w-full h-full object-cover"
                                        onerror="this.style.display='none'; this.nextElementSibling.style.display='flex'">
                                </div>
                            @else
                                <div class="w-[100px] h-[100px] sm:w-[510px] sm:h-[382px]">
                                    <img src="{{ asset('assets/images/Frame-2147226340.png') }}"
                                        alt="Selfie with ID illustration" class="mx-auto"
                                        onerror="this.style.display='none'; this.nextElementSibling.style.display='flex'">
                                </div>
                            @endif
                        </div>

                        {{-- @if ($selfie_image)
                                <img src="{{ $selfie_image->temporaryUrl() }}" alt="Preview"
                                    class="w-32 h-32 object-cover">
                            @endif --}}



                        <ul class="space-y-3 text-gray-700 mb-6 max-w-md mx-auto">
                            <li class="flex items-start">
                                <span class="mr-2">•</span>
                                <span
                                    class="text=text-white font-normal text-xl text-left">{{ __('Please upload a photo where you are holding your ID next to your face.') }}</span>
                            </li>
                            <li class="flex items-start">
                                <span class="mr-2">•</span>
                                <span
                                    class="text=text-white font-normal text-xl text-left">{{ __('Both your face and ID document must be clearly visible.') }}</span>
                            </li>
                        </ul>

                        <div class="flex items-center max-w-md mx-auto  rounded-lg overflow-hidden">
                            <input type="file" wire:model.live="selfie_image" accept="image/*" class="hidden"
                                id="selfie_image">
                            <label for="selfie_image"
                                class="shrink-0 px-6 py-2 bg-zinc-600 rounded-3xl text-white font-semibold hover:bg-gray-800 cursor-pointer transition duration-150">
                                {{ __('Choose file') }}
                            </label>

                            <div
                                class="p-2 text-sm w-full text-primary-100 truncate  bg-bg-light-black shadow rounded-sm ml-2 text-left">
                                @if ($selfie_image)
                                    {{ $selfie_image->getClientOriginalName() }}
                                @else
                                    {{ __('No file selected') }}
                                @endif
                            </div>
                        </div>
                    </div>

                    <p class="text-xs text-center text-gray-500 mt-3">
                        {{ __('Must be JPEG, PNG or HEIC and cannot exceed 10MB.') }}
                    </p>

                    @error('selfieWithId')
                        <p class="text-pink-500 text-sm text-center mt-2">{{ $message }}</p>
                    @enderror
                @else
                    {{-- <h2 class="text-base lg:text-2xl font-bold text-left mb-6">{{ __('Upload company documents') }}
                    </h2>

                    <div class="max-w-2xl mx-auto mb-8">
                        <p class="text-gray-600 mb-6 text-center">
                            {{ __('Please upload documents to prove that the individual who submitted the ID is an owner of your company.') }}
                        </p>

                        <div class="bg-gray-50 rounded-lg p-6 mb-6">
                            <ol class="space-y-3 text-sm text-gray-700">
                                <li>{{ __('1. Proof of ownership (an extract from a corporate registry or shareholder register) (required)') }}
                                </li>
                                <li>{{ __('2. Articles of Association (required)') }}</li>
                                <li>{{ __('3. Proof of registered company address (utility bill or bank statement, not older than 3 months) (required)') }}
                                </li>
                                <li>{{ __('4. Misc docs (corporate structure, incorporation document, misc. company documents, etc) (optional)') }}
                                </li>
                            </ol>
                        </div>

                        <div class="bg-zinc-50 border-l-4 border-zinc-500 p-4 mb-6">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-zinc-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-zinc-700">
                                        <strong>{{ __('Note:') }}</strong>
                                        {{ __(' If your company\'s owner is another company, you will need to upload documents for both entities and the corporate structure, leading to the UBO') }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <input type="file" wire:model="selfie_image" accept=".jpg,.jpeg,.png,.heic,.pdf,.docx"
                                class="hidden" id="selfie_image">
                            <label for="selfie_image"
                                class="shrink-0 px-6 py-2 bg-zinc-600 flex justify-center w-40 rounded-lg mx-auto text-text-white font-semibold hover:bg-gray-800 cursor-pointer transition duration-150">
                                {{ __('Choose file') }}
                            </label>
                            @if (!empty($selfie_image))
                                <div class="mt-3 space-y-2">
                                    <p class="text-green-600 text-sm">✓ File :
                                        {{ $selfie_image->getClientOriginalName() }}</p>
                                </div>
                            @else
                            @endif
                        </div>

                        <p class="text-xs text-text-white text-center">
                            {{ __('Must be JPEG, PNG, HEIC, PDF, DOCX and cannot exceed 10MB.') }}
                        </p>
                    </div> --}}
                    <div>
                        <h2 class="text-base lg:text-2xl leading-2 font-semibold  mb-4 text-left">
                            {{ __('Take a selfie with your ID') }}</h2>

                        <div class="flex justify-center mb-6 relative">
                            {{-- Image Upload Loading Overlay --}}
                            <div wire:loading.flex wire:target="selfie_image">
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
                            @if ($selfie_image)
                                <div class="w-[100px] h-[100px] sm:w-[510px] sm:h-[382px]">
                                    <img src="{{ $selfie_image->temporaryUrl() }}" alt="Selfie with ID illustration"
                                        class="mx-auto w-full h-full object-cover"
                                        onerror="this.style.display='none'; this.nextElementSibling.style.display='flex'">
                                </div>
                            @else
                                <img src="{{ asset('assets/images/Frame-2147226340.png') }}"
                                    alt="Selfie with ID illustration" class="mx-auto"
                                    onerror="this.style.display='none'; this.nextElementSibling.style.display='flex'">
                            @endif
                        </div>

                        {{-- @if ($selfie_image)
                                <img src="{{ $selfie_image->temporaryUrl() }}" alt="Preview"
                                    class="w-32 h-32 object-cover">
                            @endif --}}



                        <ul class="space-y-3 text-gray-700 mb-6 max-w-md mx-auto">
                            <li class="flex items-start">
                                <span class="mr-2">•</span>
                                <span
                                    class="text=text-white font-normal text-xl text-left">{{ __('Please upload a photo where you are holding your ID next to your face.') }}</span>
                            </li>
                            <li class="flex items-start">
                                <span class="mr-2">•</span>
                                <span
                                    class="text=text-white font-normal text-xl text-left">{{ __('Both your face and ID document must be clearly visible.') }}</span>
                            </li>
                        </ul>

                        <div class="flex items-center max-w-md mx-auto  rounded-lg overflow-hidden">
                            <input type="file" wire:model.live="selfie_image" accept="image/*" class="hidden"
                                id="selfie_image">
                            <label for="selfie_image"
                                class="shrink-0 px-6 py-2 bg-zinc-600 rounded-3xl text-white font-semibold hover:bg-gray-800 cursor-pointer transition duration-150">
                                {{ __('Choose file') }}
                            </label>

                            <div
                                class="p-2 text-sm w-full text-primary-100 truncate  bg-bg-light-black shadow rounded-sm ml-2 text-left">
                                @if ($selfie_image)
                                    {{ $selfie_image->getClientOriginalName() }}
                                @else
                                    {{ __('No file selected') }}
                                @endif
                            </div>
                        </div>
                    </div>

                    <p class="text-xs text-center text-gray-500 mt-3">
                        {{ __('Must be JPEG, PNG or HEIC and cannot exceed 10MB.') }}
                    </p>

                    @error('selfieWithId')
                        <p class="text-pink-500 text-sm text-center mt-2">{{ $message }}</p>
                    @enderror
                @endif
            </div>
            <div class="flex gap-4 justify-center mt-5! sm:mt-10!">
                <div class="flex justify-center">
                    <x-ui.button type="submit" wire:click.prevent="previousStep" wire:navigate variant="secondary"
                        class="w-auto py-2!">
                        {{ __('Back') }}
                    </x-ui.button>
                </div>
                <div class="flex justify-center">
                    <x-ui.button type="submit" wire:click="submit" wire:loading.attr="disabled"
                        wire:target="selfie_image" class="w-auto py-2! disabled:opacity-70 disabled:cursor-not-allowed">
                        <span wire:loading.remove wire:target="selfie_image">{{ __('Submit') }}</span>
                        <span wire:loading wire:target="selfie_image">{{ __('Please wait...') }}</span>
                    </x-ui.button>
                </div>
            </div>

        </div>
    </div>
</div>
