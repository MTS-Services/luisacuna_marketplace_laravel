<div>
    <div class="bg-bg-info p-3 sm:p-6 rounded-lg">
        <x-ui.label value="{{ __('Payment Lock') }}" class="block text-sm font-medium text-text-primary mb-2" />
        <x-ui.button class="w-fit! py-2! my-2!" wire:click="openModal">
            <span class="text-text-white text-base font-semibold">
                {{ __('Set up 2FA') }}
            </span>
        </x-ui.button>
        <p class="text-sm lg:text-xl font-normal text-text-primary">
            {{ __('Enable with Google Authenticator. 2FA codes will be requested for withdrawals and purchases. They are not required for logging in.') }}
        </p>
    </div>

    <!-- Password Change Modal -->
    @if ($showModal)
        <div class="fixed inset-0 bg-bg-primary flex items-center justify-center z-50" @click.self="$wire.closeModal()">

            <div class="relative w-9/10 md:w-3xl rounded-2xl bg-bg-secondary p-4 sm:p-12 text-text-white shadow-2xl">
                <div class="flex items-center justify-between gap-3 mb-6">
                    <div class="flex items-center gap-3">
                        <span class="flex h-9 w-9 items-center justify-center rounded-full ">
                            <svg class="w-6 h-6 text-text-white" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                                </path>
                            </svg>
                        </span>
                        <h2 class="text-xl md:text-3xl font-semibold">{{ __('Setup Authenticator') }}</h2>
                    </div>

                    <!-- Close Button -->
                    <div>
                        <button class="text-text-primary hover:text-zinc-500 text-xl" wire:click="closeModal">
                            ✕
                        </button>
                    </div>
                </div>

                @if ($step == 1)
                    <!-- Header -->


                    <!-- Instructions -->
                    <ol class="mb-6 space-y-2 text-md text-text-white/80">
                        <li class="text-text-white font-normal sm:font-semibold text-base sm:text-xl">
                            {{ __('1. Download the') }} <span
                                class="text-pink-600">{{ __('Google Authenticator') }}</span> {{ __(' App') }}</li>
                        <li class="text-text-white font-normal sm:font-semibold text-base sm:text-xl">
                            {{ __('2. In the App select Set up account.') }}</li>
                        <li class="text-text-white font-normal sm:font-semibold text-base sm:text-xl">
                            {{ __('3. Choose Scan a QR code.') }}</li>
                    </ol>

                    <!-- Security Key -->
                    <!-- Security Key -->
                    <div class="mb-6">
                        <p class="mb-2 text-center text-lg text-text-white">{{ __('Security key:') }}</p>

                        @if (!$showQrCode)
                            <div>
                                <p
                                    class="rounded-xl w-full md:w-2/3 mx-auto p-4 text-center text-sm leading-relaxed text-text-white/90 break-all">
                                    {{ __('GE2DSNTEGE3DQZRRGE3DlMRUG12GlYLDHEZWMNRZM12DQOLBME3DSNBVMU4DMOJXG4ZWKNDBMUYTCMBRGQ4TGZLEGU4DENBSMMYTIYQ') }}
                                </p>
                            </div>
                        @else
                            <div class="flex justify-center mb-4">
                                <img src="{{ asset('assets/images/qr_code.png') }}" alt="QR Code" class="h-48 w-48">
                            </div>
                        @endif
                    </div>

                    <!-- QR Code Text -->
                    @if (!$showQrCode)
                        <p class="mb-8 text-lg text-center font-bold text-pink-600 cursor-pointer"
                            wire:click="generateQrCode">
                            {{ __('QR code') }}
                        </p>
                    @else
                        <p class="mb-8 text-lg text-center font-bold text-pink-600 cursor-pointer"
                            wire:click="ShowCode">
                            {{ __('Show code') }}
                        </p>
                    @endif
                @else
                    <!-- Content -->
                    <div class="space-y-6">
                        <p class="text-text-gray-300 text-lg">{{ __('Enter the 6-digit code you see in the app.') }}
                        </p>

                        <!-- Input Field -->
                        <input type="text text-text-primary" maxlength="6" placeholder="123456"
                            class="w-full text-text-white rounded-lg px-4 py-3 bg-bg-primary placeholder-gray-500 focus:outline-none border-0 focus:ring-1 focus:ring-zinc-500 transition-all">

                    </div>
                @endif
                <div class="flex justify-end gap-3 mt-4">
                    @if ($step == 1)
                        <x-ui.button wire:click="closeModal" class="w-fit! py-2!">
                            {{ __('Cancel') }}
                        </x-ui.button>

                        <x-ui.button wire:click="nextStep" class="w-fit! py-2!">
                            {{ __('Next') }}
                        </x-ui.button>
                    @else
                        <x-ui.button wire:click="previousStep" class="w-fit! py-2!">
                            {{ __('Back') }}
                        </x-ui.button>
                        <x-ui.button wire:click="verifySetup" class="w-fit! py-2!">
                            {{ __('Verify') }}
                        </x-ui.button>
                    @endif
                </div>
            </div>

        </div>
    @endif

</div>
