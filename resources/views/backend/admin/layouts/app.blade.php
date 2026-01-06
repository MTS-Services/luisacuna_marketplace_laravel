<!DOCTYPE html>
<html lang="en">

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
    @vite(['resources/css/dashboard.css', 'resources/js/app.js'])
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
    {{-- <link rel="stylesheet" href="{{ asset('assets/css/dashboard.css') }}"> --}}
    @fluxAppearance
    <style>
        @keyframes bounce-dot {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-20px);
            }
        }

        :root {
            --livewire-progress-bar-color: var(--color-secondary-500) !important;
        }
    </style>
    <script>
        document.addEventListener('livewire:initialized', function() {
            Livewire.on('notify', (event) => {
                showAlert(event.type, event.message);
            });
            // console.log(Toastify);
        });
    </script>
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
    @stack('styles')
</head>

<body x-data="dashboardData();" class="h-full max-h-screen antialiased animated-bg">
    <div x-show="mobile_menu_open && !desktop" x-transition:enter="transition-all duration-300 ease-out"
        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="transition-all duration-300 ease-in" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0" @click="closeMobileMenu()"
        class="fixed inset-0 z-11 bg-transparent backdrop-blur-xs lg:hidden">
    </div>

    <div class="flex h-screen">
        <!-- Sidebar -->
        <livewire:backend.admin.partials.sidebar :active="$pageSlug" />


        <!-- Main Content -->
        <div class="flex-1 flex flex-col custom-scrollbar overflow-y-auto">
            <!-- Header -->

            {{-- <x-admin::header :breadcrumb="$breadcrumb" /> --}}
            <livewire:backend.admin.partials.header :breadcrumb="$breadcrumb" />

            <!-- Main Content Area -->
            <main class="flex-1 p-4 lg:p-6">
                <div class="mx-auto space-y-6">
                    {{ $slot }}
                </div>
            </main>
        </div>
    </div>

    <livewire:backend.admin.notification-management.notification.sidebar />

    <div id="navigation-loader" x-transition.opacity
        class="fixed inset-0 z-50 flex items-center justify-center bg-bg-primary/50 backdrop-blur-md">
        <div class="flex space-x-2">
            <div class="w-4 h-4 rounded-full bg-accent animate-[bounce-dot_1.2s_infinite]"
                style="animation-delay: -0.8s;"></div>
            <div class="w-4 h-4 rounded-full bg-pink-500 animate-[bounce-dot_1.2s_infinite]"
                style="animation-delay: -0.4s;"></div>
            <div class="w-4 h-4 rounded-full bg-accent animate-[bounce-dot_1.2s_infinite]"></div>
        </div>
    </div>

    <livewire:backend.admin.translation-manager />

    @fluxScripts
    <script>
        function dashboardData() {
            return {
                // Responsive state
                desktop: window.innerWidth >= 1024,
                mobile: window.innerWidth <= 768,
                tablet: window.innerWidth < 1024,
                sidebar_expanded: window.innerWidth >= 1024,
                mobile_menu_open: false,

                // App state
                searchQuery: '',
                // darkMode: true,

                stats: {
                    users: 12384,
                    revenue: 48392,
                    orders: 2847,
                    activeUsers: 847
                },

                // Methods
                init() {
                    this.handleResize();
                    this.initChart();
                    window.addEventListener('resize', () => this.handleResize());

                    // Keyboard shortcuts
                    document.addEventListener('keydown', (e) => {
                        if ((e.metaKey || e.ctrlKey) && e.key === 'k') {
                            e.preventDefault();
                            this.focusSearch();
                        }
                    });
                },

                handleResize() {
                    this.desktop = window.innerWidth >= 1024;
                    if (this.desktop) {
                        this.mobile_menu_open = false;
                        this.sidebar_expanded = true;
                    } else {
                        this.sidebar_expanded = false;
                    }
                },

                toggleSidebar() {
                    if (this.desktop) {
                        this.sidebar_expanded = !this.sidebar_expanded;
                    } else {
                        this.mobile_menu_open = !this.mobile_menu_open;
                    }
                },

                closeMobileMenu() {
                    if (!this.desktop) {
                        this.mobile_menu_open = false;
                    }
                },


                initChart() {
                    this.$nextTick(() => {
                        const canvas = document.getElementById('revenueChart');
                        if (!canvas) return;

                        const ctx = canvas.getContext('2d');

                        // Destroy existing chart if it exists
                        if (window.revenueChart instanceof Chart) {
                            window.revenueChart.destroy();
                        }

                        // Create gradient
                        const gradient = ctx.createLinearGradient(0, 0, 0, 300);
                        gradient.addColorStop(0, 'rgba(102, 126, 234, 0.8)');
                        gradient.addColorStop(1, 'rgba(118, 75, 162, 0.1)');

                        window.revenueChart = new Chart(ctx, {
                            type: 'line',
                            data: {
                                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep',
                                    'Oct', 'Nov', 'Dec'
                                ],
                                datasets: [{
                                    label: 'Revenue',
                                    data: [12000, 19000, 15000, 25000, 22000, 30000, 28000, 35000,
                                        32000, 38000, 42000, 48000
                                    ],
                                    borderColor: '#667eea',
                                    backgroundColor: gradient,
                                    borderWidth: 3,
                                    fill: true,
                                    tension: 0.4,
                                    pointBackgroundColor: '#667eea',
                                    pointBorderColor: '#ffffff',
                                    pointBorderWidth: 2,
                                    pointRadius: 6,
                                    pointHoverRadius: 8
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                plugins: {
                                    legend: {
                                        display: false
                                    }
                                },
                                scales: {
                                    x: {
                                        grid: {
                                            display: false
                                        },
                                        ticks: {
                                            color: 'rgba(255, 255, 255, 0.6)'
                                        }
                                    },
                                    y: {
                                        grid: {
                                            color: 'rgba(255, 255, 255, 0.1)'
                                        },
                                        ticks: {
                                            color: 'rgba(255, 255, 255, 0.6)',
                                            callback: function(value) {
                                                return '$' + value.toLocaleString();
                                            }
                                        }
                                    }
                                },
                                interaction: {
                                    intersect: false,
                                    mode: 'index'
                                },
                                elements: {
                                    point: {
                                        hoverBackgroundColor: '#ffffff'
                                    }
                                }
                            }
                        });
                    });
                }
            }
        }

        // Smooth scrolling for anchor links
        document.addEventListener('click', function(e) {
            if (e.target.matches('a[href^="#"]')) {
                e.preventDefault();
                const target = document.querySelector(e.target.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            }
        });
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


    <script>
        document.addEventListener('livewire:initialized', () => {
            console.log('Livewire initialized, setting up Echo listeners');

            window.Echo.channel('admins')
                .listen('.notification.sent', (e) => {
                    console.log('✅ Notification received on admins channel:', e);
                    window.toast.info(e.title || 'New Notification Received');
                    Livewire.dispatch('notification-updated');
                })
                .subscribed(() => {
                    console.log('✅ Successfully subscribed to admins channel');
                })
                .error((error) => {
                    console.error('❌ Error on admins channel:', error);
                });

            if ('{{ auth()->check() }}') {
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
            }
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
                window.location.href = '{{ route('admin.login') }}';

                // If somehow the above doesn't work, force reload
                setTimeout(() => {
                    window.location.reload(true);
                }, 100);
            }
        });
    </script>
    @stack('scripts')

    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
</body>

</html>
