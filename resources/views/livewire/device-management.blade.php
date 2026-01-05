<div class="space-y-6 container max-w-7xl mx-auto">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Device Management</h2>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                Manage devices that have access to your account
            </p>
        </div>

        <button wire:click="confirmLogoutAllDevices"
            class="px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
            Logout All Devices
        </button>
    </div>

    <!-- Devices List -->
    <div class="bg-white dark:bg-gray-800 shadow overflow-hidden rounded-lg">
        <div class="divide-y divide-gray-200 dark:divide-gray-700">
            @forelse($devices as $device)
                <div class="p-6 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                    <div class="flex items-start justify-between">
                        <div class="flex items-start space-x-4">
                            <!-- Device Icon -->
                            <div class="flex-shrink-0">
                                <div
                                    class="w-12 h-12 rounded-full bg-gray-100 dark:bg-gray-700 flex items-center justify-center">
                                    @if ($device['device_type'] === 'ios')
                                        <svg class="w-6 h-6 text-gray-600 dark:text-gray-300" fill="currentColor"
                                            viewBox="0 0 24 24">
                                            <path
                                                d="M18.71 19.5c-.83 1.24-1.71 2.45-3.05 2.47-1.34.03-1.77-.79-3.29-.79-1.53 0-2 .77-3.27.82-1.31.05-2.3-1.32-3.14-2.53C4.25 17 2.94 12.45 4.7 9.39c.87-1.52 2.43-2.48 4.12-2.51 1.28-.02 2.5.87 3.29.87.78 0 2.26-1.07 3.81-.91.65.03 2.47.26 3.64 1.98-.09.06-2.17 1.28-2.15 3.81.03 3.02 2.65 4.03 2.68 4.04-.03.07-.42 1.44-1.38 2.83M13 3.5c.73-.83 1.94-1.46 2.94-1.5.13 1.17-.34 2.35-1.04 3.19-.69.85-1.83 1.51-2.95 1.42-.15-1.15.41-2.35 1.05-3.11z" />
                                        </svg>
                                    @elseif($device['device_type'] === 'android')
                                        <svg class="w-6 h-6 text-gray-600 dark:text-gray-300" fill="currentColor"
                                            viewBox="0 0 24 24">
                                            <path
                                                d="M17.6 9.48l1.84-3.18c.16-.31.04-.69-.26-.85-.29-.15-.65-.06-.83.22l-1.88 3.24a11.5 11.5 0 0 0-8.94 0L5.65 5.67c-.19-.28-.54-.37-.83-.22-.3.16-.42.54-.26.85l1.84 3.18C2.92 12.3 1.11 16.91 1 22h22c-.11-5.09-1.92-9.7-5.4-12.52M7 18c-.55 0-1-.45-1-1s.45-1 1-1 1 .45 1 1-.45 1-1 1m10 0c-.55 0-1-.45-1-1s.45-1 1-1 1 .45 1 1-.45 1-1 1" />
                                        </svg>
                                    @else
                                        <svg class="w-6 h-6 text-gray-600 dark:text-gray-300" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                        </svg>
                                    @endif
                                </div>
                            </div>

                            <!-- Device Info -->
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center space-x-2">
                                    <h3 class="text-sm font-medium text-gray-900 dark:text-white">
                                        {{ $device['device_info'] }}
                                    </h3>

                                    @if ($device['is_current'])
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                            Current Device
                                        </span>
                                    @endif

                                    @if ($device['is_active'])
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                            Active
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300">
                                            Inactive
                                        </span>
                                    @endif
                                </div>

                                <div class="mt-2 space-y-1">
                                    <p class="text-sm text-gray-500 dark:text-gray-400">
                                        <span class="font-medium">IP:</span> {{ $device['ip_address'] ?? 'Unknown' }}
                                    </p>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">
                                        <span class="font-medium">Last active:</span>
                                        {{ $device['last_used_at'] ?? 'Never' }}
                                    </p>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">
                                        <span class="font-medium">Added:</span> {{ $device['created_at'] }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Actions -->
                        @if (!$device['is_current'])
                            <div class="flex items-center space-x-2">
                                @if ($device['is_active'])
                                    <button wire:click="confirmLogoutDevice({{ $device['id'] }})"
                                        class="px-3 py-1.5 text-sm font-medium text-red-700 bg-red-100 rounded-md hover:bg-red-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 dark:bg-red-900 dark:text-red-200 dark:hover:bg-red-800">
                                        Logout
                                    </button>
                                @endif

                                <button wire:click="removeDevice({{ $device['id'] }})"
                                    wire:confirm="Are you sure you want to remove this device?"
                                    class="px-3 py-1.5 text-sm font-medium text-gray-700 bg-gray-100 rounded-md hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 dark:bg-gray-700 dark:text-gray-200 dark:hover:bg-gray-600">
                                    Remove
                                </button>
                            </div>
                        @endif
                    </div>
                </div>
            @empty
                <div class="p-12 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">No devices found</h3>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">No devices are currently registered to your
                        account.</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Confirmation Modal -->
    @if ($showConfirmModal)
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500 z-51" wire:click="resetModal"></div>

                <div
                    class="relative z-52 inline-block align-bottom bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <div class="bg-white dark:bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div
                                class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 dark:bg-red-900 sm:mx-0 sm:h-10 sm:w-10">
                                <svg class="h-6 w-6 text-red-600 dark:text-red-200" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">
                                    {{ $actionType === 'all' ? 'Logout All Devices?' : 'Logout Device?' }}
                                </h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500 dark:text-gray-400">
                                        {{ $actionType === 'all'
                                            ? 'This will log you out from all other devices except this one. You will need to login again on those devices.'
                                            : 'This device will be logged out and will need to login again.' }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 dark:bg-gray-700 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="button" wire:click="executeAction"
                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                            Confirm Logout
                        </button>
                        <button type="button" wire:click="resetModal"
                            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 dark:border-gray-600 shadow-sm px-4 py-2 bg-white dark:bg-gray-800 text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
