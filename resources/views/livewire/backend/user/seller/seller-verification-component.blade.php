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
        {{-- @if (!$showCategoryPage) --}}
            @if ($showCategoryPage)
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
                                class="w-5 h-5 text-blue-600">
                            <span class="ml-3 text-lg">Individual</span>
                        </label>

                        <label class="flex items-center cursor-pointer">
                            <input type="radio" wire:model="accountType" value="company"
                                class="w-5 h-5 text-blue-600">
                            <span class="ml-3 text-lg">Company</span>
                        </label>
                    </div>
                </div>

                <div class="flex justify-center space-x-4">
                    <a href="{{ route('home') }}" class="px-8 py-2 text-text-white  rounded-lg hover:bg-gray-50">
                        BACK
                    </a>
                    <button wire:click="nextStep" class="px-6 py-1.5 bg-black dark:bg-gray-800  text-white rounded-lg hover:bg-gray-800">
                        NEXT
                    </button>
                </div>

            </div>

            {{-- Step 2: Select Categories --}}
        @elseif($currentStep == 2)
         {{-- @elseif($showCategoryPage) --}}
            <div class="bg-white rounded-lg shadow-lg p-8">
                <div class="text-center mb-8">
                    <div class="flex items-center justify-center mb-2">
                        <span class="text-cyan-500 text-2xl">✓</span>
                        <h3 class="text-lg font-semibold ml-2">Seller ID verification</h3>
                    </div>
                    <p class="text-gray-500">Step 1/6</p>
                </div>

                <h2 class="text-2xl font-bold text-center mb-8">Select the categories you'll be selling in:</h2>

                <div class="max-w-md mx-auto space-y-3 mb-8">
                    <label class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-gray-50">
                        <input type="checkbox" wire:model="selectedCategories" value="currency"
                            class="w-5 h-5 text-blue-600 rounded">
                        <span class="ml-3">Currency</span>
                    </label>

                    <label class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-gray-50">
                        <input type="checkbox" wire:model="selectedCategories" value="accounts"
                            class="w-5 h-5 text-blue-600 rounded">
                        <span class="ml-3">Accounts</span>
                    </label>

                    <label class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-gray-50">
                        <input type="checkbox" wire:model="selectedCategories" value="items"
                            class="w-5 h-5 text-blue-600 rounded">
                        <span class="ml-3">Items</span>
                    </label>

                    <label class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-gray-50">
                        <input type="checkbox" wire:model="selectedCategories" value="top_ups"
                            class="w-5 h-5 text-blue-600 rounded">
                        <span class="ml-3">Top Ups</span>
                    </label>

                    <label class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-gray-50">
                        <input type="checkbox" wire:model="selectedCategories" value="boosting"
                            class="w-5 h-5 text-blue-600 rounded">
                        <span class="ml-3">Boosting</span>
                    </label>

                    <label class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-gray-50">
                        <input type="checkbox" wire:model="selectedCategories" value="gift_cards"
                            class="w-5 h-5 text-blue-600 rounded">
                        <span class="ml-3">Gift Cards</span>
                    </label>
                </div>

                @error('selectedCategories')
                    <p class="text-red-500 text-center mb-4">{{ $message }}</p>
                @enderror

                <div class="flex justify-center space-x-4">
                    <button wire:click="previousStep"
                        class="px-8 py-2 border border-gray-300 rounded-lg hover:bg-gray-50">
                        BACK
                    </button>
                    <button wire:click="nextStep" class="px-8 py-2 bg-black text-white rounded-lg hover:bg-gray-800">
                        NEXT
                    </button>
                </div>
            </div>

            {{-- Step 3: Selling Experience --}}
        @elseif($currentStep == 3)
            <div class="bg-white rounded-lg shadow-lg p-8">
                <div class="text-center mb-8">
                    <div class="flex items-center justify-center mb-2">
                        <span class="text-cyan-500 text-2xl">✓</span>
                        <h3 class="text-lg font-semibold ml-2">Seller ID verification</h3>
                    </div>
                    <p class="text-gray-500">Step 2/6</p>
                </div>

                <h2 class="text-2xl font-bold text-center mb-8">Selling experience:</h2>

                <div class="max-w-md mx-auto space-y-4 mb-8">
                    <label
                        class="flex items-center p-4 border-2 rounded-lg cursor-pointer {{ $sellingExperience === 'new' ? 'border-blue-500 bg-blue-50' : 'border-gray-200' }}">
                        <input type="radio" wire:model="sellingExperience" value="new"
                            class="w-5 h-5 text-blue-600">
                        <span class="ml-3 text-lg">New seller (this is my first selling)</span>
                    </label>

                    <label
                        class="flex items-center p-4 border-2 rounded-lg cursor-pointer {{ $sellingExperience === 'experienced' ? 'border-blue-500 bg-blue-50' : 'border-gray-200' }}">
                        <input type="radio" wire:model="sellingExperience" value="experienced"
                            class="w-5 h-5 text-blue-600">
                        <span class="ml-3 text-lg">Experienced seller (I've worked on other platforms)</span>
                    </label>
                </div>

                <div class="flex justify-center space-x-4">
                    <button wire:click="previousStep"
                        class="px-8 py-2 border border-gray-300 rounded-lg hover:bg-gray-50">
                        BACK
                    </button>
                    <button wire:click="nextStep" class="px-8 py-2 bg-black text-white rounded-lg hover:bg-gray-800">
                        NEXT
                    </button>
                </div>
            </div>

            {{-- Step 4: Personal/Company Details --}}
        @elseif($currentStep == 4)
            <div class="bg-white rounded-lg shadow-lg p-8">
                <div class="text-center mb-8">
                    <div class="flex items-center justify-center mb-2">
                        <span class="text-cyan-500 text-2xl">✓</span>
                        <h3 class="text-lg font-semibold ml-2">Seller ID verification</h3>
                    </div>
                    <p class="text-gray-500">Step 3/6</p>
                </div>

                @if ($accountType === 'individual')
                    <h2 class="text-2xl font-bold text-center mb-8">Enter your details</h2>

                    <div class="max-w-md mx-auto space-y-4 mb-8">
                        <div>
                            <label class="block text-sm font-semibold mb-2">First name</label>
                            <input type="text" wire:model="firstName"
                                class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-blue-500"
                                placeholder="First name">
                            @error('firstName')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold mb-2">Middle name (if present)</label>
                            <input type="text" wire:model="middleName"
                                class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-blue-500"
                                placeholder="Middle name">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold mb-2">Last name</label>
                            <input type="text" wire:model="lastName"
                                class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-blue-500"
                                placeholder="Last name">
                            @error('lastName')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold mb-2">Date of birth:</label>
                            <div class="grid grid-cols-3 gap-3">
                                <select wire:model="birthYear" class="p-3 border rounded-lg">
                                    <option value="">Year</option>
                                    @for ($year = date('Y') - 18; $year >= 1950; $year--)
                                        <option value="{{ $year }}">{{ $year }}</option>
                                    @endfor
                                </select>
                                <select wire:model="birthMonth" class="p-3 border rounded-lg">
                                    <option value="">Month</option>
                                    @for ($month = 1; $month <= 12; $month++)
                                        <option value="{{ str_pad($month, 2, '0', STR_PAD_LEFT) }}">
                                            {{ $month }}</option>
                                    @endfor
                                </select>
                                <select wire:model="birthDay" class="p-3 border rounded-lg">
                                    <option value="">Day</option>
                                    @for ($day = 1; $day <= 31; $day++)
                                        <option value="{{ str_pad($day, 2, '0', STR_PAD_LEFT) }}">{{ $day }}
                                        </option>
                                    @endfor
                                </select>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold mb-2">Nationality:</label>
                            <select wire:model="nationality" class="w-full p-3 border rounded-lg">
                                <option value="">Select nationality</option>
                                <option value="BD">Bangladesh</option>
                                <option value="US">United States</option>
                                <option value="UK">United Kingdom</option>
                                <option value="IN">India</option>
                            </select>
                            @error('nationality')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold mb-2">Street address</label>
                            <input type="text" wire:model="streetAddress" class="w-full p-3 border rounded-lg"
                                placeholder="Street address">
                            @error('streetAddress')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold mb-2">City</label>
                            <input type="text" wire:model="city" class="w-full p-3 border rounded-lg"
                                placeholder="City">
                            @error('city')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-sm font-semibold mb-2">Country</label>
                                <select wire:model="country" class="w-full p-3 border rounded-lg">
                                    <option value="">Select country</option>
                                    <option value="BD">Bangladesh</option>
                                    <option value="US">United States</option>
                                    <option value="UK">United Kingdom</option>
                                </select>
                                @error('country')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-semibold mb-2">Postal code</label>
                                <input type="text" wire:model="postalCode" class="w-full p-3 border rounded-lg"
                                    placeholder="Postal code">
                                @error('postalCode')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                @else
                    <h2 class="text-2xl font-bold text-center mb-8">Enter your company details</h2>

                    <div class="max-w-md mx-auto space-y-4 mb-8">
                        <div>
                            <label class="block text-sm font-semibold mb-2">Company name</label>
                            <input type="text" wire:model="companyName" class="w-full p-3 border rounded-lg"
                                placeholder="Company name">
                            @error('companyName')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold mb-2">Company code/ID</label>
                            <input type="text" wire:model="companyCode" class="w-full p-3 border rounded-lg"
                                placeholder="Company code/ID">
                            @error('companyCode')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold mb-2">VAT/Tax number (optional)</label>
                            <input type="text" wire:model="vatNumber" class="w-full p-3 border rounded-lg"
                                placeholder="VAT/Tax number (optional)">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold mb-2">Street address</label>
                            <input type="text" wire:model="companyStreetAddress"
                                class="w-full p-3 border rounded-lg" placeholder="Street address">
                            @error('companyStreetAddress')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold mb-2">City</label>
                            <input type="text" wire:model="companyCity" class="w-full p-3 border rounded-lg"
                                placeholder="City">
                            @error('companyCity')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-sm font-semibold mb-2">Country</label>
                                <select wire:model="companyCountry" class="w-full p-3 border rounded-lg">
                                    <option value="">Select country</option>
                                    <option value="BD">Bangladesh</option>
                                    <option value="US">United States</option>
                                </select>
                                @error('companyCountry')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-semibold mb-2">Postal code</label>
                                <input type="text" wire:model="companyPostalCode"
                                    class="w-full p-3 border rounded-lg" placeholder="Postal code">
                                @error('companyPostalCode')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                @endif

                <div class="flex justify-center space-x-4">
                    <button wire:click="previousStep"
                        class="px-8 py-2 border border-gray-300 rounded-lg hover:bg-gray-50">
                        BACK
                    </button>
                    <button wire:click="nextStep" class="px-8 py-2 bg-black text-white rounded-lg hover:bg-gray-800">
                        NEXT STEP
                    </button>
                </div>
            </div>

            {{-- Step 5: Upload ID Document --}}
        @elseif($currentStep == 5)
            <div class="bg-white rounded-lg shadow-lg p-8">
                <div class="text-center mb-8">
                    <div class="flex items-center justify-center mb-2">
                        <span class="text-cyan-500 text-2xl">✓</span>
                        <h3 class="text-lg font-semibold ml-2">Seller ID Verification</h3>
                    </div>
                    <p class="text-gray-500">Step 6/7</p>
                </div>

                <h2 class="text-2xl font-bold text-center mb-8">Take a photo of ultimate beneficial owner ID</h2>

                <div class="max-w-md mx-auto mb-8">
                    <div class="border-4 border-dashed border-yellow-300 rounded-lg p-8 mb-6">
                        <div class="text-center">
                            <div class="mb-4">
                                <span class="text-6xl">🆔</span>
                            </div>
                            <p class="text-sm font-semibold mb-1">NAME</p>
                            <p class="text-sm font-semibold mb-1">LAST NAME</p>
                            <p class="text-xs text-gray-500">1983-06-05</p>
                        </div>
                    </div>

                    <ul class="space-y-2 text-sm text-gray-600 mb-6">
                        <li>• Accepted documents: Driver's license, Government issued ID or Passport, international
                            student ID.</li>
                        <li>• Make sure personal details on the document are clearly visible and easy to read.</li>
                    </ul>

                    <div class="mb-4">
                        <input type="file" wire:model="idDocument" accept="image/*" class="hidden"
                            id="idDocument">
                        <label for="idDocument"
                            class="block w-full p-3 border-2 border-gray-300 rounded-lg text-center cursor-pointer hover:bg-gray-50">
                            <span class="text-gray-700 font-semibold">Choose file</span>
                        </label>
                        @if ($idDocument)
                            <p class="text-green-600 mt-2">✓ File selected: {{ $idDocument->getClientOriginalName() }}
                            </p>
                        @else
                            <p class="text-gray-500 mt-2">No file selected</p>
                        @endif
                    </div>

                    <p class="text-xs text-gray-500 text-center">Must be JPEG, PNG or HEIC and cannot exceed 10MB.</p>
                    @error('idDocument')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="flex justify-center space-x-4">
                    <button wire:click="previousStep"
                        class="px-8 py-2 border border-gray-300 rounded-lg hover:bg-gray-50">
                        BACK
                    </button>
                    <button wire:click="nextStep" class="px-8 py-2 bg-black text-white rounded-lg hover:bg-gray-800">
                        NEXT
                    </button>
                </div>
            </div>

            {{-- Step 6: Upload Company Documents (only for company) --}}
        @elseif($currentStep == 6)
            @if ($accountType === 'company')
                <div class="bg-white rounded-lg shadow-lg p-8">
                    <div class="text-center mb-8">
                        <div class="flex items-center justify-center mb-2">
                            <span class="text-cyan-500 text-2xl">✓</span>
                            <h3 class="text-lg font-semibold ml-2">Seller ID Verification</h3>
                        </div>
                        <p class="text-gray-500">Step 7/7</p>
                    </div>

                    <h2 class="text-2xl font-bold text-center mb-6">Upload company documents</h2>

                    <div class="max-w-2xl mx-auto mb-8">
                        <p class="text-gray-600 mb-6 text-center">
                            Please upload documents to prove that the individual who submitted the ID is an owner of
                            your company.
                        </p>

                        <div class="bg-gray-50 rounded-lg p-6 mb-6">
                            <ol class="space-y-3 text-sm text-gray-700">
                                <li>1. Proof of ownership (an extract from a corporate registry or shareholder register)
                                    (required)</li>
                                <li>2. Articles of Association (required)</li>
                                <li>3. Proof of registered company address (utility bill or bank statement, not older
                                    than 3 months) (required)</li>
                                <li>4. Misc docs (corporate structure, incorporation document, misc. company documents,
                                    etc) (optional)</li>
                            </ol>
                        </div>

                        <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-6">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-blue-700">
                                        <strong>Note:</strong> If your company's owner is another company, you will need
                                        to upload documents for both entities and the corporate structure, leading to
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
                                class="block w-full p-4 border-2 border-dashed border-gray-300 rounded-lg text-center cursor-pointer hover:bg-gray-50">
                                <span class="text-gray-700 font-semibold">CHOOSE FILES</span>
                            </label>
                            @if (!empty($companyDocuments))
                                <div class="mt-3 space-y-2">
                                    @foreach ($companyDocuments as $index => $doc)
                                        <p class="text-green-600 text-sm">✓ File {{ $index + 1 }}:
                                            {{ $doc->getClientOriginalName() }}</p>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-gray-500 mt-2 text-center">No files selected</p>
                            @endif
                        </div>

                        <p class="text-xs text-gray-500 text-center">
                            Must be JPEG, PNG, HEIC, PDF, DOCX and cannot exceed 10MB.
                        </p>
                    </div>

                    <div class="flex justify-center space-x-4">
                        <button wire:click="previousStep"
                            class="px-8 py-2 border border-gray-300 rounded-lg hover:bg-gray-50">
                            BACK
                        </button>
                        <button wire:click="submit"
                            class="px-8 py-2 bg-black text-white rounded-lg hover:bg-gray-800">
                            SUBMIT
                        </button>
                    </div>
                </div>
            @else
                {{-- If individual, submit directly --}}
                <script>
                    window.livewire.find('{{ $_instance->getId() }}').submit();
                </script>
            @endif
        @endif
    </div>
</div>
