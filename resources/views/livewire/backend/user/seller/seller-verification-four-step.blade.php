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
                    Step <span>4</span>/<span>6</span>
                </div>
            </div>

            <div class="p-5 lg:px-15 lg:py-10 bg-bg-info dark:bg-bg-light-black rounded-2xl">

                @if ($accountType == 0)



                    <div class="w-full mx-auto space-y-4 mb-8 text-left">
                        <div class="text-left">
                            <x-ui.label class="mb-2 text-xl! sm:text-2xl! font-semibold!">{{ __('First name') }}</x-ui.label>
                            <x-ui.input type="text" wire:model="first_name" placeholder="First name"  class="bg-bg-info! rounded-lg! border-0! focus:ring-0! text-text-white! placeholder:text-text-white!" />
                            <x-ui.input-error :messages="$errors->get('first_name')" />
                        </div>

                        <div class="text-left">
                            <x-ui.label class="mb-2 text-xl! sm:text-2xl! font-semibold!">{{ __('Last name') }}</x-ui.label>
                            <x-ui.input type="text" wire:model="last_name" placeholder="Last name" class="bg-bg-info! rounded-lg! border-0! focus:ring-0! text-text-white! placeholder:text-text-white!" />
                            <x-ui.input-error :messages="$errors->get('last_name')" />
                        </div>

                        <div>
                            <x-ui.label class="mb-2 text-xl! sm:text-2xl! font-semibold!">{{ __('Date of birth') }}</x-ui.label>
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                                <x-ui.select wire:model="dob_year" class="bg-bg-info! rounded-lg! border-0! focus:ring-0! text-text-white! placeholder:text-text-white!">
                                    <option value="">{{ __('Year') }}</option>
                                    @for ($year = date('Y') - 18; $year >= 1950; $year--)
                                        <option value="{{ $year }}">{{ $year }}</option>
                                    @endfor
                                </x-ui.select>
                                <x-ui.select wire:model="dob_month" class="bg-bg-info! rounded-lg! border-0! focus:ring-0! text-text-white! placeholder:text-text-white!">
                                    <option value="">{{ __('Month') }}</option>
                                    @for ($month = 1; $month <= 12; $month++)
                                        <option value="{{ str_pad($month, 2, '0', STR_PAD_LEFT) }}">
                                            {{ $month }}</option>
                                    @endfor
                                </x-ui.select>
                                <x-ui.select wire:model="dob_day" class="bg-bg-info! rounded-lg! border-0! focus:ring-0! text-text-white! placeholder:text-text-white!">

                                    <option value="">{{ __('Day') }}</option>
                                    @for ($day = 1; $day <= 31; $day++)
                                        <option value="{{ str_pad($day, 2, '0', STR_PAD_LEFT) }}">
                                            {{ $day }}</option>
                                    @endfor
                                </x-ui.select>
                            </div>
                            <x-ui.input-error class="my-2" :messages="$errors->get('dob_year')" />
                            <x-ui.input-error class="my-2" :messages="$errors->get('dob_month')" />
                            <x-ui.input-error class="my-2" :messages="$errors->get('dob_day')" />
                        </div>

                        <div>
                            <x-ui.label class="mb-2 text-xl! sm:text-2xl! font-semibold!">{{ __('Nationality:') }}</x-ui.label>
                            <x-ui.select wire:model="nationality" class="w-full bg-bg-info! rounded-lg! border-0! focus:ring-0! text-text-white! placeholder:text-text-white!">
                                <option value="">{{ __('Select nationality') }}</option>
                                @foreach ($countries as $country)
                                    <option value="{{ strtolower($country->name) }}">{{ $country->name }}</option>
                                @endforeach
                            </x-ui.select>
                            <x-ui.input-error :messages="$errors->get('nationality')" />
                        </div>

                        <div>
                            <x-ui.label class="mb-2 text-xl! sm:text-2xl! font-semibold!">{{ __('Street address') }}</x-ui.label>
                            <x-ui.input type="text" wire:model="address" class="w-full bg-bg-info! rounded-lg! border-0! focus:ring-0! text-text-white! placeholder:text-text-white!"
                                placeholder="Street address" />
                            <x-ui.input-error :messages="$errors->get('address')" />
                        </div>

                        <div>
                            <x-ui.label class="mb-2 text-xl! sm:text-2xl! font-semibold!">{{ __('City') }}</x-ui.label>
                            <x-ui.input type="text" wire:model="city" class="w-full bg-bg-info! rounded-lg! border-0! focus:ring-0! text-text-white! placeholder:text-text-white!"
                                placeholder="City" />
                            <x-ui.input-error :messages="$errors->get('city')" />
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <div>
                                <x-ui.label class="mb-2 text-xl! sm:text-2xl! font-semibold!">{{ __('Country') }}</x-ui.label>
                                <x-ui.select wire:model="country_id" class="w-full bg-bg-info! rounded-lg! border-0! focus:ring-0! text-text-white! placeholder:text-text-white!">
                                    <option value="">{{ __('Select country') }}</option>
                                    @foreach ($countries as $country)
                                        <option value="{{ $country->id }}">{{ $country->name }}</option>
                                    @endforeach



                                </x-ui.select>
                                <x-ui.input-error :messages="$errors->get('country_id')" />
                            </div>
                            <div>
                                <x-ui.label class="mb-2 text-xl! sm:text-2xl! font-semibold!">{{ __('Postal code') }}</x-ui.label>
                                <x-ui.input type="text" wire:model="postal_code" class="w-full bg-bg-info! rounded-lg! border-0! focus:ring-0! text-text-white! placeholder:text-text-white!"
                                    placeholder="Postal code" />
                                <x-ui.input-error :messages="$errors->get('postal_code')" />
                            </div>
                        </div>
                    </div>
                @else
                    <div class="max-w-md mx-auto space-y-4 mb-8 text-left">
                        <div>
                            <x-ui.label class="mb-2 text-xl! sm:text-2xl! font-semibold!">{{ __('Company name') }}</x-ui.label>
                            <x-ui.input type="text" wire:model="company_name" class="w-full bg-bg-info! rounded-lg! border-0! focus:ring-0! text-text-white! placeholder:text-text-white!"
                                placeholder="Company name" />
                            <x-ui.input-error :messages="$errors->get('company_name')" />
                        </div>

                        <div>
                            <x-ui.label class="mb-2 text-xl! sm:text-2xl! font-semibold!">{{ __('Company code/ID') }}</x-ui.label>
                            <x-ui.input type="text" wire:model="company_license_number"
                                class="w-full bg-bg-info! rounded-lg! border-0! focus:ring-0! text-text-white! placeholder:text-text-white!" placeholder="Company License/ID" />
                            <x-ui.input-error :messages="$errors->get('company_license_number')" />
                        </div>

                        <div>
                            <x-ui.label class="mb-2 text-xl! sm:text-2xl! font-semibold!">{{ __('VAT/Tax number (optional)') }}</x-ui.label>
                            <x-ui.input type="text" wire:model="company_tax_number"
                                class="w-full bg-bg-info! rounded-lg! border-0! focus:ring-0! text-text-white! placeholder:text-text-white!" placeholder="VAT/Tax number (optional)" />
                            <x-ui.input-error :messages="$errors->get('company_tax_number')" />
                        </div>

                        <div>
                            <x-ui.label class="mb-2 text-xl! sm:text-2xl! font-semibold!">{{ __('Street address') }}</x-ui.label>
                            <x-ui.input type="text" wire:model="company_address" class="w-full bg-bg-info! rounded-lg! border-0! focus:ring-0! text-text-white! placeholder:text-text-white!"
                                placeholder="Street address" />
                            <x-ui.input-error :messages="$errors->get('company_address')" />
                        </div>

                        <div>
                            <x-ui.label class="mb-2 text-xl! sm:text-2xl! font-semibold!">{{ __('City') }}</x-ui.label>
                            <x-ui.input type="text" wire:model="company_city" class="w-full bg-bg-info! rounded-lg! border-0! focus:ring-0! text-text-white! placeholder:text-text-white!"
                                placeholder="City" />
                            <x-ui.input-error :messages="$errors->get('company_city')" />
                        </div>

                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <x-ui.label class="mb-2 text-xl! sm:text-2xl! font-semibold!">{{ __('Country') }}</x-ui.label>
                                <x-ui.select wire:model="company_country_id" class="w-full bg-bg-info! rounded-lg! border-0! focus:ring-0! text-text-white! placeholder:text-text-white!">
                                    @foreach ($countries as $country)
                                        <option value="{{ $country->id }}">{{ $country->name }}</option>
                                    @endforeach
                                </x-ui.select>
                                <x-ui.input-error :messages="$errors->get('company_country_id')" />
                            </div>
                            <div>
                                <x-ui.label class="mb-2 text-xl! sm:text-2xl! font-semibold!">{{ __('Postal code') }}</x-ui.label>
                                <x-ui.input type="text" wire:model="company_postal_code"
                                    class="w-full bg-bg-info! rounded-lg! border-0! focus:ring-0! text-text-white! placeholder:text-text-white!" placeholder="Postal code" />
                                <x-ui.input-error :messages="$errors->get('company_postal_code')" />
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <div class="flex justify-center space-x-4 pt-10">
                {{-- <a wire:click.prevent="previousStep" wire:navigate class="px-8 cursor-pointer py-2 text-text-white  rounded-lg hover:bg-gray-50">
                    BACK
                </a>
                <button wire:click="nextStep" class="px-8 py-2 bg-zinc-600 hover:bg-zinc-700 text-white rounded-lg ">
                    NEXT
                </button> --}}
                <!-- Submit button -->
                <div class=" flex justify-center px-2 sm:px-6 mt-5 sm:mt-11">
                    <x-ui.button type="submit" wire:click.prevent="previousStep" wire:navigate
                        class="w-auto py-2! text-white text-base! font-semibold!">
                        {{ __('Back') }}
                    </x-ui.button>
                </div>
                <div class="  flex justify-center px-2 sm:px-6 mt-5 sm:mt-11">
                    <x-ui.button type="submit" wire:click="nextStep"
                        class="w-auto py-2!  text-base! font-semibold!">
                        {{ __('Next') }}
                    </x-ui.button>
                </div>
            </div>

        </div>
    </div>
</div>
