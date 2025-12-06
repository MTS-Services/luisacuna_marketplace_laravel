<div x-data="{ 
        showConfigModal: @entangle('showConfigModal').live,
        isLoading: @entangle('isLoading').live 
     }" 
     x-show="showConfigModal"
     x-cloak
     x-transition:enter="transition ease-out duration-200" 
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100" 
     x-transition:leave="transition ease-in duration-150"
     x-transition:leave-start="opacity-100" 
     x-transition:leave-end="opacity-0" 
     class="fixed inset-0 z-50 overflow-y-auto"
     style="display: none;"
     @open-config-modal.window="showConfigModal = true; isLoading = true; $wire.openConfigModal($event.detail.slug)">

    <!-- Backdrop -->
    <div class="fixed inset-0 bg-black/50 backdrop-blur-sm" 
         @click="showConfigModal = false; $wire.closeConfigModal()"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"></div>

    <!-- Modal Content -->
    <div class="flex min-h-screen items-center justify-center p-4">
        <div class="relative w-full max-w-2xl bg-white dark:bg-gray-800 rounded-2xl shadow-2xl"
             x-show="showConfigModal"
             x-transition:enter="transition ease-out duration-200 delay-75"
             x-transition:enter-start="opacity-0 transform scale-95"
             x-transition:enter-end="opacity-100 transform scale-100"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 transform scale-100"
             x-transition:leave-end="opacity-0 transform scale-95" 
             @click.stop>

            <!-- Loading Overlay -->
            <div x-show="isLoading" 
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="absolute inset-0 bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm rounded-2xl z-10 flex items-center justify-center">
                <div class="text-center">
                    <svg class="w-12 h-12 mx-auto text-blue-500 animate-spin mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                    </svg>
                    <p class="text-sm font-medium text-gray-700 dark:text-gray-300">
                        {{ __('Loading category configuration...') }}
                    </p>
                </div>
            </div>

            <!-- Modal Header -->
            <div class="flex items-center justify-between p-6 border-b border-gray-200 dark:border-gray-700">
                <div>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white">
                        {{ __('Configure Category') }}
                    </h3>
                    <div x-show="!isLoading">
                        @if ($currentCategory)
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                {{ __('Category') }}: 
                                <span class="font-semibold text-blue-600 dark:text-blue-400">
                                    {{ $currentCategory->name }}
                                </span>
                            </p>
                        @endif
                    </div>
                    <div x-show="isLoading" class="mt-1">
                        <div class="h-4 w-48 bg-gray-200 dark:bg-gray-700 rounded animate-pulse"></div>
                    </div>
                </div>
                <button @click="showConfigModal = false; $wire.closeConfigModal()"
                        class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="p-6" x-show="!isLoading">
                <div class="text-center py-12">
                    <svg class="w-20 h-20 mx-auto text-blue-500 mb-4" fill="none" stroke="currentColor"
                         viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <h4 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">
                        {{ __('Category Configuration') }}
                    </h4>
                    <p class="text-gray-600 dark:text-gray-400">
                        {{ __('Configure your category settings here. The category has been automatically assigned to this game.') }}
                    </p>

                    <!-- Success Message -->
                    <div class="mt-8 text-left">
                        <div class="p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-700 rounded-lg">
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-green-600 dark:text-green-400 flex-shrink-0" fill="none"
                                     stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span class="font-semibold text-green-700 dark:text-green-300">
                                    {{ __('Category successfully assigned to game') }}
                                </span>
                            </div>
                        </div>

                        <!-- Game Category Details -->
                        @if ($gameCategory)
                            <div class="mt-4 p-4 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-700 rounded-lg">
                                <div class="flex items-start gap-3">
                                    <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 flex-shrink-0 mt-0.5" fill="none"
                                         stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <div class="flex-1">
                                        <p class="font-semibold text-blue-700 dark:text-blue-300 mb-1">
                                            {{ __('Assignment Details') }}
                                        </p>
                                        <div class="text-sm text-blue-600 dark:text-blue-400 space-y-1">
                                            <p>{{ __('Game') }}: <span class="font-medium">{{ $game->name }}</span></p>
                                            <p>{{ __('Category') }}: <span class="font-medium">{{ $currentCategory?->name }}</span></p>
                                            @if($gameCategory->configs->count() > 0)
                                                <p>{{ __('Existing Configs') }}: <span class="font-medium">{{ $gameCategory->configs->count() }}</span></p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Placeholder for future configuration options -->
                        <div class="mt-6 p-6 border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg text-center">
                            <p class="text-gray-500 dark:text-gray-400">
                                {{ __('Additional configuration options will appear here') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="flex items-center justify-end gap-3 p-6 border-t border-gray-200 dark:border-gray-700">
                <button @click="showConfigModal = false; $wire.closeConfigModal()"
                        :disabled="isLoading"
                        class="px-6 py-2.5 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg font-semibold hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors disabled:opacity-50 disabled:cursor-not-allowed">
                    {{ __('Close') }}
                </button>
            </div>
        </div>
    </div>
</div>