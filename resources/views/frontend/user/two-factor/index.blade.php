<x-frontend::app>
    <style>
        .glass-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
        }

        .dark .glass-card {
            background: rgba(30, 41, 59, 0.95);
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-in {
            animation: fadeIn 0.3s ease-out;
        }

        .modal-backdrop {
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(4px);
        }

        .modal-content {
            animation: fadeIn 0.3s ease-out;
        }
    </style>

    <div class="w-full min-h-screen py-4 sm:py-6 md:py-8 px-3 sm:px-4 lg:px-6 flex flex-col justify-center">
        <div class="max-w-5xl mx-auto w-full space-y-4 sm:space-y-6 md:space-y-8">
            <div class="bg-bg-primary rounded-xl sm:rounded-2xl overflow-hidden shadow-xl">
                <!-- Header -->
                <div class="p-4 sm:p-6 md:p-8 relative">
                    <a wire:navigate href="{{ route('user.account-settings') }}"
                        class="absolute top-3 right-3 sm:top-4 sm:right-4 md:top-6 md:right-6 w-8 h-8 sm:w-10 sm:h-10 flex items-center justify-center rounded-full bg-white/10 backdrop-blur border border-white/20 text-white hover:bg-white/20 transition"
                        title="{{ __('Close') }}">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12">
                            </path>
                        </svg>
                    </a>
                    <div class="flex flex-col sm:flex-row items-start sm:items-center gap-3 pr-10 sm:pr-12">
                        <svg class="w-8 h-8 sm:w-10 sm:h-10 text-white flex-shrink-0" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                            </path>
                        </svg>
                        <div>
                            <h2 class="text-lg sm:text-xl md:text-2xl lg:text-3xl font-semibold">
                                {{ __('Two-Factor Authentication') }}</h2>
                            <p class="text-text-white/80 mt-1 text-sm sm:text-base">
                                {{ __('Secure your account with additional protection') }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="p-4 sm:p-6 md:p-8">
                    <!-- Status Messages -->
                    @if (session('status') === 'two-factor-authentication-enabled')
                        <div
                            class="mb-4 sm:mb-6 p-3 sm:p-4 bg-blue-50 dark:bg-blue-900/30 border-l-4 border-blue-500 text-blue-800 dark:text-blue-200 rounded-lg fade-in">
                            <div class="flex items-start sm:items-center gap-2 sm:gap-3">
                                <svg class="w-5 h-5 flex-shrink-0 mt-0.5 sm:mt-0" fill="currentColor"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <p class="font-semibold text-sm sm:text-base">
                                    {{ __('Two-factor authentication setup is in progress') }}</p>
                            </div>
                        </div>
                    @endif

                    @if (session('status') === 'two-factor-authentication-confirmed')
                        <div
                            class="mb-4 sm:mb-6 p-3 sm:p-4 bg-green-50 dark:bg-green-900/30 border-l-4 border-green-500 text-green-800 dark:text-green-200 rounded-lg fade-in">
                            <div class="flex items-start sm:items-center gap-2 sm:gap-3">
                                <svg class="w-5 h-5 flex-shrink-0 mt-0.5 sm:mt-0" fill="currentColor"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <p class="font-semibold text-sm sm:text-base">
                                    {{ __('Two-factor authentication confirmed successfully!') }}</p>
                            </div>
                        </div>
                    @endif

                    @if (session('status') === 'two-factor-authentication-disabled')
                        <div
                            class="mb-4 sm:mb-6 p-3 sm:p-4 bg-red-50 dark:bg-red-900/30 border-l-4 border-red-500 text-red-800 dark:text-red-200 rounded-lg fade-in">
                            <div class="flex items-start sm:items-center gap-2 sm:gap-3">
                                <svg class="w-5 h-5 flex-shrink-0 mt-0.5 sm:mt-0" fill="currentColor"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <p class="font-semibold text-sm sm:text-base">
                                    {{ __('Two-factor authentication has been disabled.') }}</p>
                            </div>
                        </div>
                    @endif

                    @if (session('status') === 'recovery-codes-generated')
                        <div
                            class="mb-4 sm:mb-6 p-3 sm:p-4 bg-blue-50 dark:bg-blue-900/30 border-l-4 border-blue-500 text-blue-800 dark:text-blue-200 rounded-lg fade-in">
                            <div class="flex items-start sm:items-center gap-2 sm:gap-3">
                                <svg class="w-5 h-5 flex-shrink-0 mt-0.5 sm:mt-0" fill="currentColor"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <p class="font-semibold text-sm sm:text-base">
                                    {{ __('New recovery codes have been generated!') }}</p>
                            </div>
                        </div>
                    @endif

                    <!-- Enable/Disable 2FA -->
                    @if (!$twoFactorEnabled)
                        <div
                            class="space-y-4 sm:space-y-6 max-w-2xl mx-auto text-center min-h-[50vh] sm:min-h-[60vh] flex flex-col justify-center px-2">
                            <div>
                                <h3
                                    class="text-xl sm:text-2xl font-bold text-slate-800 dark:text-slate-100 mb-3 sm:mb-4">
                                    {{ __('Enable Two-Factor Authentication') }}</h3>
                                <p class="text-sm sm:text-base text-slate-600 dark:text-slate-300 leading-relaxed">
                                    {{ __('When two-factor authentication is enabled, you will be prompted for a secure, random token during authentication. You may retrieve this token from your phone\'s Google Authenticator, Authy, or any compatible authenticator application.') }}
                                </p>
                            </div>

                            <x-ui.button class="w-full sm:w-auto mx-auto px-6 sm:px-8 py-3" onclick="openEnableModal()">
                                <span class="text-text-white text-sm sm:text-base font-semibold">
                                    {{ __('Enable Two-Factor Authentication') }}
                                </span>
                            </x-ui.button>
                        </div>
                    @else
                        <!-- QR Code Section -->
                        @if (!auth()->user()->two_factor_confirmed_at)
                            <div class="space-y-4 sm:space-y-6 mb-6 sm:mb-8">
                                <div>
                                    <h3
                                        class="text-xl sm:text-2xl font-bold text-slate-800 dark:text-slate-100 mb-3 sm:mb-4">
                                        {{ __('Finish Enabling Two-Factor Authentication') }}</h3>
                                    <p
                                        class="text-sm sm:text-base text-slate-600 dark:text-slate-300 leading-relaxed mb-4 sm:mb-6">
                                        {{ __('To finish enabling two-factor authentication, scan the following QR code using your phone\'s authenticator application or enter the setup key and provide the generated OTP code.') }}
                                    </p>
                                </div>

                                <!-- QR Code Display -->
                                <div
                                    class="bg-gradient-to-br from-slate-50 to-slate-100 dark:from-slate-800 dark:to-slate-700 rounded-lg sm:rounded-xl p-4 sm:p-6 md:p-8 border-2 border-dashed border-purple-300 dark:border-purple-700">
                                    <div id="qrCode"
                                        class="flex flex-col items-center justify-center space-y-3 sm:space-y-4">
                                        <svg class="w-16 h-16 sm:w-20 sm:h-20 text-purple-600 dark:text-purple-400"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                                            </path>
                                        </svg>
                                        <button type="button" onclick="loadQRCode()"
                                            class="w-full sm:w-auto px-4 sm:px-6 py-2.5 sm:py-3 bg-purple-600 text-white text-sm sm:text-base font-semibold rounded-lg hover:bg-purple-700 transition-all duration-200 shadow-md">
                                            {{ __('Show QR Code') }}
                                        </button>
                                    </div>
                                    <div id="qrCodeContainer" class="hidden">
                                        <div
                                            class="bg-white dark:bg-slate-800 p-4 sm:p-6 md:p-8 rounded-lg text-center mb-4 sm:mb-6">
                                        </div>
                                        {{-- <div class="bg-white dark:bg-slate-800 p-3 sm:p-4 rounded-lg">
                                            <p
                                                class="text-xs sm:text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">
                                                {{ __('Security key:') }}</p>
                                            <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2">
                                                <code id="securityKey"
                                                    class="flex-1 p-2 sm:p-3 bg-slate-100 dark:bg-slate-700 rounded text-xs font-mono break-all text-slate-800 dark:text-slate-200"></code>
                                                <button onclick="copySecurityKey()"
                                                    class="p-2 sm:p-3 hover:bg-slate-200 dark:hover:bg-slate-600 rounded transition-colors self-center"
                                                    title="Copy to clipboard">
                                                    <svg class="w-5 h-5 text-slate-600 dark:text-slate-400"
                                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z">
                                                        </path>
                                                    </svg>
                                                </button>
                                            </div>
                                        </div> --}}
                                    </div>
                                </div>

                                <!-- Confirm 2FA -->
                                <div
                                    class="bg-white dark:bg-slate-800 p-4 sm:p-6 rounded-lg sm:rounded-xl border border-slate-200 dark:border-slate-700">
                                    <button type="button" onclick="openConfirmModal()"
                                        class="w-full px-4 sm:px-6 py-3 sm:py-4 bg-gradient-to-r from-green-600 to-emerald-600 text-white text-sm sm:text-base font-semibold rounded-lg hover:from-green-700 hover:to-emerald-700 transition-all duration-200 shadow-md hover:shadow-lg">
                                        {{ __('Enter Verification Code') }}
                                    </button>
                                </div>
                            </div>
                        @endif

                        <!-- Recovery Codes Section -->
                        @if (auth()->user()->two_factor_confirmed_at)
                            <div class="border-t border-slate-200 dark:border-slate-700 pt-6 sm:pt-8 mb-6 sm:mb-8">
                                <div class="mb-4 sm:mb-6">
                                    <h3
                                        class="text-xl sm:text-2xl font-bold text-slate-800 dark:text-slate-100 mb-3 sm:mb-4">
                                        {{ __('Recovery Codes') }}</h3>
                                    <p class="text-sm sm:text-base text-slate-600 dark:text-slate-300 leading-relaxed">
                                        {{ __('Store these recovery codes in a secure password manager. They can be used to recover access to your account if your two-factor authentication device is lost.') }}
                                    </p>
                                </div>

                                <button type="button" onclick="showRecoveryCodes()"
                                    class="w-full sm:w-auto px-4 sm:px-6 py-2.5 sm:py-3 bg-purple-600 text-white text-sm sm:text-base font-semibold rounded-lg hover:bg-purple-700 transition-all duration-200 shadow-md mb-4 sm:mb-6">
                                    {{ __('Show Recovery Codes') }}
                                </button>

                                <div id="recoveryCodes" class="hidden mb-4 sm:mb-6 fade-in">
                                    <div
                                        class="bg-gradient-to-br from-slate-50 to-slate-100 dark:from-slate-800 dark:to-slate-700 p-4 sm:p-6 border-2 border-purple-200 dark:border-purple-800 rounded-lg sm:rounded-xl">
                                        <div id="recoveryCodesList"
                                            class="grid grid-cols-1 sm:grid-cols-2 gap-2 sm:gap-3">
                                            <!-- Codes loaded here via JavaScript -->
                                        </div>
                                    </div>
                                    <p
                                        class="text-xs sm:text-sm text-slate-600 dark:text-slate-400 mt-2 sm:mt-3 flex items-start gap-2">
                                        <span class="text-base sm:text-lg flex-shrink-0">💡</span>
                                        <span>{{ __('Save these codes in a safe place. Each code can only be used once.') }}</span>
                                    </p>
                                </div>

                                <button type="button" onclick="openRegenerateModal()"
                                    class="w-full sm:w-auto px-4 sm:px-6 py-2.5 sm:py-3 bg-slate-600 text-white text-sm sm:text-base font-semibold rounded-lg hover:bg-slate-700 transition-all duration-200 shadow-md">
                                    {{ __('Regenerate Recovery Codes') }}
                                </button>
                            </div>
                        @endif

                        <!-- Two-Factor Authentication Actions -->
                        @if (is_null(auth()->user()->two_factor_confirmed_at))
                            <!-- Cancel 2FA Processing -->
                            <div class="border-t border-slate-200 dark:border-slate-700 pt-6 sm:pt-8">
                                <h3 class="text-lg sm:text-xl font-bold text-red-600 dark:text-red-400 mb-3 sm:mb-4">
                                    {{ __('Cancel Processing') }}</h3>
                                <p
                                    class="text-sm sm:text-base text-slate-600 dark:text-slate-300 mb-4 flex items-start gap-2">
                                    <span class="text-lg sm:text-xl flex-shrink-0">⚠️</span>
                                    <span><strong>{{ __('Warning:') }}</strong>
                                        {{ __('Canceling two-factor authentication processing will make your account significantly less secure.') }}</span>
                                </p>

                                <button type="button" onclick="openDisableModal()"
                                    class="w-full sm:w-auto px-4 sm:px-6 py-2.5 sm:py-3 bg-red-600 text-white text-sm sm:text-base font-semibold rounded-lg hover:bg-red-700 transition-all duration-200 shadow-md">
                                    {{ __('Cancel Processing') }}
                                </button>
                            </div>
                        @else
                            <!-- Disable 2FA -->
                            <div class="border-t border-slate-200 dark:border-slate-700 pt-6 sm:pt-8">
                                <h3 class="text-lg sm:text-xl font-bold text-red-600 dark:text-red-400 mb-3 sm:mb-4">
                                    {{ __('Disable Two-Factor Authentication') }}</h3>
                                <p
                                    class="text-sm sm:text-base text-slate-600 dark:text-slate-300 mb-4 flex items-start gap-2">
                                    <span class="text-lg sm:text-xl flex-shrink-0">⚠️</span>
                                    <span><strong>{{ __('Warning:') }}</strong>
                                        {{ __('Disabling two-factor authentication will make your account significantly less secure.') }}</span>
                                </p>

                                <button type="button" onclick="openDisableModal()"
                                    class="w-full sm:w-auto px-4 sm:px-6 py-2.5 sm:py-3 bg-red-600 text-white text-sm sm:text-base font-semibold rounded-lg hover:bg-red-700 transition-all duration-200 shadow-md">
                                    {{ __('Disable Two-Factor Authentication') }}
                                </button>
                            </div>
                        @endif
                    @endif
                </div>
            </div>

            <!-- Back to Dashboard -->
            <div class="mt-6 sm:mt-8 text-center pb-4">
                <a href="{{ route('user.order.purchased-orders') }}"
                    class="inline-flex items-center gap-2 text-purple-600 dark:text-purple-400 hover:text-purple-700 dark:hover:text-purple-300 text-sm sm:text-base font-semibold transition-colors">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7">
                        </path>
                    </svg>
                    {{ __('Back to Dashboard') }}
                </a>
            </div>
        </div>
    </div>

    <!-- Modal: Enable 2FA -->
    <div id="enableModal" class="fixed inset-0 z-50 hidden items-center justify-center p-4">
        <div class="modal-backdrop absolute inset-0" onclick="closeEnableModal()"></div>
        <div
            class="modal-content relative bg-white dark:bg-slate-800 rounded-xl sm:rounded-2xl shadow-2xl max-w-md w-full p-6 sm:p-8 z-10 max-h-[90vh] overflow-y-auto">
            <button onclick="closeEnableModal()"
                class="absolute top-3 right-3 sm:top-4 sm:right-4 text-slate-400 hover:text-slate-600 dark:hover:text-slate-200">
                <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
            </button>
            <div class="flex items-start gap-3 mb-4 sm:mb-6">
                <div class="p-2 sm:p-3 bg-purple-100 dark:bg-purple-900 rounded-full flex-shrink-0">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-purple-600 dark:text-purple-400" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                        </path>
                    </svg>
                </div>
                <h3 class="text-xl sm:text-2xl font-bold text-slate-800 dark:text-slate-100">{{ __('Enable 2FA') }}
                </h3>
            </div>
            <p class="text-sm sm:text-base text-slate-600 dark:text-slate-300 mb-4 sm:mb-6">
                {{ __('Are you ready to enable two-factor authentication for enhanced security?') }}
            </p>
            <div class="flex flex-col sm:flex-row gap-3">
                <button onclick="closeEnableModal()"
                    class="flex-1 px-4 py-2.5 sm:py-3 bg-slate-200 dark:bg-slate-700 text-slate-700 dark:text-slate-300 text-sm sm:text-base font-semibold rounded-lg hover:bg-slate-300 dark:hover:bg-slate-600 transition-all">
                    {{ __('Cancel') }}
                </button>
                <form method="POST" action="{{ route('user.two-factor.enable') }}" class="flex-1">
                    @csrf
                    <button type="submit"
                        class="w-full px-4 py-2.5 sm:py-3 bg-gradient-to-r from-purple-600 to-indigo-600 text-white text-sm sm:text-base font-semibold rounded-lg hover:from-purple-700 hover:to-indigo-700 transition-all">
                        {{ __('Enable') }}
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal: Confirm 2FA Code -->
    <div id="confirmModal" class="fixed inset-0 z-50 hidden items-center justify-center px-4">
        <div class="modal-backdrop absolute inset-0" onclick="closeConfirmModal()"></div>
        <div class="modal-content relative bg-white dark:bg-slate-800 rounded-2xl shadow-2xl max-w-md w-full p-8 z-10">
            <button onclick="closeConfirmModal()"
                class="absolute top-4 right-4 text-slate-400 hover:text-slate-600 dark:hover:text-slate-200">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
            </button>
            <div class="flex items-center gap-3 mb-6">
                <div class="p-3 bg-green-100 dark:bg-green-900 rounded-full">
                    <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-slate-800 dark:text-slate-100">{{ __('Setup Authenticator') }}</h3>
            </div>
            <p class="text-slate-600 dark:text-slate-300 mb-6">
                {{ __('Enter the 6-digit code you see in the app.') }}
            </p>
            <div id="confirmError"
                class="hidden mb-4 p-3 bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-800 rounded-lg text-red-600 dark:text-red-400 text-sm">
            </div>
            <input type="text" id="confirmCode" placeholder="123456" maxlength="6"
                class="w-full px-4 py-4 text-lg font-mono text-center bg-slate-50 dark:bg-slate-700 border-2 border-slate-300 dark:border-slate-600 rounded-lg focus:border-purple-500 focus:ring-2 focus:ring-purple-200 dark:focus:ring-purple-800 outline-none transition-all mb-6 text-slate-800 dark:text-slate-100"
                oninput="this.value = this.value.replace(/[^0-9]/g, '')">
            <div class="flex gap-3">
                <button onclick="closeConfirmModal()"
                    class="flex-1 px-4 py-3 bg-slate-200 dark:bg-slate-700 text-slate-700 dark:text-slate-300 font-semibold rounded-lg hover:bg-slate-300 dark:hover:bg-slate-600 transition-all">
                    {{ __('Back') }}
                </button>
                <button onclick="submitConfirmCode()"
                    class="flex-1 px-4 py-3 bg-gradient-to-r from-green-600 to-emerald-600 text-white font-semibold rounded-lg hover:from-green-700 hover:to-emerald-700 transition-all disabled:opacity-50">
                    {{ __('Verify') }}
                </button>
            </div>
        </div>
    </div>

    <!-- Modal: Disable/Cancel 2FA -->
    <div id="disableModal" class="fixed inset-0 z-50 hidden items-center justify-center px-4">
        <div class="modal-backdrop absolute inset-0" onclick="closeDisableModal()"></div>
        <div class="modal-content relative bg-white dark:bg-slate-800 rounded-2xl shadow-2xl max-w-md w-full p-8 z-10">
            <button onclick="closeDisableModal()"
                class="absolute top-4 right-4 text-slate-400 hover:text-slate-600 dark:hover:text-slate-200">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
            </button>
            <div class="flex items-center gap-3 mb-6">
                <div class="p-3 bg-red-100 dark:bg-red-900 rounded-full">
                    <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                        </path>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-slate-800 dark:text-slate-100">{{ __('Confirm Action') }}</h3>
            </div>
            <p class="text-slate-600 dark:text-slate-300 mb-6">
                <span class="font-semibold text-red-600 dark:text-red-400">{{ __('Warning:') }}</span>
                @if (is_null(auth()->user()->two_factor_confirmed_at ?? null))
                    {{ __('Are you sure you want to cancel two-factor authentication processing?') }}
                @else
                    {{ __('Are you sure you want to disable two-factor authentication? This will make your account less secure.') }}
                @endif
            </p>
            <div class="flex gap-3">
                <button onclick="closeDisableModal()"
                    class="flex-1 px-4 py-3 bg-slate-200 dark:bg-slate-700 text-slate-700 dark:text-slate-300 font-semibold rounded-lg hover:bg-slate-300 dark:hover:bg-slate-600 transition-all">
                    {{ __('Cancel') }}
                </button>
                <form method="POST" action="{{ route('user.two-factor.disable') }}" class="flex-1">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="w-full px-4 py-3 bg-gradient-to-r from-red-600 to-red-700 text-white font-semibold rounded-lg hover:from-red-700 hover:to-red-800 transition-all">
                        {{ __('Confirm') }}
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal: Regenerate Codes -->
    <div id="regenerateModal" class="fixed inset-0 z-50 hidden items-center justify-center px-4">
        <div class="modal-backdrop absolute inset-0" onclick="closeRegenerateModal()"></div>
        <div class="modal-content relative bg-white dark:bg-slate-800 rounded-2xl shadow-2xl max-w-md w-full p-8 z-10">
            <button onclick="closeRegenerateModal()"
                class="absolute top-4 right-4 text-slate-400 hover:text-slate-600 dark:hover:text-slate-200">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
            </button>
            <div class="flex items-center gap-3 mb-6">
                <div class="p-3 bg-amber-100 dark:bg-amber-900 rounded-full">
                    <svg class="w-6 h-6 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                        </path>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-slate-800 dark:text-slate-100">{{ __('Regenerate Codes') }}</h3>
            </div>
            <p class="text-slate-600 dark:text-slate-300 mb-6">
                {{ __('This will invalidate all your old recovery codes. Are you sure you want to continue?') }}
            </p>
            <div class="flex gap-3">
                <button onclick="closeRegenerateModal()"
                    class="flex-1 px-4 py-3 bg-slate-200 dark:bg-slate-700 text-slate-700 dark:text-slate-300 font-semibold rounded-lg hover:bg-slate-300 dark:hover:bg-slate-600 transition-all">
                    {{ __('Cancel') }}
                </button>
                <form method="POST" action="{{ route('user.two-factor.recovery-codes.store') }}" class="flex-1">
                    @csrf
                    <button type="submit"
                        class="w-full px-4 py-3 bg-gradient-to-r from-amber-600 to-orange-600 text-white font-semibold rounded-lg hover:from-amber-700 hover:to-orange-700 transition-all">
                        {{ __('Regenerate') }}
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Modal functions
        function openEnableModal() {
            document.getElementById('enableModal').classList.remove('hidden');
            document.getElementById('enableModal').classList.add('flex');
        }

        function closeEnableModal() {
            document.getElementById('enableModal').classList.add('hidden');
            document.getElementById('enableModal').classList.remove('flex');
        }

        function openConfirmModal() {
            document.getElementById('confirmModal').classList.remove('hidden');
            document.getElementById('confirmModal').classList.add('flex');
            document.getElementById('confirmCode').focus();
        }

        function closeConfirmModal() {
            document.getElementById('confirmModal').classList.add('hidden');
            document.getElementById('confirmModal').classList.remove('flex');
            document.getElementById('confirmCode').value = '';
            document.getElementById('confirmError').classList.add('hidden');
        }

        function openDisableModal() {
            document.getElementById('disableModal').classList.remove('hidden');
            document.getElementById('disableModal').classList.add('flex');
        }

        function closeDisableModal() {
            document.getElementById('disableModal').classList.add('hidden');
            document.getElementById('disableModal').classList.remove('flex');
        }

        function openRegenerateModal() {
            document.getElementById('regenerateModal').classList.remove('hidden');
            document.getElementById('regenerateModal').classList.add('flex');
        }

        function closeRegenerateModal() {
            document.getElementById('regenerateModal').classList.add('hidden');
            document.getElementById('regenerateModal').classList.remove('flex');
        }

        // Submit confirmation code
        function submitConfirmCode() {
            const code = document.getElementById('confirmCode').value;
            if (code.length !== 6) {
                const errorDiv = document.getElementById('confirmError');
                errorDiv.textContent = '{{ __('Please enter a valid 6-digit code') }}';
                errorDiv.classList.remove('hidden');
                return;
            }

            // Create and submit form
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route('user.two-factor.confirm') }}';

            const csrfInput = document.createElement('input');
            csrfInput.type = 'hidden';
            csrfInput.name = '_token';
            csrfInput.value = '{{ csrf_token() }}';

            const codeInput = document.createElement('input');
            codeInput.type = 'hidden';
            codeInput.name = 'code';
            codeInput.value = code;

            form.appendChild(csrfInput);
            form.appendChild(codeInput);
            document.body.appendChild(form);
            form.submit();
        }

        // Load QR Code
        function loadQRCode() {
            fetch('{{ route('user.two-factor.qr-code') }}')
                .then(response => response.json())
                .then(data => {
                    const container = document.getElementById('qrCodeContainer');
                    const qrDiv = container.querySelector('.bg-white');
                    qrDiv.innerHTML = data.svg;

                    // Extract and display security key from SVG or use API
                    const keyElement = document.getElementById('securityKey');
                    if (data.key) {
                        keyElement.textContent = data.key;
                    }

                    document.getElementById('qrCodeContainer').classList.remove('hidden');
                    document.getElementById('qrCode').classList.add('hidden');
                })
                .catch(error => {
                    console.error('Error loading QR code:', error);
                    alert('{{ __('Failed to load QR code. Please try again.') }}');
                });
        }

        // Copy security key
        function copySecurityKey() {
            const key = document.getElementById('securityKey').textContent;
            navigator.clipboard.writeText(key).then(() => {
                // Show temporary success message
                const btn = event.currentTarget;
                const originalHTML = btn.innerHTML;
                btn.innerHTML =
                    '<svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>';
                setTimeout(() => {
                    btn.innerHTML = originalHTML;
                }, 2000);
            });
        }

        // Show recovery codes
        function showRecoveryCodes() {
            fetch('{{ route('user.two-factor.recovery-codes') }}')
                .then(response => response.json())
                .then(codes => {
                    const container = document.getElementById('recoveryCodesList');
                    container.innerHTML = codes.map(code =>
                        `<div class="p-4 bg-white dark:bg-slate-800 border-2 border-purple-200 dark:border-purple-700 rounded-lg text-center font-bold font-mono text-sm hover:border-purple-400 dark:hover:border-purple-500 transition-all cursor-pointer group" onclick="copyCode('${code}')">
                            <span class="text-slate-800 dark:text-slate-200">${code}</span>
                            <svg class="w-4 h-4 inline-block ml-2 opacity-0 group-hover:opacity-100 transition-opacity text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                            </svg>
                        </div>`
                    ).join('');
                    document.getElementById('recoveryCodes').classList.remove('hidden');
                })
                .catch(error => {
                    console.error('Error loading recovery codes:', error);
                    alert('{{ __('Failed to load recovery codes. Please try again.') }}');
                });
        }

        // Copy individual recovery code
        function copyCode(code) {
            navigator.clipboard.writeText(code);
        }

        // Close modals on Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeEnableModal();
                closeConfirmModal();
                closeDisableModal();
                closeRegenerateModal();
            }
        });

        // Handle Enter key in confirmation code input
        document.getElementById('confirmCode')?.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                submitConfirmCode();
            }
        });
    </script>
</x-frontend::app>
