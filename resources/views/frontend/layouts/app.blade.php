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
    <link rel="shortcut icon" href="{{ storage_url(app_favicon()) }}" type="image/x-icon">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @fluxAppearance()
    <script>
        document.addEventListener('livewire:initialized', function() {
            Livewire.on('notify', (event) => {
                showAlert(event.type, event.message);
            });
        });
    </script>
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

    <div id="notification-toast"
        class="absolute top-5 right-5 w-72 z-50 rounded-2xl shadow-2xl bg-white text-black transition-all duration-500 ease-in-out transform translate-x-full">
        <div class="p-4 flex items-center justify-between gap-4">
            <div class="flex items-center gap-3 flex-grow">
                <flux:icon name="information-circle" class="w-6 h-6 stroke-blue-500 flex-shrink-0" />
                <p id="notification-message" class="text-sm leading-snug font-normal"></p>
            </div>
            <button id="close-notification-btn"
                class="flex-shrink-0 p-1 rounded-full hover:bg-gray-100 transition-colors duration-200">
                <flux:icon name="x-mark" class="w-5 h-5" />
            </button>
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

            window.Echo.channel('users')
                .listen('.notification.sent', (e) => {
                    console.log(e);
                    showNotification(e.title || 'New message received.');
                    Livewire.dispatch('notification-updated');
                });

            if ('{{ auth()->check() }}') {
                window.Echo.private('user.{{ user()->id }}')
                    .listen('.notification.sent', (e) => {
                        console.log(e);
                        showNotification(e.title || 'New message received.');
                        Livewire.dispatch('notification-updated');
                    });
            }


            function showNotification(message) {
                const toast = document.getElementById('notification-toast');
                const messageElement = document.getElementById('notification-message');
                const closeButton = document.getElementById('close-notification-btn');

                if (!toast || !messageElement || !closeButton) {
                    console.error('Notification elements not found.');
                    return;
                }

                // Set the message
                messageElement.textContent = message;

                // Show the notification with animation
                toast.classList.remove('hidden');
                toast.classList.remove('translate-x-full', 'opacity-0');
                toast.classList.add('translate-x-0', 'opacity-100');

                // Automatic dismissal after 3 seconds
                const timeoutId = setTimeout(() => {
                    hideNotification();
                }, 3000); // 3 seconds

                // Manual dismissal on click
                closeButton.addEventListener('click', () => {
                    clearTimeout(timeoutId); // Clear the auto-dismiss timer
                    hideNotification();
                }, {
                    once: true
                }); // Ensure the event listener is removed after first use
            }

            function hideNotification() {
                const toast = document.getElementById('notification-toast');
                if (toast) {
                    toast.classList.remove('translate-x-0', 'opacity-100');
                    toast.classList.add('translate-x-full', 'opacity-0');
                    toast.classList.add('hidden');
                }
            }

        });
    </script>
    @stack('scripts')
</body>

</html>
