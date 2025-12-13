    <section class="py-20 ">
        <div class="bg-bg-secondary container p-18 flex justify-center wrap flex-col rounded-3xl" x-data="{ active: 0, tab: 'buyers' }">

            <h2 class="text-text-white text-center text-5xl  mb-6 font-semibold">{{ 'Frequently Asked Questions' }}
            </h2>

            <h5 class="text-text-white text-center text-2xl mb-6 font-medium">
                {{ 'Everything you need to know about buying and selling on Swapy.gg.' }}</h5>

            <!-- Tabs -->
            <div class="max-w-xs mx-auto flex justify-between mb-8  rounded-full px-4 py-4">
                <button @click="tab = 'buyers'; active = 0"
                    :class="tab === 'buyers' ? 'bg-zinc-800 px-8 py-5 rounded-full shadow-lg text-gray-200' :
                        'text-text-secondery px-6 py-4'"
                    class="transition-colors duration-300 text-lg">
                    {{ 'For Buyers' }}
                </button>
                <button @click="tab = 'sellers'; active = 0"
                    :class="tab === 'sellers' ?
                        'bg-bg-secondary px-8 py-5 rounded-full shadow-lg dark:bg-zinc-800 text-gray-400' :
                        'text-text-secondery px-6 py-4'"
                    class="transition-colors duration-300 text-lg">
                    {{ __('For Sellers') }}
                </button>
            </div>

            <!-- FAQ Items for Buyers -->
            <template x-if="tab === 'buyers'">
                <div class="space-y-4">

                    @foreach ($faqs_buyer as $index => $faq)
                        <div class="dark:bg-bg-border2 bg-bg-secondary rounded-xl p-10 cursor-pointer"
                            @click="active === {{ $index }} ? active = null : active = {{ $index }}">
                            <div class="flex justify-between items-center">
                                <h3 class="text-text-white font-semibold">{{ $faq->question }}</h3>
                                <svg :class="active === 0 ? 'rotate-180' : ''"
                                    class="w-5 h-5 text-text-white transition-transform" fill="none"
                                    stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>
                            <p x-show="active === {{ $index }}" x-transition
                                class="mt-2 text-text-secondery text-sm">
                                {{ $faq->answer }}
                            </p>
                        </div>
                    @endforeach
                    <!-- Buyer FAQ Items -->


                </div>
            </template>

            <!-- FAQ Items for Sellers -->
            <template x-if="tab === 'sellers'">
                <div class="space-y-4">

                    @foreach ($faqs_seller as $index => $faq)
                        <div class="bg-bg-secondary rounded-xl p-4 cursor-pointer"
                            @click="active === {{ $index }} ? active = null : active = {{ $index }}">
                            <div class="flex justify-between items-center">
                                <h3 class="text-text-white font-semibold">{{ $faq->question }}</h3>
                                <svg :class="active === 0 ? 'rotate-180' : ''"
                                    class="w-5 h-5 text-text-white transition-transform" fill="none"
                                    stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>
                            <p x-show="active === {{ $index }}" x-transition
                                class="mt-2 text-text-secondery text-sm">
                                {{ $faq->answer }}
                            </p>
                        </div>
                    @endforeach


                </div>
            </template>
        </div>
    </section>
