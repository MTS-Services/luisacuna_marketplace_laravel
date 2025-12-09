<div>
    <div>
        <!-- Password Change Button Section -->
        <div class="p-3 sm:p-6 bg-bg-info rounded-lg">
            <h2 class="block text-base font-medium text-text-primary mb-2">{{ __('Password:') }}</h2>
            <div class="flex items-center gap-2 sm:gap-6 w-full">
                <div class="w-full">
                    <x-ui.button wire:click="openModal" class="w-fit! py-2!">
                        {{ __('Change password') }}
                    </x-ui.button>
                </div>
            </div>
        </div>

        <!-- Password Change Modal -->
        @if ($showModal)
            <div class="fixed inset-0 dark:bg-bg-primary bg-black/50 flex items-center justify-center z-50"
                @click.self="$wire.closeModal()">
                <div class="dark:bg-bg-secondary bg-white rounded-2xl sm:rounded-3xl p-4 sm:p-6 w-full max-w-sm sm:max-w-md md:max-w-lg lg:max-w-xl"
                    x-data="{
                        password: @entangle('form.password'),
                        touched: false,
                    
                        get hasLowercase() {
                            return /[a-z]/.test(this.password);
                        },
                        get hasUppercase() {
                            return /[A-Z]/.test(this.password);
                        },
                        get hasNumber() {
                            return /[0-9]/.test(this.password);
                        },
                        get hasMinLength() {
                            return this.password && this.password.length >= 8;
                        },
                        get noSpaces() {
                            return this.password && this.password === this.password.trim() && this.password.length > 0;
                        },
                        get allValid() {
                            return this.hasLowercase && this.hasUppercase && this.hasNumber && this.hasMinLength && this.noSpaces;
                        }
                    }">
                    <div class="space-y-6">
                        <!-- Modal Header -->
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-xl font-semibold text-text-primary">{{ __('Change Password') }}</h3>
                            <button wire:click="closeModal" class="text-text-muted hover:text-text-primary">
                                <x-phosphor name="x" variant="regular" class="w-6 h-6" />
                            </button>
                        </div>

                        <!-- Old Password -->
                        <div class="w-full">
                            <x-ui.label value="Old password:"
                                class="text-base! font-semibold! mb-3! text-text-white!" />
                            <x-ui.input type="password" placeholder="Enter old password"
                                wire:model="form.password_old" />
                            <x-ui.input-error :messages="$errors->get('form.password_old')" />
                        </div>

                        <!-- New Password -->
                        <div class="w-full">
                            <x-ui.label value="New password:"
                                class="text-base! font-semibold! mb-3! text-text-white!" />
                            <x-ui.input type="password" placeholder="Enter new password" wire:model="form.password"
                                @blur="touched = true" />
                            <x-ui.input-error :messages="$errors->get('form.password')" />
                        </div>

                        <!-- Validation Rules (Show after touch) -->
                        <div x-show="touched" x-transition>
                            <!-- Lowercase Letter -->
                            <div class="flex items-center gap-2">
                                <x-phosphor name="x" variant="regular" class="w-4 h-4 text-pink-500"
                                    x-show="!hasLowercase" />
                                <x-phosphor name="check" variant="regular" class="w-4 h-4 text-zinc-500"
                                    x-show="hasLowercase" x-cloak />
                                <p class="text-xs font-normal"
                                    :class="hasLowercase ? 'text-zinc-500' : 'text-text-white'">
                                    {{ __('Password must contain a lowercase letter') }}
                                </p>
                            </div>

                            <!-- Uppercase Letter -->
                            <div class="flex items-center gap-2 mt-2">
                                <x-phosphor name="x" variant="regular" class="w-4 h-4 text-pink-500"
                                    x-show="!hasUppercase" />
                                <x-phosphor name="check" variant="regular" class="w-4 h-4 text-zinc-500"
                                    x-show="hasUppercase" x-cloak />
                                <p class="text-xs font-normal"
                                    :class="hasUppercase ? 'text-zinc-500' : 'text-text-white'">
                                    {{ __('Password must contain an uppercase letter') }}
                                </p>
                            </div>

                            <!-- Number -->
                            <div class="flex items-center gap-2 mt-2">
                                <x-phosphor name="x" variant="regular" class="w-4 h-4 text-pink-500"
                                    x-show="!hasNumber" />
                                <x-phosphor name="check" variant="regular" class="w-4 h-4 text-zinc-500"
                                    x-show="hasNumber" x-cloak />
                                <p class="text-xs font-normal" :class="hasNumber ? 'text-zinc-500' : 'text-text-white'">
                                    {{ __('Password must contain a number') }}
                                </p>
                            </div>

                            <!-- Min Length -->
                            <div class="flex items-center gap-2 mt-2">
                                <x-phosphor name="x" variant="regular" class="w-4 h-4 text-pink-500"
                                    x-show="!hasMinLength" />
                                <x-phosphor name="check" variant="regular" class="w-4 h-4 text-zinc-500"
                                    x-show="hasMinLength" x-cloak />
                                <p class="text-xs font-normal"
                                    :class="hasMinLength ? 'text-zinc-500' : 'text-text-white'">
                                    {{ __('Password must be at least 8 characters long') }}
                                </p>
                            </div>

                            <!-- No Spaces -->
                            <div class="flex items-center gap-2 mt-2">
                                <x-phosphor name="x" variant="regular" class="w-4 h-4 text-pink-500"
                                    x-show="!noSpaces" />
                                <x-phosphor name="check" variant="regular" class="w-4 h-4 text-zinc-500"
                                    x-show="noSpaces" x-cloak />
                                <p class="text-xs font-normal" :class="noSpaces ? 'text-zinc-500' : 'text-text-white'">
                                    {{ __('Password must not contain leading or trailing spaces') }}
                                </p>
                            </div>
                        </div>

                        <!-- Confirm Password -->
                        <div class="w-full">
                            <x-ui.label value="Re-enter new password:"
                                class="text-base! font-semibold! mb-3! text-text-white!" />
                            <x-ui.input type="password" placeholder="Re-enter new password"
                                wire:model="form.password_confirmation" />
                            <x-ui.input-error :messages="$errors->get('form.password_confirmation')" />
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex items-center justify-end gap-4 mt-6">
                            <x-ui.button wire:click="changePassword" class="w-fit! py-2!">
                                <span wire:loading.remove wire:target="changePassword">
                                    {{ __('Change password') }}
                                </span>
                                <span wire:loading wire:target="changePassword">
                                    {{ __('Changing...') }}
                                </span>
                            </x-ui.button>

                            <x-ui.button wire:click="closeModal" class="w-auto! py-2!" type="button">
                                <span class="text-text-btn-primary group-hover:text-text-btn-secondary">
                                    {{ __('Cancel') }}
                                </span>
                            </x-ui.button>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
