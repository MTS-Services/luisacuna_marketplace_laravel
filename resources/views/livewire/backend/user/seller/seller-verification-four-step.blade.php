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
                    <p class="font-semibold text-base ">Seller ID verification</p>
                </div>
                <div class="text-sm text-text-primary font-normal pt-2">
                    Step <span>4</span>/<span>6</span>
                </div>
            </div>

            <div class="p-5 lg:px-15 lg:py-10 bg-bg-info dark:bg-bg-light-black rounded-2xl">
                @php 

                $accountType = 'individual';
                @endphp 
                @if ($accountType == 'individual')



                    <div class="w-full mx-auto space-y-4 mb-8">
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
                            <x-ui.input type="text" wire:model="streetAddress" class="w-full p-3 border rounded-lg"
                                placeholder="Street address" />
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
                                <x-ui.input type="text" wire:model="postalCode" class="w-full p-3 border rounded-lg"
                                    placeholder="Postal code" />
                                <x-ui.input-error :messages="$errors->get('postalCode')" />
                            </div>
                        </div>
                    </div>
                @else
                    <div class="max-w-md mx-auto space-y-4 mb-8">
                        <div>
                            <x-ui.label class="mb-2">Company name</x-ui.label>
                            <x-ui.input type="text" wire:model="companyName" class="w-full p-3 border rounded-lg"
                                placeholder="Company name" />
                            <x-ui.input-error :messages="$errors->get('companyName')" />
                        </div>

                        <div>
                            <x-ui.label class="mb-2">Company code/ID</x-ui.label>
                            <x-ui.input type="text" wire:model="companyCode" class="w-full p-3 border rounded-lg"
                                placeholder="Company code/ID" />
                            <x-ui.input-error :messages="$errors->get('companyCode')" />
                        </div>

                        <div>
                            <x-ui.label class="mb-2">VAT/Tax number (optional)</x-ui.label>
                            <x-ui.input type="text" wire:model="vatNumber" class="w-full p-3 border rounded-lg"
                                placeholder="VAT/Tax number (optional)" />
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
                            <x-ui.input type="text" wire:model="companyCity" class="w-full p-3 border rounded-lg"
                                placeholder="City" />
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
                @endif
            </div>

            <div class="flex justify-center space-x-4 pt-10">
                <a href="{{ route('user.seller.verification',['step' => 3])}}" wire:navigate class="px-8 py-2 text-text-white  rounded-lg hover:bg-gray-50">
                    BACK
                </a>
                <a href="{{ route('user.seller.verification',['step' => 5])}}" wire:navigate class="px-8 py-2 bg-zinc-600 hover:bg-zinc-700 text-white rounded-lg ">
                    NEXT
                </a>
            </div>

        </div>
    </div>
</div>
