<main class="mx-auto">
    <section class="container mx-auto">
        {{-- breadcrumb --}}

        <h2 class="text-text-white text-2xl font-semibold">
            {{ $data->product->name ?? 'N/A' }}
        </h2>

        <p class="text-text-white">
            Order ID: {{ $data->order_id }}
        </p>



        <div class="flex gap-4 items-center my-10">
            <x-phosphor name="less-than" variant="regular" class="w-4 h-4 text-zinc-400" />
            <h2 class="text-text-white text-base">
                {{ __('All Orders') }}
            </h2>
        </div>

        <div class="flex justify-between">
            <div class="flex gap-5">
                <div>
                    <div class="w-10 h-10 md:w-16 md:h-16">
                        <img src="{{ asset('assets/images/order/order.png') }}" alt="Product Name"
                            class="w-full h-full rounded-lg">
                    </div>
                </div>
                <div>
                    <h2 class="text-text-white text-2xl font-semibold line-clamp-1">
                        {{ __('Mercury Spark — Ultimate 5-Star Boost') }}
                    </h2>
                    <p class="text-text-white font-normal text-base line-clamp-1">
                        {{ __('Order ID: ') }} {{ $data->order_id }}</p>
                </div>
            </div>
            <div class="">
                <x-ui.button class="bg-pink-700! w-fit! py-2! px-4! sm:py-3! sm:px-6! border-none!">
                    {{ __('Canceled') }}
                </x-ui.button>
            </div>
        </div>
        <div class="block lg:flex gap-6 justify-between items-start mt-10 mb-20">
            <div class="w-full lg:w-2/3">
                <div class=" bg-bg-secondary p-4 sm:p-10 rounded-lg">
                    <div class="flex gap-4 items-center">
                        <div class="bg-bg-info rounded-full p-3">
                            <x-phosphor name="info" variant="regular" class="w-6 h-6 text-zinc-400" />
                        </div>
                        <h3 class="text-text-white text-base sm:text-2xl font-semibold">{{ __('Order') }}
                            {{ $data->status }}</h3>
                    </div>
                    <div class="">
                        <div class="mt-7">
                            <p class="text-text-white text-base mb-2">{{ __('Dispute reason:') }}</p>
                            <p class="text-text-white text-base sm:text-2xl font-semibold">
                                {{ __('I have another issue') }}</p>
                        </div>
                        <div class="mt-5">
                            <p class="text-text-white text-base mb-2">{{ __('Cancelled by:') }}</p>
                            <p class="text-text-white text-base sm:text-2xl font-semibold">{{ __('Seller') }}</p>
                        </div>
                        <div class="mt-5">
                            <p class="text-text-white text-base mb-2">{{ __('Cancelation reason:') }}</p>
                            <p class="text-text-white text-base sm:text-2xl font-semibold">{{ __('Others') }}</p>
                        </div>
                        <div class="mt-5">
                            <p class="text-text-white text-base mb-2">{{ __('Comment:') }}</p>
                            <p class="text-text-white text-base sm:text-2xl font-semibold">
                                {{ __('buyer requested to cancel the order') }}</p>
                        </div>
                    </div>
                </div>
                <div class="mt-10">
                    <!-- Bullet Points -->
                    <ul class="list-disc list-inside text-text-white text-xl">
                        <li class="text-text-white text-base sm:text-xl font-normal mb-3">
                            {{ __('You received a refund for this order in your') }}
                            <span class="text-pink-500">{{ __('"Company name"') }}</span
                                class="text-text-white text-xl font-normal"> {{ __('balance') }}
                        </li>
                        <li class="text-text-white text-base sm:text-xl font-normal mb-3">
                            {{ __('When you place a new order, your balance will be used automatically') }}
                        </li>
                        <li class="text-text-white text-base sm:text-xl font-normal mb-3">
                            {{ __('You will not be charged payment fees again') }}</li>
                    </ul>

                    <!-- Button -->
                    <div class="flex w-full md:w-auto mt-10!">
                        <x-ui.button class="w-fit! py-3! px-6!">
                            {{ __('Buy again') }}
                            <x-phosphor-arrow-right-light
                                class="w-5 h-5 stroke-text-btn-secondary group-hover:stroke-text-btn-primary" /></x-ui.button>
                    </div>
                    <!-- Note -->
                    <p class="mt-4 text-xs text-text-white">
                        <span class="text-text-white text-base  font-semibold">{{ __('Note: ') }}</span>
                        {{ __('Spend your') }} <span class="text-pink-500">{{ __('"Company name"') }}</span>
                        {{ __('balance') }}
                    </p>
                </div>
            </div>

            <div class="w-full lg:w-1/3 bg-bg-secondary p-4 sm:p-7 mt-10 lg:mt-0 rounded-lg">
                <div class="flex gap-4 items-center">
                    <h3 class="text-text-white text-2xl font-semibold">{{ __('Order cancelled') }}</h3>
                </div>
                <div class="">
                    <div class="flex justify-between mt-7">
                        <p class="text-text-white text-base font-semibold mb-2">{{ __('Game') }}</p>
                        <div class="flex gap-2 items-center">
                            <div>
                                <div class="w-6 h-6">
                                    <img src="{{ asset('assets/images/order.png') }}" alt="Product Name"
                                        class="w-full h-full object-cover">
                                </div>
                            </div>
                            <p class="text-text-white text-base font-normal">{{ __('Fortnite') }}</p>
                        </div>
                    </div>
                    <div class="flex justify-between mt-2">
                        <p class="text-text-white text-base font-semibold mb-2">{{ __('Username') }}</p>
                        <p class="text-text-white text-base font-normal">{{ __('acuzone') }}</p>
                    </div>
                    <div class="flex justify-between mt-2">
                        <p class="text-text-white text-base font-semibold mb-2">{{ __('Device') }}</p>
                        <p class="text-text-white text-base font-normal">{{ __('PC') }}</p>
                    </div>
                    <div class="flex justify-between mt-2">
                        <p class="text-text-white text-base font-semibold mb-2">{{ __('Seller') }}</p>
                        <p class="text-text-white text-base font-normal">{{ __('D18QUAN Online') }}</p>
                    </div>
                    <div class="flex justify-between mt-2">
                        <p class="text-text-white text-base font-semibold mb-2">{{ __('Total price') }}</p>
                        <p class="text-text-white text-base font-normal">{{ __('$1.20') }}</p>
                    </div>
                </div>
                <div class="flex w-full md:w-auto justify-center items-center mt-10!">
                    <a href="{{ route('user.order-description') }}">
                        <x-ui.button class="w-fit! py-3! px-6!">
                            {{ __('View full description') }}
                            <x-phosphor-arrow-right-light
                                class="w-5 h-5 stroke-text-btn-secondary group-hover:stroke-text-btn-primary" /></x-ui.button>
                    </a>
                </div>
            </div>
        </div>
        {{-- message --}}

        {{-- <div class="bg-bg-info rounded-lg mt-20 p-5 sm:p-20">

                <!-- User Header -->
                <div class="bg-bg-secondary rounded-lg p-5 border-l-4 border-pink-500 mb-10">
                    <div class="flex items-center gap-3">
                        <img src="https://ui-avatars.com/api/?name=D18QUANB&background=853EFF&color=fff" alt="User"
                            class="w-10 h-10 rounded-full">
                        <div>
                            <h3 class="text-text-white text-2xl font-semibold">{{ __('D18QUANB') }}</h3>
                            <p class="text-text-white text-base font-normal">{{ __('Order for Items') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Order Created Message -->
                <div class="bg-bg-secondary rounded-lg p-5 border-l-4 border-pink-500 mb-10">
                    <div>
                        <p class="text-text-white text-base mb-2">{{ __('Order Created:') }} <a href="#">
                                https://www.companyname.ga/order/d8bcd674-dbde-4d98-9175-a4a031845de0</a></p>
                        <div class="flex items-center gap-2 text-primary-400 text-sm mb-1">
                            <x-phosphor name="link" variant="" class="fill-zinc-500" />

                            <span class="text-text-white">d8bcd674-dbde-4d98-9175-a4a031U58e0</span>
                        </div>
                        <a class="text-text-white text-xs" href="#">www.companyname.com</a>
                    </div>
                    <p class="text-text-white text-xs text-right mt-3">Oct 20 2025</p>
                </div>

                <!-- Order Disputed -->

                <div class="bg-bg-secondary rounded-lg p-5 border-l-4 border-pink-500 mb-10">
                    <div>
                        <p class="text-text-white text-base mb-2">{{ __('Order Disputed by Buyer:') }}</p>
                        <div class="flex items-center gap-2 text-primary-400 text-sm mb-1">
                            <span class="text-text-white">{{ __('Reason: I don\'t want it anymore') }}</span>
                        </div>
                    </div>
                    <p class="text-text-white text-xs text-right mt-3">Oct 20 2025</p>
                </div>

                <!-- Buyer Message -->
                <div>
                    <div class="flex items-center gap-3">
                        <img src="https://ui-avatars.com/api/?name=User&background=853EFF&color=fff" alt="User"
                            class="w-10 h-10 rounded-full">
                        <div class="flex-1">
                            <div class="bg-primary-800 rounded-lg">
                                <x:input type="text" placeholder="Hi, what's the problem?" class="w-full" />
                            </div>

                        </div>
                    </div>
                    <p class="text-text-white text-right text-xs mt-1">Oct 20 2025</p>
                </div>

                <!-- Seller Message -->
                <div class="mt-10">
                    <div class="flex items-center gap-3">
                        <div class="flex-1">
                            <div class="bg-primary-800 rounded-lg">
                                <p class="bg-zinc-500 px-6 py-3 text-right rounded-lg">
                                    {{ __('Please cancel the order, I don\'t want it anymore.') }}</p>
                            </div>

                        </div>
                        <img src="https://ui-avatars.com/api/?name=User&background=853EFF&color=fff" alt="User"
                            class="w-10 h-10 rounded-full">
                    </div>
                    <p class="text-text-white text-right text-xs mt-1">Oct 20 2025</p>
                </div>

                <!-- Buyer Response -->
                <div>
                    <div class="flex items-center gap-3 mt-10">
                        <img src="https://ui-avatars.com/api/?name=User&background=853EFF&color=fff" alt="User"
                            class="w-10 h-10 rounded-full">
                        <div class="flex-1">
                            <div class="bg-primary-800 rounded-lg">
                                <x:input type="text" wire:model.defer="messageText" wire:keydown.enter="send"
                                    placeholder="Okay" class="w-full" />
                            </div>

                        </div>
                    </div>
                    <p class="text-text-white text-right text-xs mt-1">Oct 20 2025</p>
                </div>

                <!-- Dispute Won -->

                <div class="bg-bg-secondary rounded-lg p-5 border-l-4 border-pink-500 mt-10">
                    <div>
                        <p class="text-text-white text-base mb-2">{{ __('Order Disputed by Buyer:') }}</p>
                        <div class="flex items-center gap-2 text-primary-400 text-sm mb-1">
                            <span class="text-text-white">{{ __('Reason: I don\'t want it anymore') }}</span>
                        </div>
                    </div>
                    <p class="text-text-white text-xs text-right mt-3">Oct 30 2025</p>
                </div>

                <!-- Conversation Closed -->
                <div class="bg-primary-800 rounded-lg mt-10">
                    <p class="bg-zinc-500 px-6 py-3 rounded-lg">
                        {{ __('this conversation is no longer active.') }}</p>
                </div>

            </div> --}}

        <div class="bg-bg-info rounded-lg mt-20 p-5 sm:p-20" wire:poll.3s>

            <!-- User Header -->
            <div class="bg-bg-secondary rounded-lg p-5 border-l-4 border-pink-500 mb-10">
                <div class="flex items-center gap-3">
                    <img src="https://ui-avatars.com/api/?name=D18QUANB&background=853EFF&color=fff" alt="User"
                        class="w-10 h-10 rounded-full">
                    <div>
                        <h3 class="text-text-white text-2xl font-semibold">{{ __('D18QUANB') }}</h3>
                        <p class="text-text-white text-base font-normal">{{ __('Order for Items') }}</p>
                    </div>
                </div>
            </div>

            {{-- ================= MESSAGES LOOP ================= --}}
            @foreach ($messages as $msg)
                @if ($msg->is_system_message)
                    <div class="bg-bg-secondary rounded-lg p-5 border-l-4 border-pink-500 mb-10">
                        <p class="text-text-white text-base mb-2">
                            {{ $msg->message }}
                        </p>
                        <p class="text-text-white text-xs text-right mt-3">
                            {{ $msg->created_at->format('M d Y') }}
                        </p>
                    </div>
                @else
                    {{-- Seller Message (Right side - auth user) --}}
                    @if ($msg->creater_id == auth()->id())
                        <div class="mt-10">
                            <div class="flex items-center gap-3">
                                <div class="flex-1">
                                    <div class="bg-primary-800 rounded-lg">
                                        <p class="bg-zinc-500 px-6 py-3 text-right rounded-lg text-text-white">
                                            {{ $msg->message }}
                                        </p>
                                    </div>
                                </div>
                                <img src="https://ui-avatars.com/api/?name=Me&background=853EFF&color=fff"
                                    alt="Me" class="w-10 h-10 rounded-full">
                            </div>
                            <p class="text-text-white text-right text-xs mt-1">
                                {{ $msg->created_at->format('M d Y') }}
                            </p>
                        </div>
                    @else
                        {{-- Buyer Message (Left side - other user) --}}
                        {{-- <div class="mt-10">
                            <div class="flex items-center gap-3">
                                <img src="https://ui-avatars.com/api/?name=User&background=853EFF&color=fff"
                                    alt="User" class="w-10 h-10 rounded-full">
                                <div class="flex-1">
                                    <div class="bg-primary-800 rounded-lg">
                                        <p class="bg-primary-800 px-6 py-3 rounded-lg text-text-white">
                                            {{ $msg->message }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <p class="text-text-white text-xs mt-1">
                                {{ $msg->created_at->format('M d Y') }}
                            </p>
                        </div> --}}
                        <div class="bg-bg-secondary rounded-lg p-5 border-l-4 border-pink-500 mt-10">
                            <div>
                                {{-- <p class="text-text-white text-base mb-2">{{ __('Order Disputed by Buyer:') }}</p> --}}
                                <div class="flex items-center gap-2 text-primary-400 text-sm mb-1">
                                    <span class="text-text-white">{{ $msg->message }}</span>
                                </div>
                            </div>
                            <p class="text-text-white text-xs text-right mt-3">{{ $msg->created_at->format('M d Y') }}</p>
                        </div>
                    @endif
                @endif
            @endforeach


            {{-- ================= INPUT BOX ================= --}}
            <div class="mt-10">
                <div class="flex items-center gap-3">
                    <img src="https://ui-avatars.com/api/?name=Me&background=853EFF&color=fff"
                        class="w-10 h-10 rounded-full">

                    <div class="flex-1">
                        <div class="bg-primary-800 rounded-lg">
                            <x:input wire:model.defer="messageText" wire:keydown.enter="send" type="text"
                                placeholder="Okay" class="w-full" />
                        </div>
                    </div>
                </div>
            </div>

            </>




            <div class="bg-bg-info rounded-lg mt-20 mb-29 py-8! px-4! md:py-20 md:px-10">
                <div class="flex items-center gap-3">
                    <div class="w-16 h-16">
                        <img src="{{ asset('assets/images/order/Security.png') }}" alt="Security tips"
                            class="w-full h-full rounded-lg">
                    </div>
                    <div class="">
                        <h2 class="text-text-white text-3xl font-semibold">{{ __('Security tips') }}</h2>
                    </div>
                </div>
                <div class="mt-8">
                    <p class="text-text-white">
                        {{ __('For your protection, you must always pay and communicate directly through the Eldorado website. If you stay on Eldorado throughout the entire transaction—from payment, to communication, to delivery—you are protected by Tradeshield. Additionally, be aware that sellers will never ask for your currency or items back after the order is delivered, so you should not respond to any messages requesting this.') }}
                    </p>
                </div>
            </div>
    </section>
</main>
