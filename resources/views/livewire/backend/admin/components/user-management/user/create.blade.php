<section>
    <div class="glass-card rounded-2xl p-6 mb-6">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-bold text-text-black dark:text-text-white">{{ __('User Create') }}</h2>
            <div class="flex items-center gap-2">
                <x-ui.button href="{{ route('admin.um.user.index') }}">
                    <flux:icon name="arrow-left" class="w-4 h-4 stroke-white" />
                    {{ __('Back') }}
                </x-ui.button>
            </div>
        </div>
    </div>
    <div class="glass-card rounded-2xl p-6 mb-6">
        <form wire:submit="save">
            <div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
                    {{ __('Profile Picture') }}
                </h3>
                <x-ui.file-input wire:model="form.avatar" label="Avatar" accept="image/*" :error="$errors->first('form.avatar')"
                    hint="Upload a profile picture (Max: 2MB)" />
            </div>

            <!-- Add other form fields here -->
            <div class="mt-6 space-y-4 grid grid-cols-2 gap-5">

                {{-- first_name --}}
                {{-- <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        First Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text" wire:model="form.first_name"
                        class="w-full px-4 py-2 border rounded-lg dark:bg-gray-800 dark:border-gray-600">
                    @error('form.first_name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div> --}}

                <div class="w-full">
                    <x-ui.label value="First Name" class="mb-1" />
                    <x-ui.input type="text" placeholder="First Name" wire:model="form.first_name" />
                    <x-ui.input-error :messages="$errors->get('form.first_name')" />
                </div>

                {{-- Last Name --}}

                {{-- <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Last Name
                    </label>
                    <input type="text" wire:model="form.last_name"
                        class="w-full px-4 py-2 border rounded-lg dark:bg-gray-800 dark:border-gray-600">
                    @error('form.last_name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div> --}}

                <div class="w-full">
                    <x-ui.label value="Last Name" class="mb-1" />
                    <x-ui.input type="text" placeholder="Last Name" wire:model="form.last_name" />
                    <x-ui.input-error :messages="$errors->get('form.last_name')" />
                </div>

                {{-- user name --}}
                {{-- <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        User Name
                    </label>
                    <input type="text" wire:model="form.username"
                        class="w-full px-4 py-2 border rounded-lg dark:bg-gray-800 dark:border-gray-600">
                    @error('form.username')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div> --}}

                <div class="w-full">
                    <x-ui.label value="User Name" class="mb-1" />
                    <x-ui.input type="text" placeholder="User Name" wire:model="form.username" />
                    <x-ui.input-error :messages="$errors->get('form.username')" />
                </div>
                {{-- display name --}}
                {{-- <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Display Name
                    </label>
                    <input type="text" wire:model="form.display_name"
                        class="w-full px-4 py-2 border rounded-lg dark:bg-gray-800 dark:border-gray-600">
                    @error('form.display_name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div> --}}

                <div class="w-full">
                    <x-ui.label value="Display Name" class="mb-1" />
                    <x-ui.input type="text" placeholder="Display Name" wire:model="form.display_name" />
                    <x-ui.input-error :messages="$errors->get('form.display_name')" />
                </div>
                {{-- date_of_birth --}}
                {{-- <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Date Of Birth
                    </label>
                    <input type="date" wire:model="form.date_of_birth"
                        class="w-full px-4 py-2 border rounded-lg dark:bg-gray-800 dark:border-gray-600">
                    @error('form.date_of_birth')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div> --}}

                <div class="w-full">
                    <x-ui.label value="Date Of Birth" class="mb-1" />
                    <x-ui.input type="date" wire:model="form.date_of_birth" />
                    <x-ui.input-error :messages="$errors->get('form.date_of_birth')" />
                </div>

                {{-- <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Country <span class="text-red-500">*</span>
                    </label>
                    <select wire:model="form.country_id"
                        class="w-full px-4 py-2 border rounded-lg dark:bg-gray-800 dark:border-gray-600">
                        <option value="">Select Country</option>
                        @foreach ($countries as $country)
                            <option value="{{ $country->id }}">{{ $country['name'] }}</option>
                        @endforeach
                    </select>
                    @error('form.phone')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div> --}}

                <div class="w-full">
                    <x-ui.label value="Country Select" class="mb-1" />
                    <x-ui.select wire:model="form.country_id">
                        @foreach ($countries as $country)
                            <option value="{{ $country['id'] }}">{{ $country['name'] }}</option>
                        @endforeach
                    </x-ui.select>
                    <x-ui.input-error :messages="$errors->get('form.country_id')" />
                </div>

                {{-- <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Langugae <span class="text-red-500">*</span>
                    </label>
                    <input type="text" wire:model="form.language"
                        class="w-full px-4 py-2 border rounded-lg dark:bg-gray-800 dark:border-gray-600">
                    @error('form.language')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div> --}}

                <div class="w-full">
                    <x-ui.label value="Langugae" class="mb-1" />
                    <x-ui.input type="text" placeholder="Langugae" wire:model="form.language" />
                    <x-ui.input-error :messages="$errors->get('form.language')" />
                </div>

                {{-- <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Email <span class="text-red-500">*</span>
                    </label>
                    <input type="email" wire:model="form.email"
                        class="w-full px-4 py-2 border rounded-lg dark:bg-gray-800 dark:border-gray-600">
                    @error('form.email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div> --}}

                <div class="w-full">
                    <x-ui.label value="Email" class="mb-1" />
                    <x-ui.input type="email" placeholder="Email" wire:model="form.email" />
                    <x-ui.input-error :messages="$errors->get('form.email')" />
                </div>

                {{-- <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Phone
                    </label>
                    <input type="number" wire:model="form.phone"
                        class="w-full px-4 py-2 border rounded-lg dark:bg-gray-800 dark:border-gray-600">
                    @error('form.phone')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div> --}}

                <div class="w-full">
                    <x-ui.label value="Phone" class="mb-1" />
                    <x-ui.input type="tel" placeholder="Phone" wire:model="form.phone" />
                    <x-ui.input-error :messages="$errors->get('form.phone')" />
                </div>


                {{-- <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Status <span class="text-red-500">*</span>
                    </label>
                    <select wire:model="form.account_status"
                        class="w-full px-4 py-2 border rounded-lg dark:bg-gray-800 dark:border-gray-600">
                        <option value="">Select Status</option>
                        @foreach ($statuses as $status)
                            <option value="{{ $status['value'] }}">{{ $status['label'] }}</option>
                        @endforeach
                    </select>
                    @error('form.account_status')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div> --}}

                <div class="w-full">
                    <x-ui.label value="Status Select" class="mb-1" />
                    <x-ui.select wire:model="form.account_status">
                        @foreach ($statuses as $status)
                            <option value="{{ $status['value'] }}">{{ $status['label'] }}</option>
                        @endforeach
                    </x-ui.select>
                    <x-ui.input-error :messages="$errors->get('form.account_status')" />
                </div>

                {{-- <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Password <span class="text-red-500">*</span>
                    </label>
                    <input type="password" wire:model="form.password"
                        class="w-full px-4 py-2 border rounded-lg dark:bg-gray-800 dark:border-gray-600">
                    @error('form.password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div> --}}

                <div class="w-full">
                    <x-ui.label value="Password" class="mb-1" />
                    <x-ui.input type="password" placeholder="Password" wire:model="form.password" />
                    <x-ui.input-error :messages="$errors->get('form.password')" />
                </div>

                {{-- <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Confirm Password <span class="text-red-500">*</span>
                    </label>
                    <input type="password" wire:model="form.password_confirmation"
                        class="w-full px-4 py-2 border rounded-lg dark:bg-gray-800 dark:border-gray-600">
                    @error('form.password_confirmation')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div> --}}

                <div class="w-full">
                    <x-ui.label value="Password Confirmation" class="mb-1" />
                    <x-ui.input type="password" placeholder="Password Confirmation" wire:model="form.password_confirmation" />
                    <x-ui.input-error :messages="$errors->get('form.password_confirmation')" />
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex items-center justify-end gap-4 mt-6">
                <x-ui.button href="{{ route('admin.um.user.index') }}" type="danger">
                    <flux:icon name="x-circle" class="w-4 h-4 stroke-white" />
                    {{ __('Cancel') }}
                </x-ui.button>

                <x-ui.button type="accent" button>
                    <span wire:loading.remove wire:target="save" class="text-white">Create User</span>
                    <span wire:loading wire:target="save" class="text-white">Creating...</span>
                </x-ui.button>
            </div>
        </form>
    </div>
</section>
