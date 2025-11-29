<section>
    <div class="glass-card rounded-2xl p-6 mb-6">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-bold text-text-black dark:text-text-white">{{ __('User Create') }}</h2>
            <div class="flex items-center gap-2">
                <x-ui.button href="{{ route('admin.um.user.index') }}" class="w-auto! py-2!">
                    <flux:icon name="arrow-left"
                        class="w-4 h-4 stroke-text-btn-primary group-hover:stroke-text-btn-secondary" />
                    {{ __('Back') }}
                </x-ui.button>
            </div>
        </div>
    </div>

    <div class="glass-card rounded-2xl p-6 mb-6">
        <form wire:submit.prevent="save">
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
                <div class="w-full">
                    <x-ui.label value="First Name" class="mb-1" />
                    <x-ui.input type="text" placeholder="First Name" wire:model="form.first_name" />
                    <x-ui.input-error :messages="$errors->get('form.first_name')" />
                </div>

                {{-- Last Name --}}
                <div class="w-full">
                    <x-ui.label value="Last Name" class="mb-1" />
                    <x-ui.input type="text" placeholder="Last Name" wire:model="form.last_name" />
                    <x-ui.input-error :messages="$errors->get('form.last_name')" />
                </div>

                {{-- user name --}}
                <div class="w-full">
                    <x-ui.label value="User Name" class="mb-1" />
                    <x-ui.input type="text" placeholder="User Name" wire:model="form.username" />
                    <x-ui.input-error :messages="$errors->get('form.username')" />
                </div>

                {{-- date_of_birth --}}
                <div class="w-full">
                    <x-ui.label value="Date Of Birth" class="mb-1" />
                    <x-ui.input type="date" wire:model="form.date_of_birth" />
                    <x-ui.input-error :messages="$errors->get('form.date_of_birth')" />
                </div>

                <div class="w-full">
                    <x-ui.label value="Email" class="mb-1" />
                    <x-ui.input type="email" placeholder="Email" wire:model="form.email" />
                    <x-ui.input-error :messages="$errors->get('form.email')" />
                </div>

                <div class="w-full">
                    <x-ui.label value="Phone" class="mb-1" />
                    <x-ui.input type="tel" placeholder="Phone" wire:model="form.phone" />
                    <x-ui.input-error :messages="$errors->get('form.phone')" />
                </div>

                <div class="w-full">
                    <x-ui.label value="Status Select" class="mb-1" />
                    <x-ui.select wire:model="form.account_status">
                        <option value="">{{ __('Select Status') }}</option>
                        @foreach ($statuses as $status)
                            <option value="{{ $status['value'] }}">{{ $status['label'] }}</option>
                        @endforeach
                    </x-ui.select>
                    <x-ui.input-error :messages="$errors->get('form.account_status')" />
                </div>

                <div class="w-full" x-data="{
                    generatePassword() {
                        const length = 12;
                        const charset = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*';
                        let password = '';
                        for (let i = 0; i < length; i++) {
                            password += charset.charAt(Math.floor(Math.random() * charset.length));
                        }
                
                        // Set the password in Livewire component
                        $wire.set('form.password', password);
                        $wire.set('form.password_confirmation', password);
                    }
                }">
                    <x-ui.label value="Password" class="mb-1" />
                    <div class="flex items-center gap-2">
                        <x-ui.input type="password" placeholder="Password" wire:model="form.password" class="flex-1" />
                        <button type="button" @click="generatePassword()"
                            class="text-gray-500 hover:text-gray-700 focus:outline-none flex-shrink-0"
                            title="Generate Password">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                            </svg>
                        </button>
                    </div>
                    <x-ui.input-error :messages="$errors->get('form.password')" />
                </div>

                <div class="w-full">
                    <x-ui.label value="Password Confirmation" class="mb-1" />
                    <x-ui.input type="password" placeholder="Password Confirmation"
                        wire:model="form.password_confirmation" />
                    <x-ui.input-error :messages="$errors->get('form.password_confirmation')" />
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex items-center justify-end gap-4 mt-6">
                <x-ui.button wire:click="resetForm" variant="tertiary" type="button" class="w-auto! py-2!">
                    <flux:icon name="x-circle"
                        class="w-4 h-4 stroke-text-btn-primary group-hover:stroke-text-btn-tertiary" />
                    {{ __('Reset') }}
                </x-ui.button>

                <x-ui.button class="w-auto! py-2!" type="submit">
                    <span wire:loading.remove wire:target="save"
                        class="text-text-btn-primary group-hover:text-text-btn-secondary">
                        {{ __('Create User') }}
                    </span>
                    <span wire:loading wire:target="save"
                        class="text-text-btn-primary group-hover:text-text-btn-secondary">
                        {{ __('Creating...') }}
                    </span>
                </x-ui.button>
            </div>
        </form>
    </div>
</section>
