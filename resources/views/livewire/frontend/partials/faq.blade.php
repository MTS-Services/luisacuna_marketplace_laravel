    <section class="bg-transparent mt-32">
        <div class="container bg-bg-primary p-0 sm:p-5 md:p-10 lg:p-14 xl:p-20 flex justify-center wrap flex-col rounded-2xl" x-data="{ active: 0, tab: 'buyers' }">

            <h2 class="text-text-white text-[40px] text-center mb-10 font-semibold">{{ ' Frequently Asked Questions' }}
            </h2>

            <!-- Tabs -->
            <div class="max-w-xs mx-auto flex justify-between mb-10 bg-bg-secondary rounded-full px-3 py-3">
                <button @click="tab = 'buyers'; active = 0" 
                    :class="tab === 'buyers' ? 'bg-bg-hover px-5 py-3 rounded-full shadow-lg text-text-white' :
                        'text-text-secondery px-5 py-3'"
                    class="transition-colors duration-300 font-normal text-xl">
                    {{ 'For Buyers' }}
                </button>
                <button @click="tab = 'sellers'; active = 0" 
                    :class="tab === 'sellers' ? 'bg-bg-hover px-5 py-3 rounded-full shadow-lg text-text-white' :
                        'text-text-secondery px-5 py-3'"
                    class="transition-colors duration-300 font-normal text-xl">
                    {{ __('For Sellers') }}
                </button>
            </div>

            <!-- FAQ Items for Buyers -->
            <template x-if="tab === 'buyers'">
                <div class="space-y-4">

                    @foreach ($faqs_buyer as $index => $faq )

                  

                        <div class="bg-bg-secondary rounded-xl p-4 cursor-pointer"
                        @click="active === {{ $index }} ? active = null : active = {{$index}}">
                        <div class="flex justify-between items-center">
                            <h3 class="text-text-white text-xl font-semibold">{{ $faq->question }}</h3>
                            <svg :class="active === 0 ? 'rotate-180' : ''"
                                class="w-5 h-5 text-text-white transition-transform" fill="none"
                                stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                        <p x-show="active === {{ $index }}" x-transition class="mt-2 text-text-secondery text-base">
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

                 @foreach ($faqs_seller as $index => $faq )
                        <div class="bg-bg-secondary rounded-xl p-4 cursor-pointer"
                        @click="active === {{ $index }} ? active = null : active = {{$index}}">
                        <div class="flex justify-between items-center">
                            <h3 class="text-text-white text-xl font-semibold">{{ $faq->question }}</h3>
                            <svg :class="active === 0 ? 'rotate-180' : ''"
                                class="w-5 h-5 text-text-white transition-transform" fill="none"
                                stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                        <p x-show="active === {{ $index }}" x-transition class="mt-2 text-text-secondery text-base">
                            {{ $faq->answer }}
                        </p>
                    </div>
                    @endforeach


                </div>
            </template>
        </div>
    </section>