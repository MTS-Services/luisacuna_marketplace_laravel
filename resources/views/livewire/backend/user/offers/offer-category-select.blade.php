<div class="bg-bg-primary">
    <div class="container pb-10">
        <livewire:frontend.partials.breadcrumb :gameSlug="''" :categorySlug="'start selling'" />
        <div class="w-full mx-auto rounded-2xl">
            <div class="bg-bg-secondary p-4 sm:p-10 md:p-20 rounded-2xl">
                <h1 class="text-2xl sm:text-40px font-semibold text-center text-text-white mb-2">
                    {{ __('Start selling') }}
                </h1>
                <h2 class="text-base sm:text-2xl text-center text-text-white mb-4 sm:mb-10">
                    {{ __('Choose category') }}
                </h2>

                <div class="space-y-4 sm:space-y-10">
                    @foreach ($categories as $category)
                        <a href="{{ route('user.offers.create.games', $category->slug) }}" wire:navigate
                            class="w-full flex items-center justify-between p-4 bg-bg-info hover:bg-zinc-700/30 transition rounded-xl">
                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 sm:w-16 sm:h-16">
                                    @if ($category->icon)
                                        <img src="{{ storage_url($category->icon) }}"
                                            class="w-full h-full rounded-lg sm:rounded-xl object-cover"
                                            alt="{{ $category->name }}" />
                                    @else
                                        <img src="{{ storage_url('') }}" alt="{{ $category->name }}"
                                            class="w-full h-full rounded-lg sm:rounded-xl object-cover">
                                    @endif
                                </div>
                                <span class="text-2xl sm:text-3xl font-semibold text-text-white">
                                    {{ $category->translatedName(app()->getLocale()) }}
                                </span>
                            </div>

                            <svg class="w-6 h-6 fill-white" viewBox="0 0 256 256">
                                <path
                                    d="M181.66,133.66l-80,80a8,8,0,0,1-11.32-11.32L164.69,128,90.34,53.66a8,8,0,0,1,11.32-11.32l80,80A8,8,0,0,1,181.66,133.66Z">
                                </path>
                            </svg>
                        </a>
                    @endforeach

                    <a href="{{ route('user.bulk-upload.category') }}" wire:navigate
                        class="w-full flex items-center justify-between p-4 bg-bg-info hover:bg-zinc-700/30 transition rounded-xl">
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 sm:w-16 sm:h-16">
                                <img src="{{ asset('assets/images/bulk-upload.png') }}" alt="Bulk Upload"
                                    class="w-full h-full rounded-lg sm:rounded-xl object-cover">
                            </div>
                            <span class="text-2xl sm:text-3xl font-semibold text-text-white">
                                {{ __('Bulk Upload') }}
                            </span>
                        </div>

                        <svg class="w-6 h-6 fill-white" viewBox="0 0 256 256">
                            <path
                                d="M181.66,133.66l-80,80a8,8,0,0,1-11.32-11.32L164.69,128,90.34,53.66a8,8,0,0,1,11.32-11.32l80,80A8,8,0,0,1,181.66,133.66Z">
                            </path>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
