<section class="mx-auto bg-bg-primary">
    <div class="container mx-auto">
        {{-- breadcrumb --}}
        <div class="flex gap-4 items-center py-10">
            <x-phosphor name="less-than" variant="regular" class="w-4 h-4 text-zinc-400" />
            <h2 class="text-text-white text-base">
                {{ __('All Orders') }}

            </h2>
        </div>
        <div class="flex justify-between mb-5">
            <div class="flex gap-5">
                <div>
                    <div class="w-10 h-10 md:w-16 md:h-16">
                        <img src="{{ storage_url($order?->source?->game?->logo) }}" alt="{{ $order?->source?->game?->name }}"
                            class="rounded" />
                    </div>
                </div>
                <div>
                    <h2 class="text-text-white text-2xl font-semibold line-clamp-1">
                        {{-- {{ $order?->source?->name }} --}}
                        {{ $order->source?->translatedName(app()->getLocale()) ?? 'Unknown' }}
                    </h2>
                    <p class="text-text-white font-normal text-base line-clamp-1">
                        {{ __('Order ID:') }} {{ $order->order_id }}
                    </p>
                </div>
            </div>
            <div>
                @if ($isVisitSeller)
                    <x-ui.button wire:click="cancelOrder"
                        class="bg-pink-700! w-fit! py-2! px-4! sm:py-3! sm:px-6! border-none!">
                        {{ __('Cancel') }}
                    </x-ui.button>
                  @else
                 
                   @if(!$hasDispute)
                    <x-ui.button 
                        wire:click="{{ $order->is_disputed ? '' : '$set(\'showDisputeModal\', true)' }}"
                        class="bg-pink-700! w-fit! py-2! px-4! sm:py-3! sm:px-6! border-none!"
                        >
                        {{ __('Dispute') }}
                     </x-ui.button>
                    @else 
                    
                        <x-ui.button class="bg-pink-700! w-fit! py-2! px-4! sm:py-3! sm:px-6! border-none! opacity-50! cursor-not-allowed!">
                            {{ __('Disputed') }}
                        </x-ui.button>
                    @endif
                
                @endif

            </div>
        </div>
        
        <div class="block lg:flex gap-6 justify-between items-start">
            <div class="w-full lg:w-2/3">
                <div class=" bg-bg-secondary p-4 sm:p-10 rounded-2xl">
                    <div class="flex gap-4 items-center">
                        <div class="bg-bg-info rounded-full p-3">
                            <x-phosphor name="check" variant="regular" class="w-9 h-9 text-zinc-400" />
                        </div>
                        <div>
                            <h3 class="text-text-white text-base sm:text-2xl font-semibold">
                                {{ $order->status->label() }}
                            </h3>
                        </div>
                    </div>
                    <div class="mt-7">
                        <p class="text-text-white text-base font-normal mb-2">
                            {{ $order->notes ?? __('No notes') }}</p>
                    </div>
                    <div class="mt-7">
                        <h2 class="text-text-white text-base sm:text-2xl font-semibold"> {{ __('Order Disputed') }}</h2>
                        <p class="text-text-white text-base font-normal mt-3">
                            {{ $order?->disputes?->reason}}
                        </p>
                    </div>
                </div>



                @if (!$isVisitSeller)
                    <div class="bg-bg-secondary p-4 sm:p-10 rounded-2xl mt-6">
                        <div class="flex gap-4 items-center">
                            <div>
                                <h3 class="text-text-white text-base sm:text-2xl font-semibold">
                                    {{ empty($feedback) ? __('Add feedback') : __('Your Feedback') }}
                                </h3>
                            </div>
                        </div>
                        @if (empty($feedback))
                            <form wire:submit.prevent="submitFeedback" method="POST">
                                <div class="">
                                    <div class="flex gap-2 my-4">
                                        <label class="cursor-pointer">
                                            <input type="radio" name="type" wire:model="type"
                                                value="{{ \App\Enums\FeedbackType::POSITIVE->value }}"
                                                class="sr-only peer">
                                            <div
                                                class="bg-bg-secondary dark:bg-bg-primary rounded-lg p-3 peer-checked:ring-2 peer-checked:ring-zinc-500 transition-all">
                                                <x-phosphor name="thumbs-up" variant="solid"
                                                    class="w-10 h-10 fill-zinc-500 peer-checked:fill-zinc-600" />
                                            </div>
                                        </label>

                                        <label class="cursor-pointer">
                                            <input type="radio" name="type" wire:model="type"
                                                value="{{ \App\Enums\FeedbackType::NEGATIVE->value }}"
                                                class="sr-only peer">
                                            <div
                                                class="bg-bg-secondary dark:bg-bg-primary rounded-lg p-3 peer-checked:ring-2 peer-checked:ring-pink-500 transition-all">
                                                <x-phosphor name="thumbs-down" variant="solid"
                                                    class="w-10 h-10 fill-pink-500 peer-checked:fill-pink-600" />
                                            </div>
                                        </label>
                                    </div>
                                    @error('type')
                                        <span class="text-pink-500 text-sm">{{ $message }}</span>
                                    @enderror

                                    <div class="mb-6">
                                        <label class="block text-text-white font-medium mb-2">
                                            {{ __('Your Comment') }}
                                        </label>
                                        <textarea wire:model="commentText" rows="5"
                                            class="w-full bg-bg-info text-text-white rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-accent resize-none text-xs sm:text-sm"
                                            placeholder="{{ __('Write your comment here...') }}"> </textarea>
                                        @error('commentText')
                                            <span class="text-pink-500 text-sm">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="flex justify-end gap-3">
                                        <div class="w-full md:w-auto">
                                            <x-ui.button type="submit" class="w-auto py-2!">
                                                {{ __('Submit') }}
                                            </x-ui.button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        @else
                            <div
                                class="bg-bg-info flex items-center gap-2 rounded-lg py-3 px-6 mt-7 hover:opacity-80 transition-opacity">
                                {{-- @if ($feedback->type === \App\Enums\FeedbackType::POSITIVE->value)
                                    <x-phosphor name="thumbs-up" variant="solid" class="w-5 h-5 fill-zinc-700" />
                                @else
                                    <x-phosphor name="thumbs-down" variant="solid" class="w-5 h-5 fill-pink-600" />
                                @endif --}}
                                {{-- <flux:icon name="{{ $feedback->type->icon() }}"
                                    class="w-5 h-5 {{ $feedback->type->iconColor() }}" /> --}}

                                <x-phosphor name="{{ $feedback->type->icon() }}" variant="solid"
                                    class="w-5 h-5 {{ $feedback->type->iconColor() }}" />

                                <p class="text-text-white text-base font-normal">
                                    {{ $feedback->message }}
                                </p>
                            </div>
                        @endif
                    </div>
                @else
                    <div class="bg-bg-secondary p-4 sm:p-10 rounded-2xl mt-6">
                        <div class="flex gap-4 items-center">
                            <div>
                                <h3 class="text-text-white text-base sm:text-2xl font-semibold">
                                    {{ __('Buyer feedback') }}
                                </h3>
                            </div>
                        </div>
                        @if ($feedback)
                            <div
                                class="bg-bg-info flex items-center gap-2 rounded-lg py-3 px-6 mt-7 hover:opacity-80 transition-opacity">
                                <x-phosphor name="{{ $feedback->type->icon() }}" variant="solid"
                                    class="w-5 h-5 {{ $feedback->type->iconColor() }}" />
                                <p class="text-text-white text-base font-normal">
                                    {{ $feedback->message }}
                                </p>
                            </div>
                        @else
                            <div
                                class="bg-bg-info flex items-center gap-2 rounded-lg py-3 px-6 mt-7 hover:opacity-80 transition-opacity">
                                <p class="text-text-white text-base font-normal">
                                    {{ __('No feedback') }}
                                </p>
                            </div>
                        @endif

                    </div>
                @endif
                <div class="bg-bg-info rounded-lg mt-10">
                    <!-- User Header -->
                    <livewire:backend.user.chat.message :key="'message-' . $conversationId" />
                </div>
            </div>
            <div class="w-full lg:w-1/3">
                <div class="bg-bg-secondary rounded-[20px] p-7 mb-6 mt-6 md:mt-0">
                    <p class="text-2xl font-semibold mb-6">{{ __('Delivery time') }}</p>

                    {{-- <div class="flex items-center justify-between text-center">
                        <!-- Hours -->
                        <div class="flex-1">
                            <p class="text-3xl text-text-white font-semibold">7</p>
                            <p class="text-xl text-text-white font-normal mt-1">{{ __('Hours') }}</p>
                        </div>

                        <!-- Divider -->
                        <div class="w-px h-16 bg-zinc-700"></div>

                        <!-- Minutes -->
                        <div class="flex-1">
                            <p class="text-3xl font-semibold">59</p>
                            <p class="text-xl text-text-white font-normal mt-1">{{ __('Minutes') }}</p>
                        </div>

                        <!-- Divider -->
                        <div class="w-px h-16 bg-zinc-700"></div>

                        <!-- Seconds -->
                        <div class="flex-1">
                            <p class="text-3xl font-semibold">52</p>
                            <p class="text-xl text-text-white font-normal mt-1">{{ __('Seconds') }}</p>
                        </div>
                    </div> --}}
                    <div class="flex items-center justify-between text-center">
                        <div class="flex-1">
                            {{ $order?->source?->translatedDeliveryTimeline(app()->getLocale()) }}
                        </div>
                    </div>
                </div>

                <div class="bg-bg-secondary p-4 sm:p-7 mt-10 lg:mt-0 rounded-[20px]">
                    <div class="flex gap-4 items-center">
                        <h3 class="text-text-white text-2xl font-semibold">{{ __('Order Details') }}</h3>
                    </div>
                    <div class="">
                        <div class="flex justify-between mt-7">
                            <p class="text-text-white text-base font-semibold">{{ __('Game') }}</p>
                            <div class="flex gap-2 items-center">
                                <div>
                                    <div class="w-6 h-6">
                                        <img src="{{ storage_url($order?->source?->game?->logo) }}"
                                            alt="{{ $order?->source?->game?->name }}"
                                            class="w-full h-full object-cover rounded-full" />

                                    </div>
                                </div>
                                <p class="text-text-white text-base font-normal">{{ $order?->source?->game?->name }}
                                </p>
                            </div>
                        </div>
                        <div class="flex justify-between mt-2">
                            <p class="text-text-white text-base font-semibold">{{ __('Username') }}</p>
                            <a href="{{ route('profile', $order?->user?->username) }}"
                                class="text-text-white text-base font-normal">
                                {{ $order?->user->username }}</a>
                        </div>
                        <div class="flex justify-between mt-2">
                            <p class="text-text-white text-base font-semibold">{{ __('Device') }}</p>
                            <p class="text-text-white text-base font-normal">{{ $order?->source?->platform?->name }}
                            </p>
                        </div>
                        <div class="flex justify-between mt-2">
                            @if ($isVisitSeller)
                                <p class="text-text-white text-base font-semibold">{{ __('Buyer') }}</p>
                                <p class="flex items-center gap-2 text-base font-normal">
                                    <a href="{{ route('profile', $order?->user?->username) }}"
                                        class="text-pink-500 inline-block">{{ $order?->user?->username }}</a>
                                    <span class="text-text-white">|</span>
                                    <span class="w-2.5 h-2.5 bg-green-500 rounded-full"></span>
                                    <span class="text-text-white">{{ __('Online') }}</span>
                                </p>
                            @else
                                <p class="text-text-white text-base font-semibold">{{ __('Seller') }}</p>
                                <p class="flex items-center gap-2 text-base font-normal">
                                    <a href="{{ route('profile', $order?->source?->user?->username) }}"
                                        class="text-pink-500 inline-block">{{ $order?->source?->user?->username }}</a>
                                    <span class="text-text-white">|</span>
                                    <span class="w-2.5 h-2.5 bg-green-500 rounded-full"></span>
                                    <span class="text-text-white">{{ __('Online') }}</span>
                                </p>
                            @endif
                        </div>
                    </div>
                    <div class="flex w-full md:w-auto justify-center items-center mt-10!">

                        <x-ui.button class="w-fit! py-3! px-6!"
                            href="{{ route('user.order.detail', ['orderId' => $order->order_id]) }}">
                            {{ __('View full description') }}
                            <x-phosphor-arrow-right-light
                                class="w-5 h-5 stroke-text-btn-secondary group-hover:stroke-text-btn-primary" /></x-ui.button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="pb-10"></div>

    {{-- Dispute Modal --}}
    <div 
        x-data="{ show: @entangle('showDisputeModal') }"
        x-show="show"
        x-cloak
        class="fixed inset-0 z-50 overflow-y-auto"
        @keydown.escape.window="show = false">
        
        {{-- Overlay/Shadow --}}
      {{-- Overlay/Shadow --}}
    <div 
        x-show="show"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        @click="show = false"
        class="fixed inset-0 bg-bg-primary/50 backdrop-blur-sm" {{-- Added backdrop-blur-sm and changed opacity syntax --}}
    >
    </div>

        {{-- Modal Content --}}
        <div class="flex items-center justify-center min-h-screen p-4">
            <div 
                x-show="show"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 transform scale-95"
                x-transition:enter-end="opacity-100 transform scale-100"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 transform scale-100"
                x-transition:leave-end="opacity-0 transform scale-95"
                @click.stop
                class="relative bg-bg-secondary rounded-lg shadow-xl w-full sm:max-w-md lg:max-w-xl">
                
                {{-- Close Button --}}
                <button 
                    @click="show = false"
                    class="absolute top-4 right-4 text-zinc-400 hover:text-text-white transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>

                {{-- Modal Header --}}
                <div class="p-6">
                    <h2 class="text-xl font-semibold text-text-white">{{ __('Open Dispute') }}</h2>
                </div>

                {{-- Modal Body --}}
                <div class="p-6 py-0">

                    <div class="mt-0">
                        <label class="block text-text-white font-medium mb-2">
                            {{ __('Dispute Reason') }}
                        </label>
                        <textarea 
                            wire:model="disputeReason"
                            rows="2"
                            class="w-full bg-bg-info text-text-white rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-pink-500 resize-none"
                            placeholder="{{ __('Explain why you are opening a dispute...') }}"></textarea>
                        @error('disputeReason')
                            <span class="text-pink-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                {{-- Modal Footer --}}
                <div class="p-6 flex justify-end gap-3">
                    {{-- Cancel Button --}}
                    <x-ui.button 
                        class="bg-pink-700! w-fit! py-2! px-4! sm:py-3! sm:px-6! border-none!"
                        @click="show = false"
                    >
                        {{ __('Cancel') }}
                    </x-ui.button>
                    
                    {{-- Submit Dispute Button --}}
                    <x-ui.button 
                        wire:click="submitDispute"
                         class="bg-pink-700! w-fit! py-2! px-4! sm:py-3! sm:px-6! border-none!"
                    >
                        {{ __('Submit Dispute') }}
                    </x-ui.button>
                </div>
            </div>
        </div>
    </div>

    <style>
        [x-cloak] { 
            display: none !important; 
        }
    </style>
</section>