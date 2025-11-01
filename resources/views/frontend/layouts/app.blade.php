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
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @fluxAppearance()
    <style>
        :root {
            --livewire-progress-bar-color: var(--color-secondary-500) !important;
        }

        @keyframes bounce-dot {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-20px);
            }
        }
    </style>
    @stack('styles')
</head>

<body class="min-h-screen flex flex-col bg-bg-secondary text-text-primary">

    @if(!(request()->routeIs('login') || request()->routeIs('register') || request()->routeIs('password.request') || request()->routeIs('password.reset') || request()->routeIs('verify-reset-otp') || request()->routeIs('verification.notice') || request()->routeIs('verify-otp') || request()->routeIs('verification.verify') || request()->routeIs('two-factor.*') || request()->routeIs('two-factor.login') || request()->routeIs('two-factor.login.store') || request()->routeIs('admin.*') ))
        <livewire:frontend.partials.header/>
    @endif
    <main class="flex-1">
        {{ $slot }}
    </main>
    @if(!(request()->routeIs('login') || request()->routeIs('register') || request()->routeIs('password.request') || request()->routeIs('password.reset') || request()->routeIs('verify-reset-otp') || request()->routeIs('verification.notice') || request()->routeIs('verify-otp') || request()->routeIs('verification.verify') || request()->routeIs('two-factor.*') || request()->routeIs('two-factor.login') || request()->routeIs('two-factor.login.store') || request()->routeIs('admin.*') ))
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
    </script>
    @stack('scripts')
</body>

</html>
