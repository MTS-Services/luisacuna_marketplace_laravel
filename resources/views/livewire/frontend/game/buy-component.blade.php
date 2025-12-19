<main class="overflow-x-hidden bg-page">
    <div class="max-w-7xl mx-auto px-4 py-8">
        <livewire:frontend.partials.page-inner-header :gameSlug="$gameSlug" :categorySlug="$categorySlug" :game="$game" />
        <!-- Breadcrumb -->
        <livewire:frontend.partials.breadcrumb :gameSlug="$gameSlug" :categorySlug="$categorySlug" />

        <div>
            <div class=" text-white min-h-screen">
                <div class="w-full mx-auto">
                    <!-- Main Content Grid -->
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                        <!-- Left Column - Product Details -->
                        <x-currency.game-information :game="$game" :user="$user" :product="$product" />

                        <!-- Right Column - Product Cards -->
                        <livewire:backend.user.payments.initialize-order :productId="encrypt($product->id)" />
                    </div>
                </div>
            </div>
        </div>

        <!-- Product Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 ">
            <!-- Card 1 -->
            <a href="{{ route('game.buy', ['gameSlug' => $gameSlug, 'categorySlug' => $categorySlug, 'productId' => encrypt($product->id)]) }}"
                wire:navigate>
                <!-- Card -->
                <div class="bg-bg-primary rounded-2xl p-5 shadow-lg transition">

                    <div class="flex justify-between items-start">
                        <div class="flex items-center space-x-2">
                            <div
                                class="bg-orange-500 text-white font-bold rounded-md w-6 h-6 flex items-center justify-center">
                                F</div>
                            <span class="text-green-400 font-medium">Xbox</span>
                        </div>
                        <span class="text-gray-400 text-sm">• Stacked</span>
                    </div>

                    <div class="flex flex-row my-2">
                        <p class="text-text-secondary text-sm mt-4 ml-1 mx-6">
                            Blue Squire Skin – 50 VB – Xbox / PSN / PC Full Access
                        </p>

                        <img class="w-16 h-16 rounded float-right" src="{{ asset('assets/images/Rectangle.png') }}"
                            alt="Image">
                    </div>

                    <div class=" flex items-center justify-between ">
                        <span class="text-text-white font-medium text-lg">PEN175.27</span>
                        <div class="flex items-center space-x-1 text-gray-400 text-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6 1a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>Instant</span>
                        </div>
                    </div>

                    <div class="border-t border-purple-900 mt-4 pt-3 flex items-center">

                        <div class="relative">
                            <img src="{{ asset('assets/images/2 1.png') }}"
                                class="w-14 h-14 rounded-full border-[3px] border-white" alt="profile" />
                            <span
                                class="absolute bottom-0 right-0 w-5 h-5 bg-green-500 border-[3px] border-white rounded-full"></span>
                        </div>

                        <div class="ml-3 ">
                            <p class="text-text-white font-medium">Victoria</p>

                            <div class="flex items-center space-x-2 mt-2">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#853EFF"
                                    class="w-5 h-5">
                                    <path
                                        d="M7.493 18.5c-.425 0-.82-.236-.975-.632A7.48 7.48 0 0 1 6 15.125c0-1.75.599-3.358 1.602-4.634.151-.192.373-.309.6-.397.473-.183.89-.514 1.212-.924a9.042 9.042 0 0 1 2.861-2.4c.723-.384 1.35-.956 1.653-1.715a4.498 4.498 0 0 0 .322-1.672V2.75A.75.75 0 0 1 15 2a2.25 2.25 0 0 1 2.25 2.25c0 1.152-.26 2.243-.723 3.218-.266.558.107 1.282.725 1.282h3.126c1.026 0 1.945.694 2.054 1.715.045.422.068.85.068 1.285a11.95 11.95 0 0 1-2.649 7.521c-.388.482-.987.729-1.605.729H14.23c-.483 0-.964-.078-1.423-.23l-3.114-1.04a4.501 4.501 0 0 0-1.423-.23h-.777ZM2.331 10.727a11.969 11.969 0 0 0-.831 4.398 12 12 0 0 0 .52 3.507C2.28 19.482 3.105 20 3.994 20H4.9c.445 0 .72-.498.523-.898a8.963 8.963 0 0 1-.924-3.977c0-1.708.476-3.305 1.302-4.666.245-.403-.028-.959-.5-.959H4.25c-.832 0-1.612.453-1.918 1.227Z" />
                                </svg>
                                <p class="text-gray-400 text-xs">99.3% | 2434 reviews | 1642 Sold</p>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

</main>
