<!DOCTYPE html>
<html lang="en" class="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>
        {{ isset($title) ? $title . ' - ' : '' }}
        {{ site_name() }}
    </title>
     @php
    $cloudinaryService = new \App\Services\Cloudinary\CloudinaryService();
    @endphp
    <link rel="shortcut icon" href="{{ $cloudinaryService->getUrlFromPublicId(app_favicon()) }}" type="image/x-icon">
    @vite(['resources/css/app.css', 'resources/js/app.js'])


    @fluxAppearance()
    <script>
        document.addEventListener('livewire:initialized', function() {
            Livewire.on('notify', (event) => {
                showAlert(event.type, event.message);
            });
        });
    </script>
    <style>
        [x-cloak] {
            display: none !important;
        }

        /* .bg-page {
            background-image: url('{{ asset('/assets/images/background/light_background.png') }}');
            background-attachment: fixed;
            background-position: 100% 100%;
            background-size: cover;
        } */
        .bg-page {
            position: relative;
            background-image: url('{{ asset('/assets/images/background/light_background.png') }}');
            background-attachment: fixed;
            background-position: 100% 100%;
            background-size: cover;
            /* overflow: hidden; */
        }

        .bg-page::before {
            content: "";
            position: absolute;
            inset: 0;
            background: rgba(255, 255, 255, 0.548);
            z-index: 1;
        }

        .bg-page>* {
            position: relative;
            z-index: 2;
        }

        .dark .bg-page {
            background-image: url('{{ asset('/assets/images/background/dark_background.png') }}') !important;
            background-attachment: fixed;
            background-position: 100% 100%;
            background-size: cover;
        }

        .dark .bg-page::before {
            content: none;
            display: none;
        }

        .dark .bg-page-login {
            background-image: url('{{ asset('/assets/images/background/login-dark-background.png') }}');
            background-attachment: fixed;
            background-position: 100% 100%;
            background-size: cover;
        }

        .bg-page-login {
            background-image: url('{{ asset('/assets/images/background/login-light-background.png') }}');
            background-attachment: fixed;
            background-position: 100% 100%;
            background-size: cover;
        }
    </style>
    @stack('styles')
</head>

<body class="min-h-screen flex flex-col bg-bg-secondary text-text-primary">


    @if (
        !(request()->routeIs('login') ||
            request()->routeIs('register.signUp') ||
            request()->routeIs('register.emailVerify') ||
            request()->routeIs('register.otp') ||
            request()->routeIs('register.password') ||
            request()->routeIs('password.request') ||
            request()->routeIs('password.reset') ||
            request()->routeIs('verify-reset-otp') ||
            request()->routeIs('verification.notice') ||
            request()->routeIs('verify-otp') ||
            request()->routeIs('verification.verify') ||
            request()->routeIs('two-factor.*') ||
            request()->routeIs('two-factor.login') ||
            request()->routeIs('two-factor.login.store') ||
            request()->routeIs('admin.*')
        ))
        <livewire:frontend.partials.header />
    @endif
    <main class="flex-1">
        {{ $slot }}
    </main>
    @if (
        !(request()->routeIs('login') ||
            request()->routeIs('register.signUp') ||
            request()->routeIs('register.emailVerify') ||
            request()->routeIs('register.otp') ||
            request()->routeIs('register.password') ||
            request()->routeIs('password.request') ||
            request()->routeIs('password.reset') ||
            request()->routeIs('verify-reset-otp') ||
            request()->routeIs('verification.notice') ||
            request()->routeIs('verify-otp') ||
            request()->routeIs('verification.verify') ||
            request()->routeIs('two-factor.*') ||
            request()->routeIs('two-factor.login') ||
            request()->routeIs('two-factor.login.store') ||
            request()->routeIs('admin.*')
        ))
        <livewire:frontend.partials.footer />
    @endif

    <div id="navigation-loader" x-transition.opacity
        class="fixed inset-0 z-50 flex items-center justify-center bg-bg-primary/50 backdrop-blur-md">
        <div class="flex space-x-2">
            <div class="w-4 h-4 rounded-full bg-accent animate-[bounce-dot_1.2s_infinite]"
                style="animation-delay: -0.8s;"></div>
            <div class="w-4 h-4 rounded-full bg-accent-foreground animate-[bounce-dot_1.2s_infinite]"
                style="animation-delay: -0.4s;"></div>
            <div class="w-4 h-4 rounded-full bg-accent animate-[bounce-dot_1.2s_infinite]"></div>
        </div>
    </div>

    @fluxScripts()


    <script>
        document.addEventListener('livewire:navigate', (event) => {
            document.getElementById('navigation-loader').classList.remove('hidden');
        });
        document.addEventListener('livewire:navigating', () => {
            document.getElementById('navigation-loader').classList.remove('hidden');
        });
        document.addEventListener('livewire:navigated', () => {
            document.getElementById('navigation-loader').classList.add('hidden');
        });
        document.addEventListener('livewire:initialized', () => {

            // ✅ Public channel for all users
            window.Echo.channel('users')
                .listen('.notification.sent', (e) => {
                    console.log('📢 User notification received:', e);
                    window.toast.info(e.title || 'New Notification Received');
                    Livewire.dispatch('notification-updated');
                })
                .subscribed(() => {
                    console.log('✅ Subscribed to users channel');
                })
                .error((error) => {
                    console.error('❌ Error on users channel:', error);
                });

            // ✅ Private channel for specific user (if authenticated as user)
            @if (auth()->guard('web')->check())
                window.Echo.private('user.{{ auth()->guard('web')->id() }}')
                    .listen('.notification.sent', (e) => {
                        console.log('🔒 Private user notification received:', e);
                        window.toast.info(e.title || 'New Notification Received');
                        Livewire.dispatch('notification-updated');
                    })
                    .subscribed(() => {
                        console.log('✅ Subscribed to private user channel');
                    })
                    .error((error) => {
                        console.error('❌ Error on private user channel:', error);
                    });
            @endif

            @if (auth()->guard('admin')->check())
                window.Echo.private('admin.{{ admin()->id }}')
                    .listen('.notification.sent', (e) => {
                        console.log('✅ Notification received on private channel:', e);
                        window.toast.info(e.title || 'New Notification Received');
                        Livewire.dispatch('notification-updated');
                    })
                    .subscribed(() => {
                        console.log('✅ Successfully subscribed to private admin channel');
                    })
                    .error((error) => {
                        console.error('❌ Error on private admin channel:', error);
                    });
            @endif
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            console.log('🚀 Livewire initialized');
            // Handle Livewire errors (401 from middleware)
            document.addEventListener('livewire:response', function(event) {
                const response = event.detail.response;

                if (response && response.status === 401) {
                    console.log('Session terminated by server (401)');
                    handleSessionTermination();
                }
            });

            // Handle fetch/axios errors globally
            window.addEventListener('unhandledrejection', function(event) {
                if (event.reason && event.reason.response && event.reason.response.status === 401) {
                    console.log('Session terminated (401 from fetch)');
                    handleSessionTermination();
                }
            });

            // Intercept Livewire requests
            if (typeof Livewire !== 'undefined') {
                Livewire.hook('request', ({
                    respond
                }) => {
                    respond(({
                        status,
                        response
                    }) => {
                        if (status === 401) {
                            console.log('Session terminated by Livewire (401)');
                            handleSessionTermination();
                        }
                    });
                });
            }

            function handleSessionTermination() {
                // Clear everything
                localStorage.clear();
                sessionStorage.clear();

                // Show message
                alert('Your session has been terminated. Please login again.');

                // Force redirect to login (hard reload)
                window.location.href = '{{ route('login') }}';

                // If somehow the above doesn't work, force reload
                setTimeout(() => {
                    window.location.reload(true);
                }, 100);
            }
        });
    </script>
    @stack('scripts')
</body>

</html>
