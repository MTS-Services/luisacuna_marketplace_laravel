@props([
    'hero' => [],
])




@if ( $hero ==null )
    <section class=" relative py-20 overflow-hidden">
        <div class="absolute inset-0 z-0 bg-linear-to-r from-purple-950/50 via-text-white to-purple-950/50">
            <div class="absolute top-50 -translate-y-1/2 left-0 w-32 h-32 md:w-auto md:h-auto">
                <img src="{{ asset('assets/images/home_page/Frame 62.png') }}" alt=""
                    class="w-full h-full object-fit">
            </div>

            <div class="absolute top-50 translate-y-[-50%] right-0 z-10 w-32 h-32 md:w-auto md:h-auto">
                <img src="{{ asset('assets/images/home_page/Frame 61.png') }}" alt=""
                    class="w-full h-full object-fit">
            </div>
        </div>

        <div class="container relative z-10 text-center">
            <h1 class="text-5xl md:text-6xl font-bold mb-6 text-text-white">{{ __('Digital Commerce') }}</h1>
            <p class="text-xl text-text-secondary mb-8 max-w-2xl mx-auto">
                {{ __('The most reliable platform to buy and sell high-quality digital products.') }}
            </p>

            <div class="flex flex-col md:flex-row gap-4 justify-center">
                <div>
                    <x-ui.button class="py-2" href="#popular-games" :wire="false">
                        <flux:icon name="user"
                            class="w-5 h-5 stroke-text-btn-primary group-hover:stroke-text-btn-secondary" />
                        {{ __('Explore Products') }}
                    </x-ui.button>
                </div>
                <div>
                    <x-ui.button class="py-2" variant='secondary'>
                        <flux:icon name="shopping-cart"
                            class="w-5 h-5 stroke-text-btn-secondary group-hover:stroke-text-btn-primary" />
                        {{ __('Sell Now') }}
                    </x-ui.button>
                </div>
            </div>
        </div>
    </section>
@else
    <section class=" relative  overflow-hidden bg-cover bg-center " style="background-image: url('{{ asset('assets/images/banner.jpg') }}')">
        <div class="bg-[#0f002978] py-30 bg-opacity-0 relative z-10">
            <div
                class="container py-30 relative z-10 align-left px-0 w-100vw">

                <h1 class="text-5xl md:text-6xl font-semibold mb-6 text-white align-left">{{ __('Finish Your Brainrot Set') }}</h1>
                <p class="text-xl text-white mb-15 max-w-2xl align-left">
                    {{ __('Find exclusive drops and limited sets in the biggest Brainrot marketplace. Complete your collection and own the movement before it’s gone.') }}
                </p>

                <div class="flex flex-col md:flex-row gap-4 justify-start">
                    <div>
                        <x-ui.button class="py-2! px-3!" href="#popular-games" :wire="false">
                            
                            {{ __('Shop Now') }}
                        </x-ui.button>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endif
