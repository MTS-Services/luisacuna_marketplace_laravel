<main class=" mx-auto relative">
    <section class="">
        <div class="inner_banner">
            <img src="{{ asset('assets/images/user_profile/inner_banner.png') }}" alt="" class="w-full">
        </div>
    </section>
    {{-- profile card --}}
    <section class="container mx-auto bg-zinc-900 p-10 rounded-2xl absolute top-20 left-1/2 translate-x-[-50%] ">
        <div class="flex justify-between">
            <div class="flex items-center gap-6">
                <div class="">
                    <img src="{{ asset('assets/images/user_profile/Ellipse 474.png') }}" alt="">
                </div>
                <div class="">
                    <h3 class="text-4xl font-semibold mb-2">Starriz.clo</h3>
                    <span class="text-base-400">Online</span>
                </div>
            </div>
            <div class="icon">
                <x-flux::icon name="pencil-square" class="w-6 h-6 inline-block" stroke="white" />
            </div>
        </div>
        <div class="border-b border-zinc-700 mt-6 mb-4"></div>
        <div class="flex gap-6">
            <a href="#" class=" group">
                <span class="relative z-10 ">Shop</span>
                <span class=""></span>
            </a>
            <a href="#" class=" group">
                <span class="relative z-10">Reviews</span>
                <span class=""></span>
            </a>
            <a href="#" class=" group">
                <span class="relative z-10">About</span>
                <span class=""></span>
            </a>
        </div>
    </section>
    <div class="min-h-70"></div>
    {{-- info --}}
    <section class="container mx-auto mb-30">
        <div class="mb-6">
            <h3 class="text-4xl text-zinc-50 mb-4">Shop</h3>

            <div class="flex gap-6 items-start">

                <div class="flex flex-col items-center">
                    <div class="w-[60px] h-[60px] mb-2 bg-zinc-500 rounded-xl flex items-center justify-center">
                        <img src="{{ asset('assets/images/user_profile/vector.png') }}" alt="Currency Icon"
                            class="w-[30px] h-[30px] object-contain">
                    </div>
                    <h3 class="text-sm font-medium text-zinc-50 whitespace-nowrap">Currency (0)</h3>
                </div>

                <div class="flex flex-col items-center">
                    <div class="w-[60px] h-[60px] mb-2 bg-zinc-800 rounded-xl flex items-center justify-center">
                        <img src="{{ asset('assets/images/user_profile/download (4) 1.png') }}" alt="Account Icon"
                            class="w-[30px] h-[30px] object-contain">
                    </div>
                    <h3 class="text-sm font-medium text-zinc-50 whitespace-nowrap">Account (0)</h3>
                </div>

                <div class="flex flex-col items-center">
                    <div class="w-[60px] h-[60px] mb-2 bg-zinc-800 rounded-xl flex items-center justify-center">
                        <img src="{{ asset('assets/images/user_profile/download 1.png') }}" alt="Items Icon"
                            class="w-[30px] h-[30px] object-contain">
                    </div>
                    <h3 class="text-sm font-medium text-zinc-50 whitespace-nowrap">Items (0)</h3>
                </div>

                <div class="flex flex-col items-center">
                    <div class="w-[60px] h-[60px] mb-2 bg-zinc-800 rounded-xl flex items-center justify-center">
                        <img src="{{ asset('assets/images/user_profile/download (2) 1.png') }}" alt="Top Ups Icon"
                            class="w-[30px] h-[30px] object-contain">
                    </div>
                    <h3 class="text-sm font-medium text-zinc-50 whitespace-nowrap">Top Ups (0)</h3>
                </div>

                <div class="flex flex-col items-center">
                    <div class="w-[60px] h-[60px] mb-2 bg-zinc-800 rounded-xl flex items-center justify-center">
                        <img src="{{ asset('assets/images/user_profile/download (1) 1.png') }}" alt="Gift Cards Icon"
                            class="w-[30px] h-[30px] object-contain">
                    </div>
                    <h3 class="text-sm font-medium text-zinc-50 whitespace-nowrap">Gift Cards (0)</h3>
                </div>

            </div>
            {{-- select game --}}
            <div class="w-lg mt-6 border-2 border-zinc-800 rounded-lg">
                <select name="" id="" class="w-full p-2">
                    <option value="All Game">All Game</option>
                </select>
            </div>

            {{-- games --}}
            <div class="grid grid-cols-4 gap-4 mt-10">
                <div class="bg-zinc-800 rounded-lg p-5">
                    <div class="flex gap-4">
                        <div class="profile">
                            <a href="">
                                <img src="{{ asset('assets/images/user_profile/frame.png') }}" alt="">
                            </a>
                        </div>
                        <div class="flex items-center">
                            <a href="" class="flex items-center gap-2">
                                <img src="{{ asset('assets/images/user_profile/Frame1.png') }}" alt=""
                                    class="w-5 h-5">
                                <span>PlayStation</span>
                            </a>
                        </div>
                        <div class="">
                            <span>.Stacked</span>
                        </div>
                    </div>
                    <div class="flex items-center gap-2 mt-5">
                        <span>
                            【1 SKIN】Galaxy ✴ PSN/XBOX/PC FULL ACCESS
                        </span>
                        <img src="{{ asset('assets/images/user_profile/product-image-container -_ image.png') }}"
                            alt="">
                    </div>
                    <div class="flex items-center justify-between mt-10">
                        <div class="">
                            <span>
                                PEN175.27
                            </span>
                        </div>
                        <div class="">
                            <span>
                                <x:flux::icon name="clock" class="w-6 h-6 inline-block" stroke="white" />
                                Instant
                            </span>
                        </div>
                    </div>
                </div>
                <div class="bg-zinc-800 rounded-lg p-5">
                    <div class="flex gap-4">
                        <div class="profile">
                            <a href="">
                                <img src="{{ asset('assets/images/user_profile/frame.png') }}" alt="">
                            </a>
                        </div>
                        <div class="flex items-center">
                            <a href="" class="flex items-center gap-2">
                                <img src="{{ asset('assets/images/user_profile/Frame1.png') }}" alt=""
                                    class="w-5 h-5">
                                <span>PlayStation</span>
                            </a>
                        </div>
                        <div class="">
                            <span>.Stacked</span>
                        </div>
                    </div>
                    <div class="flex items-center gap-2 mt-5">
                        <span>
                            【1 SKIN】Galaxy ✴ PSN/XBOX/PC FULL ACCESS
                        </span>
                        <img src="{{ asset('assets/images/user_profile/product-image-container -_ image.png') }}"
                            alt="">
                    </div>
                    <div class="flex items-center justify-between mt-10">
                        <div class="">
                            <span>
                                PEN175.27
                            </span>
                        </div>
                        <div class="">
                            <span>
                                <x:flux::icon name="clock" class="w-6 h-6 inline-block" stroke="white" />
                                Instant
                            </span>
                        </div>
                    </div>
                </div>
                <div class="bg-zinc-800 rounded-lg p-5">
                    <div class="flex gap-4">
                        <div class="profile">
                            <a href="">
                                <img src="{{ asset('assets/images/user_profile/frame.png') }}" alt="">
                            </a>
                        </div>
                        <div class="flex items-center">
                            <a href="" class="flex items-center gap-2">
                                <img src="{{ asset('assets/images/user_profile/Frame1.png') }}" alt=""
                                    class="w-5 h-5">
                                <span>PlayStation</span>
                            </a>
                        </div>
                        <div class="">
                            <span>.Stacked</span>
                        </div>
                    </div>
                    <div class="flex items-center gap-2 mt-5">
                        <span>
                            【1 SKIN】Galaxy ✴ PSN/XBOX/PC FULL ACCESS
                        </span>
                        <img src="{{ asset('assets/images/user_profile/product-image-container -_ image.png') }}"
                            alt="">
                    </div>
                    <div class="flex items-center justify-between mt-10">
                        <div class="">
                            <span>
                                PEN175.27
                            </span>
                        </div>
                        <div class="">
                            <span>
                                <x:flux::icon name="clock" class="w-6 h-6 inline-block" stroke="white" />
                                Instant
                            </span>
                        </div>
                    </div>
                </div>
                <div class="bg-zinc-800 rounded-lg p-5">
                    <div class="flex gap-4">
                        <div class="profile">
                            <a href="">
                                <img src="{{ asset('assets/images/user_profile/frame.png') }}" alt="">
                            </a>
                        </div>
                        <div class="flex items-center">
                            <a href="" class="flex items-center gap-2">
                                <img src="{{ asset('assets/images/user_profile/Frame1.png') }}" alt=""
                                    class="w-5 h-5">
                                <span>PlayStation</span>
                            </a>
                        </div>
                        <div class="">
                            <span>.Stacked</span>
                        </div>
                    </div>
                    <div class="flex items-center gap-2 mt-5">
                        <span>
                            【1 SKIN】Galaxy ✴ PSN/XBOX/PC FULL ACCESS
                        </span>
                        <img src="{{ asset('assets/images/user_profile/product-image-container -_ image.png') }}"
                            alt="">
                    </div>
                    <div class="flex items-center justify-between mt-10">
                        <div class="">
                            <span>
                                PEN175.27
                            </span>
                        </div>
                        <div class="">
                            <span>
                                <x:flux::icon name="clock" class="w-6 h-6 inline-block" stroke="white" />
                                Instant
                            </span>
                        </div>
                    </div>
                </div>
                <div class="bg-zinc-800 rounded-lg p-5">
                    <div class="flex gap-4">
                        <div class="profile">
                            <a href="">
                                <img src="{{ asset('assets/images/user_profile/frame.png') }}" alt="">
                            </a>
                        </div>
                        <div class="flex items-center">
                            <a href="" class="flex items-center gap-2">
                                <img src="{{ asset('assets/images/user_profile/Frame1.png') }}" alt=""
                                    class="w-5 h-5">
                                <span>PlayStation</span>
                            </a>
                        </div>
                        <div class="">
                            <span>.Stacked</span>
                        </div>
                    </div>
                    <div class="flex items-center gap-2 mt-5">
                        <span>
                            【1 SKIN】Galaxy ✴ PSN/XBOX/PC FULL ACCESS
                        </span>
                        <img src="{{ asset('assets/images/user_profile/product-image-container -_ image.png') }}"
                            alt="">
                    </div>
                    <div class="flex items-center justify-between mt-10">
                        <div class="">
                            <span>
                                PEN175.27
                            </span>
                        </div>
                        <div class="">
                            <span>
                                <x:flux::icon name="clock" class="w-6 h-6 inline-block" stroke="white" />
                                Instant
                            </span>
                        </div>
                    </div>
                </div>
                <div class="bg-zinc-800 rounded-lg p-5">
                    <div class="flex gap-4">
                        <div class="profile">
                            <a href="">
                                <img src="{{ asset('assets/images/user_profile/frame.png') }}" alt="">
                            </a>
                        </div>
                        <div class="flex items-center">
                            <a href="" class="flex items-center gap-2">
                                <img src="{{ asset('assets/images/user_profile/Frame1.png') }}" alt=""
                                    class="w-5 h-5">
                                <span>PlayStation</span>
                            </a>
                        </div>
                        <div class="">
                            <span>.Stacked</span>
                        </div>
                    </div>
                    <div class="flex items-center gap-2 mt-5">
                        <span>
                            【1 SKIN】Galaxy ✴ PSN/XBOX/PC FULL ACCESS
                        </span>
                        <img src="{{ asset('assets/images/user_profile/product-image-container -_ image.png') }}"
                            alt="">
                    </div>
                    <div class="flex items-center justify-between mt-10">
                        <div class="">
                            <span>
                                PEN175.27
                            </span>
                        </div>
                        <div class="">
                            <span>
                                <x:flux::icon name="clock" class="w-6 h-6 inline-block" stroke="white" />
                                Instant
                            </span>
                        </div>
                    </div>
                </div>
                <div class="bg-zinc-800 rounded-lg p-5">
                    <div class="flex gap-4">
                        <div class="profile">
                            <a href="">
                                <img src="{{ asset('assets/images/user_profile/frame.png') }}" alt="">
                            </a>
                        </div>
                        <div class="flex items-center">
                            <a href="" class="flex items-center gap-2">
                                <img src="{{ asset('assets/images/user_profile/Frame1.png') }}" alt=""
                                    class="w-5 h-5">
                                <span>PlayStation</span>
                            </a>
                        </div>
                        <div class="">
                            <span>.Stacked</span>
                        </div>
                    </div>
                    <div class="flex items-center gap-2 mt-5">
                        <span>
                            【1 SKIN】Galaxy ✴ PSN/XBOX/PC FULL ACCESS
                        </span>
                        <img src="{{ asset('assets/images/user_profile/product-image-container -_ image.png') }}"
                            alt="">
                    </div>
                    <div class="flex items-center justify-between mt-10">
                        <div class="">
                            <span>
                                PEN175.27
                            </span>
                        </div>
                        <div class="">
                            <span>
                                <x:flux::icon name="clock" class="w-6 h-6 inline-block" stroke="white" />
                                Instant
                            </span>
                        </div>
                    </div>
                </div>
                <div class="bg-zinc-800 rounded-lg p-5">
                    <div class="flex gap-4">
                        <div class="profile">
                            <a href="">
                                <img src="{{ asset('assets/images/user_profile/frame.png') }}" alt="">
                            </a>
                        </div>
                        <div class="flex items-center">
                            <a href="" class="flex items-center gap-2">
                                <img src="{{ asset('assets/images/user_profile/Frame1.png') }}" alt=""
                                    class="w-5 h-5">
                                <span>PlayStation</span>
                            </a>
                        </div>
                        <div class="">
                            <span>.Stacked</span>
                        </div>
                    </div>
                    <div class="flex items-center gap-2 mt-5">
                        <span>
                            【1 SKIN】Galaxy ✴ PSN/XBOX/PC FULL ACCESS
                        </span>
                        <img src="{{ asset('assets/images/user_profile/product-image-container -_ image.png') }}"
                            alt="">
                    </div>
                    <div class="flex items-center justify-between mt-10">
                        <div class="">
                            <span>
                                PEN175.27
                            </span>
                        </div>
                        <div class="">
                            <span>
                                <x:flux::icon name="clock" class="w-6 h-6 inline-block" stroke="white" />
                                Instant
                            </span>
                        </div>
                    </div>
                </div>
                <div class="bg-zinc-800 rounded-lg p-5">
                    <div class="flex gap-4">
                        <div class="profile">
                            <a href="">
                                <img src="{{ asset('assets/images/user_profile/frame.png') }}" alt="">
                            </a>
                        </div>
                        <div class="flex items-center">
                            <a href="" class="flex items-center gap-2">
                                <img src="{{ asset('assets/images/user_profile/Frame1.png') }}" alt=""
                                    class="w-5 h-5">
                                <span>PlayStation</span>
                            </a>
                        </div>
                        <div class="">
                            <span>.Stacked</span>
                        </div>
                    </div>
                    <div class="flex items-center gap-2 mt-5">
                        <span>
                            【1 SKIN】Galaxy ✴ PSN/XBOX/PC FULL ACCESS
                        </span>
                        <img src="{{ asset('assets/images/user_profile/product-image-container -_ image.png') }}"
                            alt="">
                    </div>
                    <div class="flex items-center justify-between mt-10">
                        <div class="">
                            <span>
                                PEN175.27
                            </span>
                        </div>
                        <div class="">
                            <span>
                                <x:flux::icon name="clock" class="w-6 h-6 inline-block" stroke="white" />
                                Instant
                            </span>
                        </div>
                    </div>
                </div>
                <div class="bg-zinc-800 rounded-lg p-5">
                    <div class="flex gap-4">
                        <div class="profile">
                            <a href="">
                                <img src="{{ asset('assets/images/user_profile/frame.png') }}" alt="">
                            </a>
                        </div>
                        <div class="flex items-center">
                            <a href="" class="flex items-center gap-2">
                                <img src="{{ asset('assets/images/user_profile/Frame1.png') }}" alt=""
                                    class="w-5 h-5">
                                <span>PlayStation</span>
                            </a>
                        </div>
                        <div class="">
                            <span>.Stacked</span>
                        </div>
                    </div>
                    <div class="flex items-center gap-2 mt-5">
                        <span>
                            【1 SKIN】Galaxy ✴ PSN/XBOX/PC FULL ACCESS
                        </span>
                        <img src="{{ asset('assets/images/user_profile/product-image-container -_ image.png') }}"
                            alt="">
                    </div>
                    <div class="flex items-center justify-between mt-10">
                        <div class="">
                            <span>
                                PEN175.27
                            </span>
                        </div>
                        <div class="">
                            <span>
                                <x:flux::icon name="clock" class="w-6 h-6 inline-block" stroke="white" />
                                Instant
                            </span>
                        </div>
                    </div>
                </div>
                <div class="bg-zinc-800 rounded-lg p-5">
                    <div class="flex gap-4">
                        <div class="profile">
                            <a href="">
                                <img src="{{ asset('assets/images/user_profile/frame.png') }}" alt="">
                            </a>
                        </div>
                        <div class="flex items-center">
                            <a href="" class="flex items-center gap-2">
                                <img src="{{ asset('assets/images/user_profile/Frame1.png') }}" alt=""
                                    class="w-5 h-5">
                                <span>PlayStation</span>
                            </a>
                        </div>
                        <div class="">
                            <span>.Stacked</span>
                        </div>
                    </div>
                    <div class="flex items-center gap-2 mt-5">
                        <span>
                            【1 SKIN】Galaxy ✴ PSN/XBOX/PC FULL ACCESS
                        </span>
                        <img src="{{ asset('assets/images/user_profile/product-image-container -_ image.png') }}"
                            alt="">
                    </div>
                    <div class="flex items-center justify-between mt-10">
                        <div class="">
                            <span>
                                PEN175.27
                            </span>
                        </div>
                        <div class="">
                            <span>
                                <x:flux::icon name="clock" class="w-6 h-6 inline-block" stroke="white" />
                                Instant
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
