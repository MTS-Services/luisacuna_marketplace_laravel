<div>
    <div class="bg-bg-info p-3 sm:p-6 rounded-lg">
        <x-ui.label value="Payment Lock" class="text-base! font-normal! mb-1! text-text-primary!" />
        <x-ui.button class="w-fit! py-2! my-2!" wire:click="openModal">
            <span>
                {{ __('Set up 2FA') }}
            </span>
        </x-ui.button>
        <p class="text-xl font-normal text-text-primary">Enable with Google Authenticator. 2FA codes will
            be requested for withdrawals and purchases. They are not required for logging in.</p>
    </div>

    <!-- Password Change Modal -->
    @if ($showModal)
        <div class="fixed inset-0 dark:bg-bg-primary bg-black/50 flex items-center justify-center z-50"
            @click.self="$wire.closeModal()">

            <div class="bg-bg-info p-3 sm:p-6 rounded-lg">
                <label class="block text-sm font-medium text-text-primary mb-2">{{ __('Username:') }}</label>
              
                <div>
                     <div>
                        <h2 class="text-2xl sm:text-3xl font-semibold text-text-primary mb-8">Setup Authenticator</h2>
                     </div>
                </div>
                <div class="flex justify-start gap-3 mt-4">
                    <x-ui.button wire:click="updateProfile" class="w-fit! py-2!">
                        {{ __('Back') }}
                    </x-ui.button>
                   <x-ui.button wire:click="updateProfile" class="w-fit! py-2!">
                        {{ __('Next') }}
                    </x-ui.button>
                </div>
             </div>

        </div>
    @endif

</div>
