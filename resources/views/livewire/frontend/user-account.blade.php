<main class=" mx-auto relative">
    <section class="">
        <div class="inner_banner">
            <img src="{{ asset('assets/images/user_profile/inner_banner.png') }}" alt="" class="w-full">
        </div>
    </section>
    {{-- profile header --}}
    <section class="container mx-auto bg-zinc-900 p-10! rounded-2xl absolute top-20 left-1/2 translate-x-[-50%] ">
        <div class="flex justify-between">
            <div class="flex items-center gap-6">
                <div class="">
                    <img src="{{ asset('assets/images/user_profile/Ellipse 474.png') }}" alt="">
                </div>
                <div class="">
                    <h3 class="text-4xl font-semibold mb-2">{{__('Starriz.clo')}}</h3>
                    <span class="text-base-400">{{__('Online')}}</span>
                </div>
            </div>
            <div class="icon">
                <x-flux::icon name="pencil-square" class="w-6 h-6 inline-block" stroke="white" />
            </div>
        </div>
        <div class="border-b border-zinc-700 mt-6 mb-4"></div>
        <div class="flex gap-6">
            <a href="#" class=" group">
                <span class="relative z-10 ">{{__('Shop')}}</span>
                <span class=""></span>
            </a>
            <a href="#" class=" group">
                <span class="relative z-10">{{__('Reviews')}}</span>
                <span class=""></span>
            </a>
            <a href="#" class=" group">
                <span class="relative z-10">{{__('About')}}</span>
                <span class=""></span>
            </a>
        </div>
    </section>
    <div class="min-h-70"></div>
    {{-- info --}}
    <section class="container mx-auto mb-30">
        <div class="mb-6">
            <h3 class="text-4xl text-zinc-50 mb-4">{{__('Shop')}}</h3>
            {{-- profile nav --}}
            @include('components.frontend.profile-nav')
            {{-- select game --}}

    </section>
</main>
