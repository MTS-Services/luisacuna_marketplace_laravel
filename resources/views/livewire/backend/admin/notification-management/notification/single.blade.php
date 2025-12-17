<section>
    <div class="glass-card rounded-2xl p-8">
        <div class="max-w-4xl mx-auto">
            <!-- Loading State -->
            <div class="glass-card rounded-2xl p-8 text-center">
                <div
                    class="w-16 h-16 border-4 border-primary border-t-transparent rounded-full animate-spin mx-auto mb-4">
                </div>
                <p class="text-text-primary">{{ __('Loading notification details...') }}</p>
            </div>

            <!-- Error State -->
            <div class="glass-card rounded-2xl p-8 text-center">
                <div
                    class="w-16 h-16 bg-red-100 dark:bg-red-900/30 rounded-full flex items-center justify-center mx-auto mb-4">
                    <flux:icon icon="triangle-alert" class="w-8 h-8 stroke-red-500" />
                </div>
                <h2 class="text-xl font-bold text-black dark:text-white mb-2">{{ __('Notification Not Found') }}</h2>
                <p class="text-gray-600 dark:text-gray-300 mb-6">
                    {{ __('The notification you\'re looking for doesn\'t exist or has been removed.') }}
                </p>
                <div class="flex gap-3 justify-center">
                    <x-ui.button href="{{ route('admin.notification.index') }}" class="w-auto! py-2!">
                        <flux:icon name="arrow-left"
                            class="w-4 h-4 stroke-text-btn-primary group-hover:stroke-text-btn-secondary" />
                        {{ __('View All Notifications') }}
                    </x-ui.button>
                    <x-ui.button href="{{ route('admin.dashboard') }}" class="w-auto! py-2!" variant="tertiary">
                        <flux:icon name="layout-dashboard"
                            class="w-4 h-4 stroke-text-btn-primary group-hover:stroke-text-btn-tertiary" />
                        {{ __('Go to Dashboard') }}
                    </x-ui.button>
                </div>
            </div>

            <!-- Content State -->

            <!-- Header -->
            <div class="glass-card rounded-2xl p-6 mb-8">
                <div class="flex items-center justify-between flex-wrap gap-4">
                    <div class="flex items-start flex-col">
                        <h1 class="text-2xl font-bold text-text-primary">Notification Details</h1>
                        <span class="badge badge-soft badge-primary">Public Announcment</span>
                    </div>

                    <div class="flex items-center gap-3">
                        <button id="mark-as-read-btn"
                            class="px-4 py-2 bg-blue-500/20 hover:bg-blue-500/30 text-blue-600 dark:text-blue-400 rounded-lg transition-colors font-medium text-sm">
                            <flux:icon name="check" class="w-4 h-4 inline mr-2 stroke-blue-500" />
                            Mark as UnRead
                        </button>

                        <button id="delete-notification-btn"
                            class="px-4 py-2 bg-red-500/20 hover:bg-red-500/30 text-red-600 dark:text-red-400 rounded-lg transition-colors font-medium text-sm">
                            <flux:icon name="trash" class="w-4 h-4 inline mr-2 stroke-red-500" />
                            Delete
                        </button>
                    </div>
                </div>
            </div>

            <!-- Notification Content -->
            <div class="glass-card rounded-2xl overflow-hidden">
                <div class="p-8">
                    <!-- Icon and Status -->
                    <div class="flex items-start gap-6 mb-8">
                        <div class="relative shrink-0">
                            <div
                                class="relative shrink-0 w-20 h-20 glass-card shadow-shadow-primary rounded-full flex items-center justify-center group-hover:scale-110 transition-transform">
                                <flux:icon icon="bell" class="w-8 h-8 stroke-primary" />
                            </div>
                            <span class="absolute -top-2 -right-2 w-6 h-6 bg-red-500 rounded-full">
                                <span class="absolute inset-0 bg-red-500 rounded-full animate-ping"></span>
                            </span>
                        </div>

                        <div class="flex-1">
                            <h2 id="notification-title" class="text-3xl font-bold text-text-primary mb-3">
                                Notification Title
                            </h2>
                            <div class="flex items-center gap-6 text-sm text-text-muted mb-6">
                                <span class="flex items-center gap-2">
                                    <flux:icon icon="clock" class="w-4 h-4" />
                                    <span>16 Dec 2025 - 10:00 AM</span>
                                </span>
                                <span class="flex items-center gap-2">
                                    <flux:icon icon="megaphone" class="w-4 h-4" />
                                    <span>Public</span>
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Message Content -->
                    <div class="space-y-6">
                        <div>
                            <h3 class="text-lg font-semibold text-text-primary mb-3">Message</h3>
                            <div
                                class="bg-main shadow-shadow-primary  rounded-xl p-6 text-text-muted leading-relaxed wrap-break-word">
                                sdgjlksdglkdsjflk sdjlkfjsdlkfjsldkfjdlsjflskdfjlsld ldsjmflkdjf
                                lksdjflksdjflskdjfjlksadjflkdajflkdsjflkdsjlkjsdlkjflksdfjlk
                                dsfdsfjsdlkjflskdjflksdjflkdsjflkdasjflkjlo
                            </div>
                        </div>

                        <div>
                            <h3 class="text-lg font-semibold text-text-primary mb-3">Description</h3>
                            <div
                                class="bg-main shadow-shadow-primary  rounded-xl p-6 text-text-muted leading-relaxed wrap-break-word">
                                sdgjlksdglkdsjflk sdjlkfjsdlkfjsldkfjdlsjflskdfjlsld ldsjmflkdjf
                                lksdjflksdjflskdjfjlksadjflkdajflkdsjflkdsjlkjsdlkjflksdfjlk
                                dsfdsfjsdlkjflskdjflksdjflkdsjflkdasjflkjlo
                            </div>
                        </div>

                        <div>
                            <h3 class="text-lg font-semibold text-text-primary mb-3">Additional Information</h3>
                            <div class="bg-gray-50 dark:bg-gray-800/50 rounded-xl p-6 flex flex-col gap-3">
                                <div class="grid grid-cols-3">
                                    <p class="col-span-1">Key: </p>
                                    <p class="col-span-2">Value</p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Actions Footer -->
                <div class="bg-gray-50 dark:bg-gray-800/30 px-8 py-6 border-t border-gray-200 dark:border-gray-700">
                    <div class="flex items-center justify-end">
                        <x-ui.button href="{{ route('admin.notification.index') }}" class="w-auto! py-2! rounded-lg"
                            variant="secondary">
                            <flux:icon name="bell-alert"
                                class="w-4 h-4 stroke-text-btn-secondary group-hover:stroke-text-btn-primary" />
                            {{ __('See All Notifications') }}
                        </x-ui.button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
