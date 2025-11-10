<div class="min-h-[70vh] bg-bg-secondary py-12 px-4">
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

        {{-- Category Selection Page --}}
        @if ($showCategoryPage)
            {{-- @if ($showCategoryPage) --}}
            <div class="w-2xl mx-auto">
                <h1 class="text-3xl font-bold text-center text-text-white mb-2">Start selling</h1>
                <h2 class="text-xl text-center text-text-white/60 mb-8">Choose category</h2>

                <div class="space-y-4">
                    <button wire:click="selectCategory('currency')"
                        class="w-full flex items-center justify-between p-4 bg-bg-primary hover:bg-bg-hover   transition">
                        <div class="flex items-center space-x-3">
                            <span class="text-3xl">💱</span>
                            <span class="text-lg font-semibold">Currency</span>
                        </div>
                        <x-phosphor-caret-right class="w-6 h-6 fill-zinc-500" />
                    </button>

                    <button wire:click="selectCategory('accounts')"
                        class="w-full flex items-center justify-between p-4 bg-bg-primary hover:bg-bg-hover   transition">
                        <div class="flex items-center space-x-3">
                            <span class="text-3xl">🏆</span>
                            <span class="text-lg font-semibold">Accounts</span>
                        </div>
                        <x-phosphor-caret-right class="w-6 h-6 fill-zinc-500" />
                    </button>

                    <button disabled
                        class="w-full flex items-center justify-between p-4 bg-gray-100   opacity-50 cursor-not-allowed!">
                        <div class="flex items-center space-x-3">
                            <span class="text-3xl grayscale">💰</span>
                            <span class="text-lg font-semibold text-gray-400">Top Ups</span>
                        </div>
                        <x-phosphor-caret-right class="w-6 h-6 fill-zinc-500" />
                    </button>

                    <button wire:click="selectCategory('items')"
                        class="w-full flex items-center justify-between p-4 bg-bg-primary hover:bg-bg-hover   transition">
                        <div class="flex items-center space-x-3">
                            <span class="text-3xl">🔑</span>
                            <span class="text-lg font-semibold">Items</span>
                        </div>
                        <x-phosphor-caret-right class="w-6 h-6 fill-zinc-500" />
                    </button>

                    <button wire:click="selectCategory('boosting')"
                        class="w-full flex items-center justify-between p-4 bg-bg-primary hover:bg-bg-hover   transition">
                        <div class="flex items-center space-x-3">
                            <span class="text-3xl">🔥</span>
                            <span class="text-lg font-semibold">Boosting</span>
                        </div>
                        <x-phosphor-caret-right class="w-6 h-6 fill-zinc-500" />
                    </button>

                    <button disabled
                        class="w-full flex items-center justify-between p-4 bg-gray-100   opacity-50 cursor-not-allowed!">
                        <div class="flex items-center space-x-3">
                            <span class="text-3xl grayscale">🎁</span>
                            <span class="text-lg font-semibold text-gray-400">Gift Card</span>
                        </div>
                        <x-phosphor-caret-right class="w-6 h-6 fill-zinc-500" />
                    </button>

                    <button wire:click="selectCategory('steam_games')"
                        class="w-full flex items-center justify-between p-4 bg-bg-primary hover:bg-bg-hover   transition">
                        <div class="flex items-center space-x-3">
                            <span class="text-lg font-semibold">Steam Games</span>
                        </div>
                        <x-phosphor-caret-right class="w-6 h-6 fill-zinc-500" />
                    </button>

                    <button wire:click="selectCategory('bulk_upload')"
                        class="w-full flex items-center justify-between p-4 bg-bg-primary hover:bg-bg-hover   transition">
                        <div class="flex items-center space-x-3">
                            <span class="text-3xl">⬆️</span>
                            <span class="text-lg font-semibold">Bulk Upload</span>
                        </div>
                        <x-phosphor-caret-right class="w-6 h-6 fill-zinc-500" />
                    </button>
                </div>
            </div>

            {{-- Verification Required Page --}}
        @elseif($currentStep == 0)
            <div class="text-center">
                <div class="mb-6">
                    <div class="mx-auto w-32 h-32 flex items-center justify-center">
                        <span class="text-8xl">🔍</span>
                    </div>
                </div>

                <h2 class="text-2xl font-bold dark:text-text-white text-zinc-500/80 mb-4">Seller verification required
                </h2>

                <p class="dark:text-text-white text-zinc-500/50 mb-2">To sell currencies, please verify your identity
                    first.</p>
                <p class="dark:text-text-white text-zinc-500/50 mb-8">Our 24/7 support team will review your ID in up to
                    15 minutes.</p>

                <button class="bg-bg-primary rounded-lg p-6 mb-6 " wire:click="startVerification">
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 rounded-full flex items-center justify-center">
                            <img src="{{ asset('assets/images/verification.svg') }}" alt="">
                        </div>
                        <div class="flex-1 text-left">
                            <p class="font-semibold">Seller Verification</p>
                            <span class="inline-block px-3 py-1 bg-pink-500 text-white text-sm rounded-full">Documents
                                required</span>
                        </div>
                        <x-phosphor-caret-right class="w-6 h-6 fill-zinc-500" />
                    </div>
                </button>


                <a href="#" class="block mt-4 text-zinc-600/80 hover:underline">Why do I need to verify my ID?</a>
            </div>

            {{-- Step 1: Individual or Company --}}
        @elseif($currentStep == 1)
            <div>
                <div class="text-center mb-8">
                    <div class="flex items-center justify-center mb-2">
                        <span class="text-zinc-500 text-2xl">✓</span>
                        <h3 class="text-lg text-text-white font-semibold ml-2">Seller ID Verification</h3>
                    </div>
                    <p class="text-text-white">Step 1/5</p>
                </div>
                <div class="bg-bg-primary max-w-2xl mx-auto py-6 mb-4">
                    <h2 class="text-lg font-bold text-center mb-4">
                        Will you sell on Eldorado as an individual or as a <br> company?
                    </h2>

                    <div class="flex flex-col items-center justify-center space-y-3">
                        <label class="flex items-center cursor-pointer">
                            <input type="radio" wire:model="accountType" value="individual"
                                class="w-5 h-5 text-zinc-600">
                            <span class="ml-3 text-lg">Individual</span>
                        </label>

                        <label class="flex items-center cursor-pointer">
                            <input type="radio" wire:model="accountType" value="company"
                                class="w-5 h-5 text-zinc-600">
                            <span class="ml-3 text-lg">Company</span>
                        </label>
                    </div>
                </div>

                <div class="flex justify-center space-x-4">
                    <a href="{{ route('home') }}" class="px-8 py-2 text-text-white  rounded-lg hover:bg-gray-50">
                        BACK
                    </a>
                    <button wire:click="nextStep"
                        class="px-8 py-2 bg-zinc-600 hover:bg-zinc-700 text-white rounded-lg ">
                        NEXT
                    </button>
                </div>

            </div>

            {{-- Step 2: Select Categories --}}
        @elseif($currentStep == 2)
            <div>
                <div class="text-center mb-8">
                    <div class="flex items-center justify-center mb-2">
                        <span class="text-zinc-500 text-2xl">✓</span>
                        <h3 class="text-lg font-semibold ml-2">Seller ID verification</h3>
                    </div>
                    <p class="text-text-white">Step 1/6</p>
                </div>
                <div class="bg-bg-primary max-w-2xl mx-auto py-4 px-8 mb-4">
                    <h2 class="text-2xl font-bold text-center mb-2">Select the categories you'll be <br> selling in:
                    </h2>

                    <div class="space-y-1 mb-2">
                        @foreach ([
                            'currency' => 'Currency',
                            'accounts' => 'Accounts',
                            'items' => 'Items',
                            'top_ups' => 'Top Ups',
                            'boosting' => 'Boosting',
                            'gift_cards' => 'Gift Cards',
                        ] as $value => $label)
                            <label class="flex items-center cursor-pointer">
                                <input type="checkbox" wire:model="selectedCategories" value="{{ $value }}"
                                    class="w-5 h-5 text-zinc-600 bg-bg-white! border-zinc-100 rounded transition-all duration-200 hover:scale-110 hover:bg-zinc-500 focus:ring-zinc-500">
                                <span class="ml-3 text-zinc-900 dark:text-zinc-100">{{ $label }}</span>
                            </label>
                        @endforeach
                    </div>

                </div>
                @error('selectedCategories')
                    <p class="text-red-500 text-center mb-4">{{ $message }}</p>
                @enderror

                <div class="flex justify-center space-x-4">
                    <button wire:click="previousStep" class="px-8 py-2  hover:bg-zinc-50 rounded-lg">
                        BACK
                    </button>
                    <button wire:click="nextStep" class="px-8 py-2 text-white rounded-lg transition"
                        wire:loading.attr="disabled" wire:target="nextStep"
                        wire:attr.disabled="!@json(count($selectedCategories) > 0)"
                        :class="{
                            'bg-zinc-600 hover:bg-zinc-700': $wire.selectedCategories.length > 0,
                            'bg-zinc-200 cursor-not-allowed!': $wire.selectedCategories.length === 0
                        }">
                        NEXT
                    </button>
                </div>
            </div>

            {{-- Step 3: Selling Experience --}}
        @elseif($currentStep == 3)
            <div>
                <div class="text-center mb-8">
                    <div class="flex items-center justify-center mb-2">
                        <span class="text-zinc-500 text-2xl">✓</span>
                        <h3 class="text-lg font-semibold ml-2">Seller ID verification</h3>
                    </div>
                    <p class="text-text-white">Step 2/6</p>
                </div>
                <div class="bg-bg-primary max-w-2xl mx-auto py-4 px-8 mb-4">
                    <h2 class="text-2xl font-bold text-center mb-8">Selling experience:</h2>
                    <div class="flex flex-col items-start space-y-3">
                        <label class="flex items-center cursor-pointer">
                            <input type="radio" wire:model="sellingExperience" value="new"
                                class="w-5 h-5 text-zinc-600">
                            <span class="ml-3 text-base">New seller (this is my first selling)</span>
                        </label>

                        <label class="flex items-center cursor-pointer">
                            <input type="radio" wire:model="sellingExperience" value="experienced"
                                class="w-5 h-5 text-zinc-600">
                            <span class="ml-3 text-base">Experienced seller (I've worked on other platforms)</span>
                        </label>
                    </div>
                </div>

                <div class="flex justify-center space-x-4">
                    <button wire:click="previousStep"
                        class="px-8 py-2  text-text-white rounded-lg dark:bg-zinc-800 hover:bg-zinc-50">
                        BACK
                    </button>
                    <button wire:click="nextStep"
                        class="px-8 py-2 bg-zinc-600 hover:bg-zinc-700 text-white rounded-lg ">
                        NEXT
                    </button>
                </div>
            </div>

            {{-- Step 4: Personal/Company Details --}}
        @elseif($currentStep == 4)
            <div>
                <div class="text-center mb-8">
                    <div class="flex items-center justify-center mb-2">
                        <span class="text-zinc-500 text-2xl">✓</span>
                        <h3 class="text-lg font-semibold ml-2">Seller ID verification</h3>
                    </div>
                    <p class="text-text-white">Step 3/6</p>
                </div>

                @if ($accountType == 'individual')
                    <div class="dark:bg-bg-primary bg-bg-white max-w-2xl mx-auto py-4 px-8 mb-6">
                        <h2 class="text-2xl font-semibold text-center font-lato mb-8">Enter your details</h2>

                        <div class="max-w-md mx-auto space-y-4 mb-8">
                            <div>
                                <x-ui.label class="mb-2">First name</x-ui.label>
                                <x-ui.input type="text" wire:model="firstName" placeholder="First name" />
                                <x-ui.input-error :messages="$errors->get('firstName')" />
                            </div>

                            <div>
                                <x-ui.label class="mb-2">Middle name (if present)</x-ui.label>
                                <x-ui.input type="text" wire:model="middleName" placeholder="Middle name" />
                                <x-ui.input-error :messages="$errors->get('middleName')" />
                            </div>

                            <div>
                                <x-ui.label class="mb-2">Last name</x-ui.label>
                                <x-ui.input type="text" wire:model="lastName" placeholder="Last name" />
                                <x-ui.input-error :messages="$errors->get('lastName')" />
                            </div>

                            <div>
                                <x-ui.label class="mb-2">Date of birth:</x-ui.label>
                                <div class="grid grid-cols-3 gap-3">
                                    <x-ui.select wire:model="birthYear" class="p-3 border rounded-lg">
                                        <option value="">Year</option>
                                        @for ($year = date('Y') - 18; $year >= 1950; $year--)
                                            <option value="{{ $year }}">{{ $year }}</option>
                                        @endfor
                                    </x-ui.select>
                                    <x-ui.select wire:model="birthMonth" class="p-3 border rounded-lg">
                                        <option value="">Month</option>
                                        @for ($month = 1; $month <= 12; $month++)
                                            <option value="{{ str_pad($month, 2, '0', STR_PAD_LEFT) }}">
                                                {{ $month }}</option>
                                        @endfor
                                    </x-ui.select>
                                    <x-ui.select wire:model="birthDay" class="p-3 border rounded-lg">
                                        <option value="">Day</option>
                                        @for ($day = 1; $day <= 31; $day++)
                                            <option value="{{ str_pad($day, 2, '0', STR_PAD_LEFT) }}">
                                                {{ $day }}</option>
                                        @endfor
                                    </x-ui.select>
                                </div>
                                <x-ui.input-error :messages="$errors->get('birthYear')" />
                                <x-ui.input-error :messages="$errors->get('birthMonth')" />
                                <x-ui.input-error :messages="$errors->get('birthDay')" />
                            </div>

                            <div>
                                <x-ui.label class="mb-2">Nationality:</x-ui.label>
                                <x-ui.select wire:model="nationality" class="w-full p-3 border rounded-lg">
                                    <option value="">Select nationality</option>
                                    <option value="BD">Bangladesh</option>
                                    <option value="US">United States</option>
                                    <option value="UK">United Kingdom</option>
                                    <option value="IN">India</option>
                                </x-ui.select>
                                <x-ui.input-error :messages="$errors->get('nationality')" />
                            </div>

                            <div>
                                <x-ui.label class="mb-2">Street address</x-ui.label>
                                <x-ui.input type="text" wire:model="streetAddress"
                                    class="w-full p-3 border rounded-lg" placeholder="Street address" />
                                <x-ui.input-error :messages="$errors->get('streetAddress')" />
                            </div>

                            <div>
                                <x-ui.label class="mb-2">City</x-ui.label>
                                <x-ui.input type="text" wire:model="city" class="w-full p-3 border rounded-lg"
                                    placeholder="City" />
                                <x-ui.input-error :messages="$errors->get('city')" />
                            </div>

                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <x-ui.label class="mb-2">Country</x-ui.label>
                                    <x-ui.select wire:model="country" class="w-full p-3 border rounded-lg">
                                        <option value="">Select country</option>
                                        <option value="BD">Bangladesh</option>
                                        <option value="US">United States</option>
                                        <option value="UK">United Kingdom</option>
                                    </x-ui.select>
                                    <x-ui.input-error :messages="$errors->get('country')" />
                                </div>
                                <div>
                                    <x-ui.label class="mb-2">Postal code</x-ui.label>
                                    <x-ui.input type="text" wire:model="postalCode"
                                        class="w-full p-3 border rounded-lg" placeholder="Postal code" />
                                    <x-ui.input-error :messages="$errors->get('postalCode')" />
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="dark:bg-bg-primary bg-bg-white max-w-2xl mx-auto py-4 px-8 mb-6">
                        <h2 class="text-2xl font-bold text-center mb-8">Enter your company details</h2>

                        <div class="max-w-md mx-auto space-y-4 mb-8">
                            <div>
                                <x-ui.label class="mb-2">Company name</x-ui.label>
                                <x-ui.input type="text" wire:model="companyName"
                                    class="w-full p-3 border rounded-lg" placeholder="Company name" />
                                <x-ui.input-error :messages="$errors->get('companyName')" />
                            </div>

                            <div>
                                <x-ui.label class="mb-2">Company code/ID</x-ui.label>
                                <x-ui.input type="text" wire:model="companyCode"
                                    class="w-full p-3 border rounded-lg" placeholder="Company code/ID" />
                                <x-ui.input-error :messages="$errors->get('companyCode')" />
                            </div>

                            <div>
                                <x-ui.label class="mb-2">VAT/Tax number (optional)</x-ui.label>
                                <x-ui.input type="text" wire:model="vatNumber"
                                    class="w-full p-3 border rounded-lg" placeholder="VAT/Tax number (optional)" />
                                <x-ui.input-error :messages="$errors->get('vatNumber')" />
                            </div>

                            <div>
                                <x-ui.label class="mb-2">Street address</x-ui.label>
                                <x-ui.input type="text" wire:model="companyStreetAddress"
                                    class="w-full p-3 border rounded-lg" placeholder="Street address" />
                                <x-ui.input-error :messages="$errors->get('companyStreetAddress')" />
                            </div>

                            <div>
                                <x-ui.label class="mb-2">City</x-ui.label>
                                <x-ui.input type="text" wire:model="companyCity"
                                    class="w-full p-3 border rounded-lg" placeholder="City" />
                                <x-ui.input-error :messages="$errors->get('companyCity')" />
                            </div>

                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <x-ui.label class="mb-2">Country</x-ui.label>
                                    <x-ui.select wire:model="companyCountry" class="w-full p-3 border rounded-lg">
                                        <option value="">Select country</option>
                                        <option value="BD">Bangladesh</option>
                                        <option value="US">United States</option>
                                    </x-ui.select>
                                    <x-ui.input-error :messages="$errors->get('companyCountry')" />
                                </div>
                                <div>
                                    <x-ui.label class="mb-2">Postal code</x-ui.label>
                                    <x-ui.input type="text" wire:model="companyPostalCode"
                                        class="w-full p-3 border rounded-lg" placeholder="Postal code" />
                                    <x-ui.input-error :messages="$errors->get('companyPostalCode')" />
                                </div>
                            </div>
                        </div>
                    </div>
                @endif


                <div class="flex justify-center space-x-4">
                    <button wire:click="previousStep" class="px-8 py-2  rounded-lg hover:bg-gray-50">
                        BACK
                    </button>
                    <button wire:click="nextStep"
                        class="px-8 py-2 bg-zinc-600 text-white rounded-lg hover:bg-zinc-700">
                        NEXT STEP
                    </button>
                </div>
            </div>

            {{-- Step 5: Upload ID Document --}}
            @elseif($currentStep == 5)
            @if ($accountType === 'individual')
                <div>
                    <div class="text-center mb-8">
                        <div class="flex items-center justify-center mb-2">
                            <span class="text-zinc-500 text-2xl">✓</span>
                            <h3 class="text-lg font-semibold ml-2">Seller ID Verification</h3>
                        </div>
                        <p class="text-text-white">Step 6/7</p>
                    </div>
                    <div class="dark:bg-bg-primary bg-bg-white max-w-2xl mx-auto py-6  mb-6">
                        <h2 class="text-xl font-semibold text-center mb-8">Take a photo of your ID and eldorado.gg in
                            <br>
                            background
                        </h2>

                        <div class="px-8">
                            <div class="flex justify-center mb-4">
                                <img src="{{ asset('assets/images/verification-id-background.webp') }}"
                                    alt="" class="mx-auto">
                            </div>

                            <ul class="space-y-2  font-lato mb-6 ">
                                <li class="flex items-start">
                                    <span class="mr-2">•</span>
                                    <span class=" font-semibold">
                                        Accepted documents: Driver's license, Government issued ID or Passport,
                                        interna-tional student ID.
                                    </span>
                                </li>
                                <li class="flex items-start">
                                    <span class="mr-2 ">•</span>
                                    <span class=" font-semibold">
                                        Make sure personal details on the document are clearly visible and easy to read.
                                    </span>
                                </li>
                            </ul>

                            <div
                                class="flex items-center  max-w-88 mx-auto bg-white border border-zinc-100 rounded-lg overflow-hidden">
                                <input type="file" wire:model="idDocument" accept="image/*" class="hidden"
                                    id="idDocument">

                                <label for="idDocument"
                                    class="shrink-0 px-6 py-1.5 bg-black text-white font-semibold rounded-l-lg hover:bg-gray-800 cursor-pointer transition duration-150 ease-in-out">
                                    Choose file
                                </label>

                                <div class="p-2 text-sm text-gray-500 truncate">
                                    @if ($idDocument)
                                        {{ $idDocument->getClientOriginalName() }}
                                    @else
                                        No file selected
                                    @endif
                                </div>
                            </div>
                            <p class="text-xs text-text-white text-center mt-2">Must be JPEG, PNG or HEIC and cannot
                                exceed
                                10MB.
                            </p>
                            @error('idDocument')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>


                    <div class="flex justify-center space-x-4">
                        <button wire:click="previousStep" class="px-8 py-2 rounded-lg hover:bg-gray-50">
                            BACK
                        </button>
                        <button wire:click="nextStep"
                            class="px-8 py-2 bg-zinc-500 text-white rounded-lg hover:bg-zinc-700">
                            NEXT
                        </button>
                    </div>
                </div>
            @else
                {{-- Content for Company Account (Ultimate Beneficial Owner ID Upload) --}}
                <div>
                    {{-- The image shows 'Step 6/7' for this screen --}}
                    <div class="text-center mb-8">
                        <p class="text-text-white">Step 6/7</p>
                    </div>

                    <div class="dark:bg-bg-primary bg-bg-white max-w-2xl mx-auto py-6 mb-6">
                        <h2 class="text-xl font-semibold text-center mb-8">
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
                                class="flex items-center max-w-88 mx-auto bg-white border border-zinc-100 rounded-lg overflow-hidden">
                                <input type="file" wire:model="ultimateBeneficialOwnerIdDocument" accept="image/*"
                                    class="hidden" id="ultimateBeneficialOwnerIdDocument">

                                <label for="ultimateBeneficialOwnerIdDocument"
                                    class="shrink-0 px-6 py-1.5 bg-black text-white font-semibold rounded-l-lg hover:bg-gray-800 cursor-pointer transition duration-150 ease-in-out">
                                    Choose file
                                </label>

                                <div class="p-2 text-sm text-gray-500 truncate">
                                    @if (isset($ultimateBeneficialOwnerIdDocument))
                                        {{ $ultimateBeneficialOwnerIdDocument->getClientOriginalName() }}
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
                    </div>

                    <div class="flex justify-center space-x-4">
                        <button wire:click="previousStep" class="px-8 py-2 rounded-lg hover:bg-gray-50">
                            BACK
                        </button>
                        <button wire:click="nextStep"
                            class="px-8 py-2 bg-zinc-500 text-white rounded-lg hover:bg-zinc-700">
                            NEXT
                        </button>
                    </div>
                </div>
            @endif
            {{-- Step 6: Selfie with ID (Individual) or Company Documents --}}
        @elseif($currentStep == 6)
            @if ($accountType === 'individual')
                <div>
                    <div class="text-center mb-8">
                        <div class="flex items-center justify-center mb-2">
                            <span class="text-zinc-500 text-2xl">✓</span>
                            <h3 class="text-lg font-semibold ml-2 text-text-white">ID Verification</h3>
                        </div>
                        <p class="text-text-white">Step 6/6</p>
                    </div>

                    <div class="dark:bg-bg-primary bg-bg-white max-w-2xl mx-auto py-6 px-8 mb-6">
                        <h2 class="text-xl leading-2 font-semibold text-center mb-4">Take a selfie with your ID</h2>

                        <div class="flex justify-center mb-6">
                            <img src="{{ asset('assets/images/verification-selfie.webp') }}"
                                alt="Selfie with ID illustration" class="mx-auto"
                                onerror="this.style.display='none'; this.nextElementSibling.style.display='flex'">
                        </div>

                        <ul class="space-y-3 text-gray-700 mb-6 max-w-md mx-auto">
                            <li class="flex items-start">
                                <span class="mr-2">•</span>
                                <span>Please upload a photo where you are holding your ID next to your face.</span>
                            </li>
                            <li class="flex items-start">
                                <span class="mr-2">•</span>
                                <span>Both your face and ID document must be clearly visible.</span>
                            </li>
                        </ul>

                        <div
                            class="flex items-center max-w-md mx-auto bg-white border border-zinc-200 rounded-lg overflow-hidden">
                            <input type="file" wire:model="selfieWithId" accept="image/*" class="hidden"
                                id="selfieWithId">

                            <label for="selfieWithId"
                                class="shrink-0 px-6 py-2 bg-black text-white font-semibold hover:bg-gray-800 cursor-pointer transition duration-150">
                                Choose file
                            </label>
                        </div>

                        <p class="text-xs text-center text-gray-500 mt-3">
                            Must be JPEG, PNG or HEIC and cannot exceed 10MB.
                        </p>

                        @error('selfieWithId')
                            <p class="text-red-500 text-sm text-center mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-center space-x-4">
                        <button wire:click="previousStep"
                            class="px-8 py-2 text-text-white rounded-lg hover:bg-gray-50">
                            BACK
                        </button>
                        <button wire:click="submit" class="px-8 py-2 bg-zinc-500  rounded-lg hover:bg-zinc-700"
                            wire:loading.attr="disabled">
                            <span wire:loading.remove wire:target="submit" class="text-white">SUBMIT DOCUMENTS</span>
                            <span wire:loading wire:target="submit">Submitting...</span>
                        </button>
                    </div>
                </div>
            @else
                {{-- Step 6: Company Documents Upload --}}
                <div>
                    <div class="text-center mb-8">
                        <div class="flex items-center justify-center mb-2">
                            <span class="text-zinc-500 text-2xl">✓</span>
                            <h3 class="text-lg font-semibold ml-2">Seller ID Verification</h3>
                        </div>
                        <p class="text-text-white">Step 7/7</p>
                    </div>
                    <div class="dark:bg-bg-primary bg-bg-white max-w-2xl mx-auto py-6 px-8 mb-6">
                        <h2 class="text-2xl font-bold text-center mb-6">Upload company documents</h2>

                        <div class="max-w-2xl mx-auto mb-8">
                            <p class="text-gray-600 mb-6 text-center">
                                Please upload documents to prove that the individual who submitted the ID is an owner of
                                your company.
                            </p>

                            <div class="bg-gray-50 rounded-lg p-6 mb-6">
                                <ol class="space-y-3 text-sm text-gray-700">
                                    <li>1. Proof of ownership (an extract from a corporate registry or shareholder
                                        register)
                                        (required)</li>
                                    <li>2. Articles of Association (required)</li>
                                    <li>3. Proof of registered company address (utility bill or bank statement, not
                                        older
                                        than 3 months) (required)</li>
                                    <li>4. Misc docs (corporate structure, incorporation document, misc. company
                                        documents,
                                        etc) (optional)</li>
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
                                            <strong>Note:</strong> If your company's owner is another company, you will
                                            need
                                            to upload documents for both entities and the corporate structure, leading
                                            to
                                            the UBO
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-4">
                                <input type="file" wire:model="companyDocuments"
                                    accept=".jpg,.jpeg,.png,.heic,.pdf,.docx" multiple class="hidden"
                                    id="companyDocuments">
                                <label for="companyDocuments"
                                    class="shrink-0 px-6 py-2 bg-black flex justify-center w-40 rounded-lg mx-auto text-white font-semibold hover:bg-gray-800 cursor-pointer transition duration-150">
                                    Choose file
                                </label>
                                @if (!empty($companyDocuments))
                                    <div class="mt-3 space-y-2">
                                        @foreach ($companyDocuments as $index => $doc)
                                            <p class="text-green-600 text-sm">✓ File {{ $index + 1 }}:
                                                {{ $doc->getClientOriginalName() }}</p>
                                        @endforeach
                                    </div>
                                @else
                                @endif
                            </div>

                            <p class="text-xs text-text-white text-center">
                                Must be JPEG, PNG, HEIC, PDF, DOCX and cannot exceed 10MB.
                            </p>
                        </div>
                    </div>

                    <div class="flex justify-center space-x-4">
                        <button wire:click="previousStep"
                            class="px-8 py-2  text-gray-700 rounded-lg hover:bg-gray-50">
                            BACK
                        </button>
                        <button wire:click="submit"
                            class="px-8 py-2 bg-zinc-500 text-white rounded-lg hover:bg-zinc-700"
                            wire:loading.attr="disabled">
                            <span wire:loading.remove wire:target="submit" class="text-white">SUBMIT</span>
                            <span wire:loading wire:target="submit">Submitting...</span>
                        </button>
                    </div>
                </div>

            @endif
        @endif
    </div>
</div>
