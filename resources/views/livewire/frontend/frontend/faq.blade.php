<div>


    <!-- FAQ Section -->
    <section class="py-20 bg-bg-secondary">
        <div class="container py-8" x-data="{ active: 0, tab: 'buyers' }">

            <h2 class="text-text-white text-center text-[40px] mb-6 font-semibold">{{__('Frequently Asked Questions')}}
            </h2>

            <!-- Tabs -->
            <div class="max-w-xs mx-auto flex justify-between mb-8 bg-bg-primary rounded-full px-4 py-3">
                <button @click="tab = 'buyers'; active = 0"
                    :class="tab === 'buyers' ? 'bg-purple-700 px-5 py-3 rounded-full shadow-lg text-white' :
                        'text-text-secondery px-7'"
                    class="transition-colors duration-300 font-medium">
                    {{ 'For Buyers' }}
                </button>
                <button @click="tab = 'sellers'; active = 0"
                    :class="tab === 'sellers' ? 'bg-purple-700 px-5 py-3 rounded-full shadow-lg text-white' :
                        'text-text-secondery px-7'"
                    class="transition-colors duration-300 font-medium">
                    {{ __('For Sellers') }}
                </button>
            </div>

            <!-- FAQ Items for Buyers -->
            <template x-if="tab === 'buyers'">
                <div class="space-y-4">

                    <!-- Buyer FAQ Items -->
                    <div class="bg-bg-primary rounded-xl p-4 cursor-pointer"
                        @click="active === 0 ? active = null : active = 0">
                        <div class="flex justify-between items-center">
                            <h3 class="text-text-white font-semibold">{{ __('How do I buy a product?') }}</h3>
                            <svg :class="active === 0 ? 'rotate-180' : ''"
                                class="w-5 h-5 text-text-white transition-transform" fill="none"
                                stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                        <p x-show="active === 0" x-transition class="mt-2 text-text-secondery text-sm">
                            {{ __('Browse or search for your desired digital product. Click on the product, review the details, click "Buy No select your preferred payment method.') }}
                        </p>
                    </div>

                    <div class="bg-bg-primary rounded-xl p-4 cursor-pointer"
                        @click="active === 1 ? active = null : active = 1">
                        <div class="flex justify-between items-center">
                            <h3 class="text-text-white font-semibold">{{ __('What payment methods are accepted?') }}
                            </h3>
                            <svg :class="active === 1 ? 'rotate-180' : ''"
                                class="w-5 h-5 text-text-white transition-transform" fill="none"
                                stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                        <p x-show="active === 1" x-transition class="mt-2 text-text-secondery text-sm">
                            {{ __('We accept various payment methods including credit cards, PayPal, and more.') }}
                        </p>
                    </div>

                    <div class="bg-bg-primary rounded-xl p-4 cursor-pointer"
                        @click="active === 2 ? active = null : active = 2">
                        <div class="flex justify-between items-center">
                            <h3 class="text-text-white font-semibold">{{ __('What is the buyer protection policy?') }}
                            </h3>
                            <svg :class="active === 2 ? 'rotate-180' : ''"
                                class="w-5 h-5 text-text-white transition-transform" fill="none"
                                stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                        <p x-show="active === 2" x-transition class="mt-2 text-text-secondery text-sm">
                            {{ __('Our buyer protection policy ensures secure transactions and support for any disputes.') }}
                        </p>
                    </div>

                    <div class="bg-bg-primary rounded-xl p-4 cursor-pointer"
                        @click="active === 3 ? active = null : active = 3">
                        <div class="flex justify-between items-center">
                            <h3 class="text-text-white font-semibold">
                                {{ __('How do I receive my purchased digital product?') }}
                            </h3>
                            <svg :class="active === 3 ? 'rotate-180' : ''"
                                class="w-5 h-5 text-text-white transition-transform" fill="none"
                                stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                        <p x-show="active === 3" x-transition class="mt-2 text-text-secondery text-sm">
                            {{ __('After purchase, you will receive a download link or access instructions via email.') }}
                        </p>
                    </div>

                    <div class="bg-bg-primary rounded-xl p-4 cursor-pointer"
                        @click="active === 4 ? active = null : active = 4">
                        <div class="flex justify-between items-center">
                            <h3 class="text-text-white font-semibold">
                                {{ __("What if the seller doesn't deliver the product?") }}
                            </h3>
                            <svg :class="active === 4 ? 'rotate-180' : ''"
                                class="w-5 h-5 text-text-white transition-transform" fill="none"
                                stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                        <p x-show="active === 4" x-transition class="mt-2 text-text-secondery text-sm">
                            {{ __('Contact support immediately and we will assist you with dispute resolution.') }}
                        </p>
                    </div>
                </div>
            </template>

            <!-- FAQ Items for Sellers -->
            <template x-if="tab === 'sellers'">
                <div class="space-y-4">

                    <div class="bg-bg-primary rounded-xl p-4 cursor-pointer"
                        @click="active === 0 ? active = null : active = 0">
                        <div class="flex justify-between items-center">
                            <h3 class="text-text-white font-semibold">{{ __('How do I become a seller?') }}</h3>
                            <svg :class="active === 0 ? 'rotate-180' : ''"
                                class="w-5 h-5 text-text-white transition-transform" fill="none"
                                stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                        <p x-show="active === 0" x-transition class="mt-2 text-text-secondery text-sm">
                            {{ __('Click "Start Selling" or register an account and navigate to the seller dashboard. You will need to complete our seller verification pr providing personal information and an ID document.') }}
                        </p>
                    </div>

                    <div class="bg-bg-primary rounded-xl p-4 cursor-pointer"
                        @click="active === 1 ? active = null : active = 1">
                        <div class="flex justify-between items-center">
                            <h3 class="text-text-white font-semibold">
                                {{ __('Why do I need to be verified to sell?') }}</h3>
                            <svg :class="active === 1 ? 'rotate-180' : ''"
                                class="w-5 h-5 text-text-white transition-transform" fill="none"
                                stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                        <p x-show="active === 1" x-transition class="mt-2 text-text-secondery text-sm">
                            {{ __('Verification helps us ensure the authenticity and trustworthiness of sellers on our platform.') }}
                        </p>
                    </div>

                    <div class="bg-bg-primary rounded-xl p-4 cursor-pointer"
                        @click="active === 2 ? active = null : active = 2">
                        <div class="flex justify-between items-center">
                            <h3 class="text-text-white font-semibold">
                                {{ __('What kind of digital products can I sell?') }}</h3>
                            <svg :class="active === 2 ? 'rotate-180' : ''"
                                class="w-5 h-5 text-text-white transition-transform" fill="none"
                                stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                        <p x-show="active === 2" x-transition class="mt-2 text-text-secondery text-sm">
                            {{ __('You can sell ebooks, music, software, design files, and other digital goods.') }}
                        </p>
                    </div>

                    <div class="bg-bg-primary rounded-xl p-4 cursor-pointer"
                        @click="active === 3 ? active = null : active = 3">
                        <div class="flex justify-between items-center">
                            <h3 class="text-text-white font-semibold">{{ __('How do I list a product?') }}</h3>
                            <svg :class="active === 3 ? 'rotate-180' : ''"
                                class="w-5 h-5 text-text-white transition-transform" fill="none"
                                stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                        <p x-show="active === 3" x-transition class="mt-2 text-text-secondery text-sm">
                            {{ __('Register your product on the seller dashboard by providing the required details and uploading your files.') }}
                        </p>
                    </div>

                    <div class="bg-bg-primary rounded-xl p-4 cursor-pointer"
                        @click="active === 4 ? active = null : active = 4">
                        <div class="flex justify-between items-center">
                            <h3 class="text-text-white font-semibold">{{ __('How do I get paid?') }}</h3>
                            <svg :class="active === 4 ? 'rotate-180' : ''"
                                class="w-5 h-5 text-text-white transition-transform" fill="none"
                                stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                        <p x-show="active === 4" x-transition class="mt-2 text-text-secondery text-sm">
                            {{ __('Payments are processed securely via the platform, and funds are transferred according to your selected payout method.') }}
                        </p>
                    </div>

                </div>
            </template>
        </div>
    </section>

</div>
