
@props(
    [
        'target' => null,
        'style' => 'grid',
    ]
)
<div wire:loading 
         wire:target="{{ $target}}"
         class="absolute inset-0 z-10">
        <div x-transition:enter="transition ease-out duration-200" 
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100" 
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100" 
             x-transition:leave-end="opacity-0"
             class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 2xl:grid-cols-4 gap-4 w-full">

            <!-- Skeleton Card (repeat 8 times) -->
            @for ($i = 0; $i < 4; $i++)
                <div class="bg-gradient-to-br from-purple-900/40 to-purple-800/20 rounded-xl overflow-hidden border border-purple-700/30">
                    <!-- Card Content -->
                    <div class="p-4 space-y-4">
                        <!-- Platform Badge & Status -->
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <div class="w-6 h-6 rounded bg-gradient-to-r from-gray-700 via-gray-600 to-gray-700 bg-[length:200%_100%] animate-shimmer">
                                </div>
                                <div class="h-4 w-16 rounded bg-gradient-to-r from-gray-700 via-gray-600 to-gray-700 bg-[length:200%_100%] animate-shimmer">
                                </div>
                            </div>
                            <div class="h-4 w-20 rounded bg-gradient-to-r from-gray-700 via-gray-600 to-gray-700 bg-[length:200%_100%] animate-shimmer">
                            </div>
                        </div>

                        <!-- Product Image -->
                        <div class="w-full h-24 rounded-lg bg-gradient-to-r from-gray-800/50 via-gray-700/50 to-gray-800/50 bg-[length:200%_100%] animate-shimmer flex items-center justify-center">
                            <div class="w-16 h-16 rounded bg-gradient-to-r from-gray-700 via-gray-600 to-gray-700 bg-[length:200%_100%] animate-shimmer">
                            </div>
                        </div>

                        <!-- Product Title -->
                        <div class="space-y-2">
                            <div class="h-4 w-full rounded bg-gradient-to-r from-gray-700 via-gray-600 to-gray-700 bg-[length:200%_100%] animate-shimmer">
                            </div>
                            <div class="h-4 w-4/5 rounded bg-gradient-to-r from-gray-700 via-gray-600 to-gray-700 bg-[length:200%_100%] animate-shimmer">
                            </div>
                            <div class="h-4 w-3/5 rounded bg-gradient-to-r from-gray-700 via-gray-600 to-gray-700 bg-[length:200%_100%] animate-shimmer">
                            </div>
                        </div>

                        <!-- Price & Delivery -->
                        <div class="flex items-center justify-between pt-2 border-t border-purple-700/30">
                            <div class="h-6 w-24 rounded bg-gradient-to-r from-gray-700 via-gray-600 to-gray-700 bg-[length:200%_100%] animate-shimmer">
                            </div>
                            <div class="flex items-center gap-2">
                                <div class="w-4 h-4 rounded-full bg-gradient-to-r from-gray-700 via-gray-600 to-gray-700 bg-[length:200%_100%] animate-shimmer">
                                </div>
                                <div class="h-4 w-16 rounded bg-gradient-to-r from-gray-700 via-gray-600 to-gray-700 bg-[length:200%_100%] animate-shimmer">
                                </div>
                            </div>
                        </div>

                        <!-- Seller Info -->
                        <div class="flex items-center gap-3 pt-2">
                            <!-- Avatar -->
                            <div class="relative">
                                <div class="w-12 h-12 rounded-full bg-gradient-to-r from-gray-700 via-gray-600 to-gray-700 bg-[length:200%_100%] animate-shimmer">
                                </div>
                                <div class="absolute bottom-0 right-0 w-3 h-3 rounded-full bg-gradient-to-r from-gray-600 via-gray-500 to-gray-600 bg-[length:200%_100%] animate-shimmer">
                                </div>
                            </div>

                            <!-- Seller Details -->
                            <div class="flex-1 space-y-2">
                                <div class="h-4 w-20 rounded bg-gradient-to-r from-gray-700 via-gray-600 to-gray-700 bg-[length:200%_100%] animate-shimmer">
                                </div>
                                <div class="flex items-center gap-2">
                                    <div class="w-4 h-4 rounded bg-gradient-to-r from-gray-700 via-gray-600 to-gray-700 bg-[length:200%_100%] animate-shimmer">
                                    </div>
                                    <div class="h-3 w-32 rounded bg-gradient-to-r from-gray-700 via-gray-600 to-gray-700 bg-[length:200%_100%] animate-shimmer">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endfor

        </div>
    </div>
