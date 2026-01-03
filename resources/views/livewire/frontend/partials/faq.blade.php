@php 

$routeName = Route::currentRouteName();



@endphp

<section class=" {{ $routeName == 'faq' ? 'bg-bg-primary' : 'bg-transparent'}} pt-20">
    <div class="container {{ $routeName == 'faq' ? 'bg-bg-secondary' : 'bg-bg-primary'}} p-6 lg:p-14 xl:p-20 flex justify-center wrap flex-col rounded-2xl" x-data="{ active: null, tab: 'buyers' }">

        <h2 class="text-text-white text-2xl sm:text-40px text-center mb-3 font-semibold">{{ 'Frequently Asked Questions' }}
        </h2>

        @if($routeName == 'faq')
        <p class="mb-10 text-2xl text-text-secondery text-center">Everything you need to know about buying and selling on Swapy.gg.</p>
        @endif
        <!-- Tabs -->
<div class="max-w-xs mx-auto flex justify-between mb-10 bg-bg-secondary rounded-full px-3 py-3">
    <button
        wire:click="changeFaqType('{{ \App\Enums\FaqType::BUYER->value }}')"
        class="transition-colors duration-300 font-normal text-xl
            {{ $faqs_type === \App\Enums\FaqType::BUYER->value
                ? 'bg-bg-hover px-5 py-3 rounded-full shadow-lg text-text-white'
                : 'text-text-secondery px-5 py-3' }}">
        For Buyers
    </button>

    <button
        wire:click="changeFaqType('{{ \App\Enums\FaqType::SELLER->value }}')"
        class="transition-colors duration-300 font-normal text-xl
            {{ $faqs_type === \App\Enums\FaqType::SELLER->value
                ? 'bg-bg-hover px-5 py-3 rounded-full shadow-lg text-text-white'
                : 'text-text-secondery px-5 py-3' }}">
        For Sellers
    </button>
</div>


        <!-- FAQ Items for Buyers -->
        <template x-if="tab === 'buyers'">
            <div class="space-y-4">
                @if($faqs_type ==  \App\Enums\FaqType::BUYER->value) 
                @foreach ($faqs as $index => $faq)
              
                <div class=" {{ $routeName == 'faq' ? 'bg-bg-info' : 'bg-bg-secondary'}}  rounded-xl p-4 cursor-pointer"
                        @click="active === {{ $index }} ? active = null : active = {{ $index }}">
                        <div class="flex justify-between items-center">
                            <h3 class="text-text-white text-xl font-semibold">{{ $faq->question }}</h3>
                            <svg :class="active === {{ $index }} ? 'rotate-180' : ''"
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
                @endif
            </div>
        </template>

        <!-- FAQ Items for Sellers -->
        <template x-if="tab === 'sellers'">
            <div class="space-y-4">
                @if($faqs_type ==  \App\Enums\FaqType::SELLER->value) 
                
                @foreach ($faqs as $index => $faq)
                    <div class=" {{ $routeName == 'faq' ? 'bg-bg-info' : 'bg-bg-secondary'}}  rounded-xl p-4 cursor-pointer"
                        @click="active === {{ $index }} ? active = null : active = {{ $index }}">
                        <div class="flex justify-between items-center">
                            <h3 class="text-text-white text-xl font-semibold">{{ $faq->question }}</h3>
                            <svg :class="active === {{ $index }} ? 'rotate-180' : ''"
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
                @endif
            </div>
        </template>
    </div>
    <div class=" {{ $routeName == 'faq' ? 'pt-30' : 'pt-0'}}  "></div>
</section>