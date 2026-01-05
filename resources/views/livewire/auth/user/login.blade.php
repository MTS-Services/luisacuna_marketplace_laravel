<div class="bg-cover bg-center bg-page-login">
    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            passwordInput.type = passwordInput.type === 'password' ? 'text' : 'password';
        }
    </script>

    <div class="min-h-[100vh] flex items-center justify-center text-white px-4 sm:px-6 lg:px-8">
        <form method="POST" wire:submit.prevent="login" class="w-full max-w-md sm:max-w-lg md:max-w-xl">
            <div
                class="bg-zinc-900/40 dark:bg-bg-secondary/75 backdrop-blur-sm dark:backdrop-blur-sm rounded-2xl p-8 sm:p-20 my-20 shadow-lg flex flex-col justify-between min-h-[75vh]">

                <!-- Header -->
                <div class="mb-5 sm:mb-11 text-center">
                    <div class="flex justify-center items-center h-[102px] mb-5 sm:mb-11">
                        <img src="{{ asset('assets/images/background/login-logo.png') }}" alt=""
                            class="max-w-full max-h-full object-contain">
                    </div>
                    <h2 class="text-3xl sm:text-4xl font-medium text-white mb-3">{{ __('Sign in') }}</h2>
                    <p class="text-white font-normal lg:text-xl sm:text-lg mt-2">
                        {{ __('Hi! Welcome back, you\'ve been missed') }}
                    </p>
                </div>

                <!-- Email -->
                <div class="space-y-6">
                    <div class="mb-4 sm:mb-7 px-2 sm:px-7">
                        <label
                            class="block text-lg sm:text-2xl font-medium mb-1 sm:mb-4 text-white">{{ __('Email') }}</label>
                        <x-ui.input type="email" placeholder="example@gmail.com" wire:model="email"
                            class="bg-bg-info! rounded-xl! border-0! focus:ring-0! text-white! placeholder:text-white!" />
                        <x-ui.input-error :messages="$errors->get('email')" />
                    </div>

                    <!-- Error message -->
                    @error('message')
                        <span class="text-pink-500 text-sm mt-1">{{ $message }}</span>
                    @enderror

                    <!-- Password -->
                    <div class="mb-4 sm:mb-7 px-2 sm:px-6">
                        <x-ui.label
                            class="block text-lg sm:text-2xl font-medium mb-1 sm:mb-4 text-white">{{ __('Password') }}</x-ui.label>
                        <x-ui.input type="password" id="password" placeholder="Aex@8465" wire:model="password"
                            class="bg-bg-info! rounded-xl! border-0! focus:ring-0! text-white! placeholder:text-white!" />
                        <x-ui.input-error :messages="$errors->get('password')" />
                    </div>
                </div>

                @if (Route::has('password.request'))
                    <div class="text-right px-2 sm:px-6 mb-5 sm:mb-12">
                        <a href="{{ route('password.request') }}" wire:navigate
                            class="text-md text-pink-500 hover:underline">
                            {{ __('Forgot password?') }}
                        </a>
                    </div>
                @endif

                <!-- Sign in button -->
                <div class="flex justify-center px-2 sm:px-6 mb-5 sm:mb-11">
                    <x-ui.button type="submit" class="w-auto py-2! text-white text-base! font-semibold!">
                        {{ __('Sign in') }}
                    </x-ui.button>
                </div>

                <!-- Divider -->
                <div class="flex items-center mb-5 sm:mb-11 px-4">
                    <hr class="flex-1 border-white" />
                    <span class="px-3 text-base font-normal text-white">{{ __('Or sign in with') }}</span>
                    <hr class="flex-1 border-white" />
                </div>

                <div>
                    <!-- Social login -->
                    <div class="flex justify-center gap-4 mb-4 sm:mb-8">
                        <a href="{{ route('google.redirect') }}"
                            class="w-14 h-14 p-3.5 flex items-center justify-center bg-bg-white rounded-md">
                            <img src="{{ asset('assets/icons/icons8-google.svg') }}" class="w-full h-full rounded-md"
                                alt="Google" />
                        </a>
                        <a href="{{ route('apple.login') }}"
                            class="w-14 h-14 p-3.5 flex items-center justify-center bg-bg-white rounded-md">
                            <img src="{{ asset('assets/icons/icons8-apple-logo.svg') }}"
                                class="w-full h-full rounded-md" alt="Apple" />
                        </a>
                        <a href="{{ route('auth.facebook') }}"
                            class="w-14 h-14 p-3.5 flex items-center justify-center bg-bg-white rounded-md">
                            <img src="{{ asset('assets/icons/facebook.svg') }}" class="w-full h-full rounded-md"
                                alt="Facebook" />
                        </a>
                    </div>

                    <!-- Sign up link -->
                    <div class="text-center text-base font-normal text-white">
                        {{ __(' Don\'t have an account?') }}
                        <a href="{{ route('register.signUp') }}"
                            class="text-pink-500 text-base font-normal hover:underline">{{ __('Sign up') }}</a>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Firebase FCM Integration - Only for notifications -->
    @push('scripts')
        <script type="module">
            // Firebase configuration
            const firebaseConfig = {
                apiKey: "AIzaSyAHRdYjEG3k1JzYR7OW31bLfC71qi0UNCY",
                authDomain: "skywalker-notification.firebaseapp.com",
                projectId: "skywalker-notification",
                storageBucket: "skywalker-notification.firebasestorage.app",
                messagingSenderId: "624087602629",
                appId: "1:624087602629:web:e0bd6c7aaef5ccea2c27ac",
                measurementId: "G-QZWS5CXB81"
            };

            const vapidKey = "BMP4uIYiZZxGFnZWbQR5Ak93lcODHEZedo8A19Lpm7CV3OG31oE5a6aSmF0c6XnFHAxbN0C19b2TWZv6aUaF8uA";

            // Check if Firebase is supported in this browser
            if ('serviceWorker' in navigator && 'Notification' in window) {
                import('https://www.gstatic.com/firebasejs/10.7.1/firebase-app.js').then(({
                    initializeApp
                }) => {
                    import('https://www.gstatic.com/firebasejs/10.7.1/firebase-messaging.js').then(({
                        getMessaging,
                        getToken,
                        onMessage
                    }) => {

                        try {
                            const app = initializeApp(firebaseConfig);
                            const messaging = getMessaging(app);

                            // Request notification permission
                            if (Notification.permission === 'default') {
                                Notification.requestPermission().then((permission) => {
                                    if (permission === 'granted') {
                                        registerFCMToken(messaging);
                                    }
                                });
                            } else if (Notification.permission === 'granted') {
                                registerFCMToken(messaging);
                            }

                            // Handle foreground messages - Just show notification
                            onMessage(messaging, (payload) => {
                                console.log('Message received in foreground:', payload);

                                // Show notification
                                if (payload.notification) {
                                    new Notification(payload.notification.title, {
                                        body: payload.notification.body,
                                        icon: '/assets/images/logo.png'
                                    });
                                }

                                // If it's a logout notification, inform user to reload
                                if (payload.data && payload.data.type === 'force_logout') {
                                    console.log(
                                        'Logout notification received - please navigate or reload page to complete logout'
                                        );
                                }
                            });

                        } catch (error) {
                            console.error('Firebase initialization error:', error);
                        }

                        function registerFCMToken(messaging) {
                            getToken(messaging, {
                                vapidKey: vapidKey
                            }).then((token) => {
                                if (token) {
                                    console.log('FCM Token:', token);
                                    // Send token to Livewire component
                                    @this.call('setFcmToken', token);
                                    localStorage.setItem('fcm_token', token);
                                }
                            }).catch((error) => {
                                console.error('Error getting FCM token:', error);
                            });
                        }

                    });
                });
            }
        </script>
    @endpush
</div>
