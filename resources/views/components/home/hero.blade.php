@props([
    'data' => null,
])

    <div class=" relative hidden md:flex overflow-hidden  bg-center h-[532px] bg-no-repeat bg-[length:100%_100%]  justify-center items-center"
        style="background-image: url('{{ storage_url($data->image) }}')">
        <div class="bg-[#0f002978] py-30 bg-opacity-0 relative z-10 w-full">
            <div class="container py-30 relative z-10 align-left  w-100vw">

                <h2 class="text-5xl md:text-6xl font-semibold mb-6 text-text-white align-left">{{ $data->title }}</h2>
                <p class="text-2xl font-normal text-text-white mb-15 max-w-2xl align-left">
                    {{ $data->content }}
                </p>

                <div class="flex flex-col md:flex-row gap-4 justify-start">
                    <div>
                        <x-ui.button class="py-2! px-3!" href="{{ $data->action_url }}" :wire="false"
                            :target="$data->target">

                            {{ $data->action_title }}
                        </x-ui.button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <section
        class=" relative flex md:hidden overflow-hidden  bg-center h-[532px] bg-no-repeat bg-[length:100%_100%]  justify-center items-center"
        style="background-image: url('{{ storage_url($data->mobile_image) }}')">
        <div class="bg-[#0f002978] py-30 bg-opacity-0 relative z-10 w-full">
            <div class="container py-30 relative z-10 align-left  w-100vw">

                <h1 class="text-5xl md:text-6xl font-semibold mb-6 text-text-white text-center">{{ $data->title }}</h1>
                <p class="text-xl text-text-white mb-15 max-w-2xl text-center">
                    {{ $data->content }}
                </p>

                <div class="flex flex-col md:flex-row gap-4 justify-start">
                    <div>
                        <x-ui.button class="py-2! px-3!" href="{{ $data->action_url }}" :wire="false"
                            :target="$data->target">

                            {{ $data->action_title }}
                        </x-ui.button>
                    </div>
                </div>
            </div>
        </div>
    </section>

