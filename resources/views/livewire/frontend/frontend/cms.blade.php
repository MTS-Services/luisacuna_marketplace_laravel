<div>

    <div class="bg-bg-primary text-text-white font-sans min-h-screen">

        <div class="max-w-7xl mx-auto py-12 px-6">

            <div class="text-center mb-10">
                <h2 class="text-xl font-bold text-text-black dark:text-text-white"> {{ $typeEnum->label() }}</h2>
                <p class="text-gray-500 text-sm">{{ __('Update Time : ') . $cms?->updated_at_formatted }}</p>
            </div>

            <div class="space-y-8 prose prose-lg dark:prose-invert max-w-none mx-auto">
                {!! $cms?->translatedContent(app()->getLocale()) !!}
            </div>

            @if ($cms)
                <div class="flex justify-end space-x-4 pt-10">

                    {{-- 👍 Helpful --}}
                    <button
                        {{ !$cms->helpful_cooldown_active && $cms->is_useful !== true ? "wire:click=useful({$cms->id})" : '' }}
                        class="flex items-center px-5 py-2.5 rounded-full text-sm font-medium shadow-md transition
        {{ $cms->helpful_cooldown_active || $cms->is_useful === true
            ? 'bg-gray-200 text-gray-400 cursor-not-allowed pointer-events-none'
            : 'bg-gray-100 text-text-purple hover:bg-gray-200' }}">

                        <x-phosphor-thumbs-up-fill
                            class="w-5 h-5 mr-2
            {{ $cms->helpful_cooldown_active || $cms->is_useful === true ? 'fill-gray-400' : 'fill-zinc-500' }}" />

                        {{ __("It's helpful") }}
                    </button>


                    <button
                        {{ !$cms->helpful_cooldown_active && $cms->is_useful !== false ? "wire:click=notUseful({$cms->id})" : '' }}
                        class="flex items-center px-5 py-2.5 rounded-full text-sm font-medium shadow-md transition
        {{ $cms->helpful_cooldown_active || $cms->is_useful === false
            ? 'bg-gray-200 text-gray-400 cursor-not-allowed pointer-events-none'
            : 'bg-gray-100 text-text-purple hover:bg-gray-200' }}">

                        <x-phosphor-thumbs-down-fill
                            class="w-5 h-5 mr-2
            {{ $cms->helpful_cooldown_active || $cms->is_useful === false ? 'fill-gray-400' : 'fill-zinc-500' }}" />

                        {{ __("It's not helpful") }}
                    </button>

                </div>
            @endif


            @if ($typeEnum->value === \App\Enums\CmsType::HOW_TO_BUY->value)
                <div class="mt-20 p-10 text-center rounded-lg dark:bg-bg-secondary bg-bg-primary shadow-2xl">
                    <h2 class="text-3xl font-medium mb-4 tracking-wider text-text-white">
                        {{ __('Your Purchase is Protected!') }}
                    </h2>

                    <p class="text-text-white mb-6 max-w-3xl mx-auto">
                        {{ __('Digital Commerce priorities your security. Our escrow system safeguards your payment until you confirm delivery, and our Buyer Protection Policy ensures fair resolution in case of any issues. Buy with absolute confidence!') }}
                    </p>

                    <a href="{{ route('home') }}#popular-games"
                        class="px-8 py-3 bg-purple-600 text-white font-medium rounded-full hover:bg-gray-200  hover:text-zinc-500 transition duration-300 shadow-md">
                        {{ __('Start Shopping Now') }}
                    </a>
                </div>
            @endif
            @if ($typeEnum->value === \App\Enums\CmsType::BUYER_PROTECTION->value)
                <div class="mt-18 py-12 text-center rounded-lg bg-bg-primary dark:bg-bg-secondary shadow-2xl">
                    <h2 class="text-3xl font-extrabold mb-4 tracking-wider">
                        {{ __('Your Purchase is Protected!') }}
                    </h2>
                    <p class="text-text-white mb-6 max-w-3xl mx-auto">
                        {{ __('Digital Commerce priorities your security. Our escrow system safeguards your payment until you confirm delivery, and our Buyer Protection Policy ensures fair resolution in case of any issues. Buy with absolute confidence!') }}
                    </p>
                    <div class="flex! justify-center! items-center!">
                        <x-ui.button href="{{ route('home') }}#popular-games"
                            class="w-fit! px-6! py-3! bg-purple-800 text-text-secondery font-medium rounded-full hover:bg-bg-white hover:text-zinc-500">
                            {{ __('Start Shopping Now') }}
                        </x-ui.button>
                    </div>
                </div>
            @endif
            @if ($typeEnum->value === \App\Enums\CmsType::HOW_TO_SELL->value)
                <div class=" text-text-white font-[Inter]">
                    <div class="max-w-7xl mx-auto px-6 md:px-12 md:py-10">
                        <div class="border border-pink-600/60 rounded-2xl p-8 md:p-10 ">
                            <h2 class="text-pink-500 text-2xl font-semibold mb-4">{{ __('Why Sell with Swapy.gg?') }}
                            </h2>
                            <h3 class="text-lg font-semibold text-text-white mb-4">
                                {{ __('Heading: Benefits of Selling on Swapy.gg') }}</h3>
                            <ul class="list-disc list-inside text-gray-300 space-y-2">
                                <li>
                                    <span class="font-medium">{{ __('Global Reach:') }}</span>
                                    <span class="font-normal">
                                        {{ __('Access a vast community of buyers worldwide.') }}
                                    </span>
                                </li>
                                <li>
                                    <span class="font-medium">{{ __('Secure Transactions:') }}</span>
                                    <span class="font-normal">
                                        {{ __('Our escrow and Seller Protection policies protect your earnings.') }}
                                    </span>
                                </li>
                                <li>
                                    <span class="font-medium">{{ __('Easy Management:') }}</span>
                                    <span class="font-normal">
                                        {{ __('User-friendly dashboard for listing, managing, and tracking sales.') }}
                                    </span>
                                </li>
                                <li>
                                    <span class="font-medium">{{ __('Dedicated Support:') }}</span>
                                    <span class="font-normal">
                                        {{ __('Our team is here to assist you with any questions or issues.') }}
                                    </span>
                                </li>
                                <li>
                                    <span class="font-medium">{{ __('Flexible Payouts:') }}</span>
                                    <span class="font-normal">
                                        {{ __('Convenient withdrawals via Payoneer.') }}
                                    </span>
                                </li>
                            </ul>


                            <div class="flex flex-wrap gap-4 mt-8">
                                <a wire.navigate href="{{ route('user.offers') }}"
                                    class="bg-bg-container2 text-text-white px-6 py-2 rounded-full font-medium hover:opacity-90 transition">{{ __('Start Selling') }}</a>

                                <a href="{{ route('seller-protection') }}" wire:navigate
                                    class=" border bg-white text-text-purple px-6 py-2 rounded-full font-medium hover:bg-zinc-500 hover:text-text-primary transition">{{ __('Sellers Protection Rules') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

</div>
