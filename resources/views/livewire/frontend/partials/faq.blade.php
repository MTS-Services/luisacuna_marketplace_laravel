<section class="py-20 bg-bg-primary">
    <div class="container py-8 flex justify-center flex-col"
         x-data="{ active: null, tab: 'buyers' }">

        <h2 class="text-text-white text-center mb-6 font-semibold">
            {{ 'Frequently Asked Questions' }}
        </h2>

        <h5 class="text-text-white text-center text-2xl mb-6 font-medium">
            {{ 'Everything you need to know about buying and selling on Swapy.gg.' }}
        </h5>

        <!-- Tabs -->
        <div class="max-w-xs mx-auto flex justify-between mb-8 bg-bg-info rounded-full px-2 py-2">
            <button
                @click="tab = 'buyers'; active = null"
                :class="tab === 'buyers'
                    ? 'bg-bg-secondary px-5 py-3 rounded-full shadow-lg text-white'
                    : 'text-text-secondery px-5 py-3'"
                class="transition-colors duration-300 font-medium">
                {{ 'For Buyers' }}
            </button>

            <button
                @click="tab = 'sellers'; active = null"
                :class="tab === 'sellers'
                    ? 'bg-bg-secondary px-5 py-3 rounded-full shadow-lg text-white'
                    : 'text-text-secondery px-5 py-3'"
                class="transition-colors duration-300 font-medium">
                {{ 'For Sellers' }}
            </button>
        </div>

        <!-- Buyers -->
        <template x-if="tab === 'buyers'">
            <div class="space-y-4">
                @foreach ($faqs_buyer as $index => $faq)
                    <div class="bg-bg-secondary rounded-xl p-4 cursor-pointer"
                         @click="active === {{ $index }} ? active = null : active = {{ $index }}">
                        <div class="flex justify-between items-center">
                            <h3 class="text-text-white font-semibold">
                                {{ $faq->question }}
                            </h3>
                            <svg
                                :class="active === {{ $index }} ? 'rotate-180' : ''"
                                class="w-5 h-5 text-text-white transition-transform"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>

                        <p x-show="active === {{ $index }}"
                           x-transition
                           class="mt-2 text-text-secondery text-sm">
                            {{ $faq->answer }}
                        </p>
                    </div>
                @endforeach
            </div>
        </template>

        <!-- Sellers -->
        <template x-if="tab === 'sellers'">
            <div class="space-y-4">
                @foreach ($faqs_seller as $index => $faq)
                    <div class="bg-bg-secondary rounded-xl p-4 cursor-pointer"
                         @click="active === {{ $index }} ? active = null : active = {{ $index }}">
                        <div class="flex justify-between items-center">
                            <h3 class="text-text-white font-semibold">
                                {{ $faq->question }}
                            </h3>
                            <svg
                                :class="active === {{ $index }} ? 'rotate-180' : ''"
                                class="w-5 h-5 text-text-white transition-transform"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>

                        <p x-show="active === {{ $index }}"
                           x-transition
                           class="mt-2 text-text-secondery text-sm">
                            {{ $faq->answer }}
                        </p>
                    </div>
                @endforeach
            </div>
        </template>

    </div>
</se
