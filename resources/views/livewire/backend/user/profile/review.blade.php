<div class="bg-bg-primary pb-10">
    <livewire:backend.user.profile.profile-component :user="$user" />
    <section class="container mx-auto bg-bg-secondary p-5! sm:p-10! rounded-2xl mb-10">
        <div class="">
            <h2 class="font-semibold text-3xl">{{ __('Reviews') }}</h2>
        </div>
        <div class="flex items-center gap-2 sm:gap-4 mt-5 mb-5">
            <div class="">
                <button x-on:click="$wire.set('type', 'all')"
                    class="{{ $reviewItem === 'all' ? 'bg-zinc-500 text-text-white' : 'bg-zinc-50 text-zinc-500' }} font-semibold border-1 border-zinc-500 py-1 px-2 xxs:py-2 xxs:px-4 sm:py-3 sm:px-6 rounded-2xl">{{ __('All') }}</button>
            </div>
            <div>
                <button x-on:click="$wire.set('type', 'positive')"
                    class="{{ $reviewItem === 'positive' ? 'bg-zinc-500 text-text-white' : 'bg-zinc-50 text-zinc-500' }} font-semibold border-1 border-zinc-500 py-1 px-2 xxs:py-2 xxs:px-4 sm:py-3 sm:px-6 rounded-2xl inline-flex items-center gap-2 justify-center">

                    {{ __('Positive') }}
                    {{-- <x-phosphor name="thumbs-up" variant="solid" class="fill-zinc-500 w-6 h-6 p-0! m-0!" /> --}}
                    <x-phosphor name="thumbs-up" variant="solid"
                        class="{{ $reviewItem === 'positive' ? 'fill-white' : 'fill-zinc-500' }} w-6 h-6 p-0! m-0!" />
                </button>
            </div>
            <div>
                <button x-on:click="$wire.set('type', 'negative')"
                    class="{{ $reviewItem === 'negative' ? 'bg-zinc-500 text-text-white' : 'bg-zinc-50 text-zinc-500' }} font-semibold border-1 border-zinc-500 py-1 px-2 xxs:py-2 xxs:px-4 sm:py-3 sm:px-6 rounded-2xl inline-flex items-center gap-2 justify-center">

                    {{ __('Negative') }}

                    {{-- <img src="{{ asset('assets/images/user_profile/thumb up filled.svg') }}" alt=""
                        class="inline-block"> --}}
                    <x-phosphor name="thumbs-down" variant="solid" class="fill-[#AF0F0F] w-6 h-6 p-0! m-0!" />
                </button>
            </div>
        </div>


        <div class="flex flex-col gap-5">
            @forelse ($feedbacks as $feedback)
                <div class="p-6 bg-bg-info rounded-2xl">
                    <div class="">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <x-phosphor name="{{ $feedback->type->icon() }}" variant="solid"
                                    class="w-5 h-5 {{ $feedback->type->iconColor() }}" />
                                <p class="font-semibold text-2xl">{{ $feedback->order->source->name }}</p>
                                {{-- <span class="border-l border-text-white self-stretch"></span>
                                    <p class="text-xs">{{ __('Yeg***') }}</p> --}}
                            </div>
                            <div class="">
                                <span>{{ $feedback->created_at->format('Y-m-d') }}</span>
                            </div>
                        </div>
                        <div class="mt-2">
                            <span class="font-normal text-base">
                                {{ $feedback->message }}
                            </span>
                        </div>
                    </div>
                </div>
            @empty
                <div>
                    No sd dslkjl;kkl
                </div>
            @endforelse
        </div>
        <x-frontend.pagination-ui :pagination="$pagination" />


    </section>
</div>
