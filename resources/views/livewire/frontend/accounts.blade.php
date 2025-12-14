<main class="mx-auto">
    <section class="container mx-auto">
        {{-- paginate --}}
        <div class="flex items-center gap-1 my-10 font-semibold">
            <div class="w-4 h-4">
                <img src="{{ asset('assets/images/items/1.png') }}" alt="m logo" class="w-full h-full object-cover">
            </div>
            <div class="text-text-white text-base">
                <a href="{{ route('home') }}" class="text-base text-text-white">{{ __('Home') }}</a>
            </div>
            <div class="px-2 text-text-white text-base">
                >
            </div>
            <h1 class="text-text-white text-base">
                {{ __('Accounts') }}
            </h1>
        </div>



        {{-- filter section --}}
        <div class="title mb-5">
            <h2 class="font-semibold text-4xl">{{ __('Accounts') }}</h2>
        </div>
        
        <x-filter :sortOrder="$sortOrder"/>

    </section>

    {{-- popular accounts --}}
    <section class="container mx-auto">
        <div class="mt-10">
            <div class="">
                <h2 class="font-semibold text-text-white text-3xl sm:text-4xl md:text-5xl">
                    {{ __('Popular Accoounts') }}
                </h2>
            </div>
            <div wire:ignore class="swiper popular-accounts">
                <div class="swiper-wrapper py-10">
                    @foreach ($popular_accounts as $popular_account)
                        <div class="swiper-slide">
                            <x-product-card :data="$popular_account" />
                        </div>
                    @endforeach
                </div>

                <!-- Add Pagination and Navigation -->
                <div class="mt-10">
                    <div class="swiper-pagination"></div>
                    <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>
                </div>
            </div>
        </div>
    </section>
    {{-- all items --}}
    <section class="container mx-auto mt-10">
        <div class="mb-10">
            <h2 class="font-semibold text-text-white text-3xl sm:text-4xl md:text-5xl">{{ __('All Item') }}</h2>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 items-center gap-6 mb-16">
            @foreach ($accounts as $account)
                <x-product-card :data="$account" />
            @endforeach
        </div>

        <div class="pagination mb-24">
             <x-frontend.pagination-ui :pagination="$pagination" />
        </div>
    </section>

    @push('scripts')
        <script>
            document.addEventListener('livewire:navigated', function() {
                const swiper = new Swiper('.popular-accounts', {
                    loop: true,
                    pagination: {
                        el: '.swiper-pagination',
                        clickable: true,
                    },
                    // navigation: {
                    //     nextEl: '.swiper-button-next',
                    //     prevEl: '.swiper-button-prev',
                    // },
                    autoplay: {
                        delay: 2500,
                        disableOnInteraction: false,
                    },
                    slidesPerView: 1,
                    spaceBetween: 20,
                    breakpoints: {
                        640: {
                            slidesPerView: 2,
                        },
                        1024: {
                            slidesPerView: 3,
                        },
                    },
                });

            });
        </script>
    @endpush
</main>
