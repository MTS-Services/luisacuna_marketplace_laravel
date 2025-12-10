@props([
    'heros' => [],
])



@forelse ($heros as $key => $hero)
 @if($key > 0) @break @endif

<div class=" relative hidden md:flex overflow-hidden  bg-center h-[532px] bg-no-repeat bg-[length:100%_100%]  justify-center items-center"
    style="background-image: url('{{ storage_url($hero->image) }}')">
    <div class="bg-[#0f002978] py-30 bg-opacity-0 relative z-10 w-full">
        <div class="container py-30 relative z-10 align-left  w-100vw">

            <h1 class="text-5xl md:text-6xl font-semibold mb-6 text-white align-left">{{ $hero->title }}
            </h1>
            <p class="text-xl text-white mb-15 max-w-2xl align-left">
                {{ $hero->content }}
            </p>

            <div class="flex flex-col md:flex-row gap-4 justify-start">
                <div>
                    <x-ui.button class="py-2! px-3!" href="{{ $hero->action_url }}" :wire="false"
                        :target="$hero->target">

                        {{ $hero->action_title }}
                    </x-ui.button>
                </div>
            </div>
        </div>
    </div>
</div>


    <section
        class=" relative flex md:hidden overflow-hidden  bg-center h-[532px] bg-no-repeat bg-[length:100%_100%]  justify-center items-center"
        style="background-image: url('{{ storage_url($hero->mobile_image) }}')">
        <div class="bg-[#0f002978] py-30 bg-opacity-0 relative z-10 w-full">
            <div class="container py-30 relative z-10 align-left  w-100vw">

                <h1 class="text-5xl md:text-6xl font-semibold mb-6 text-white text-center">{{ $hero->title }}</h1>
                <p class="text-xl text-white mb-15 max-w-2xl text-center">
                    {{ $hero->content }}
                </p>

                <div class="flex flex-col md:flex-row gap-4 justify-start">
                    <div>
                        <x-ui.button class="py-2! px-3!" href="{{ $hero->action_url }}" :wire="false"
                            :target="$hero->target">

                            {{ $hero->action_title }}
                        </x-ui.button>
                    </div>
                </div>
            </div>
        </div>
    </section>
@empty
    <section class=" relative py-20 overflow-hidden h-[532px]! flex justify-center items-center">
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
                    <x-ui.button class="" href="#popular-games" :wire="false">
                        <flux:icon name="user"
                            class="w-5 h-5 stroke-text-btn-primary group-hover:stroke-text-btn-secondary" />
                        {{ __('Explore Products') }}
                    </x-ui.button>
                </div>
                <div>
                    <x-ui.button class="" variant='secondary'>
                        <flux:icon name="shopping-cart"
                            class="w-5 h-5 stroke-text-btn-secondary group-hover:stroke-text-btn-primary" />
                        {{ __('Sell Now') }}
                    </x-ui.button>
                </div>
            </div>
        </div>
    </section>
@endforelse

