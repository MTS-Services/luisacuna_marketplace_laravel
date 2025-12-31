<div>
    <div class="mb-8">
        <h2 class="text-2xl sm:text-3xl font-bold text-text-primary">{{ __('Feedback') }}</h2>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
        <!-- Completed Orders Card -->
        <div class="bg-bg-secondary p-6 rounded-2xl  hover:border-zinc-700 transition-all duration-300">
            <div class="flex flex-col space-y-4">
                <div class="bg-bg-info w-15 h-15 rounded-xl flex items-center justify-center">
                    <x-phosphor name="arrows-down-up" class="w-6 h-6 text-zinc-400 rotate-90" />
                </div>
                <div>
                    <p class="text-text-secondary text-sm mb-1">{{ __('Completed orders') }}</p>
                    <p class="text-text-white text-3xl font-bold">{{ $completedOrders ?? 1300 }}</p>
                </div>
            </div>
        </div>

        <!-- Positive Feedback Card -->
        <div class="bg-bg-secondary p-6 rounded-2xl  hover:border-zinc-700 transition-all duration-300">
            <div class="flex flex-col space-y-4">
                <div class="bg-bg-info w-15 h-15 rounded-xl flex items-center justify-center">
                    <x-phosphor-thumbs-up-fill class="w-6 h-6 fill-zinc-500" />
                </div>
                <div>
                    <p class="text-text-secondary text-sm mb-1">{{ __('Positive feedback') }}</p>
                    <p class="text-text-white text-3xl font-bold">{{ $positiveFeedback ?? 1290 }}</p>
                </div>
            </div>
        </div>

        <!-- Negative Feedback Card -->
        <div class="bg-bg-secondary p-6 rounded-2xl  hover:border-zinc-700 transition-all duration-300">
            <div class="flex flex-col space-y-4">
                <div class="bg-bg-info w-15 h-15 rounded-xl flex items-center justify-center">
                    <x-phosphor-thumbs-up-fill class="w-6 h-6 fill-red-500 rotate-180" />
                </div>
                <div>
                    <p class="text-text-secondary text-sm mb-1">{{ __('Negative feedback') }}</p>
                    <p class="text-text-white text-3xl font-bold">{{ $negativeFeedback ?? 10 }}</p>
                </div>
            </div>
        </div>

        <!-- Feedback Score Card -->
        <div class="bg-bg-secondary p-6 rounded-2xl  hover:border-zinc-700 transition-all duration-300">
            <div class="flex flex-col space-y-4">
                <div class="bg-bg-hover w-15 h-15 rounded-xl flex items-center justify-center">
                    <x-phosphor-star-fill class="w-6 h-6 fill-yellow-400" />
                </div>
                <div>
                    <p class="text-text-secondary text-sm mb-1">{{ __('Feedback score') }}</p>
                    <p class="text-text-white text-3xl font-bold">{{ $feedbackScore ?? '99.23%' }}</p>
                </div>
            </div>
        </div>
    </div>


    <div class="py-15">
        <div class="max-w-8xl mx-auto bg-bg-secondary p-5 sm:p-15 rounded-lg">
            <!-- Filter Buttons -->
            <div class="flex gap-1 xxxs:gap-5 mb-6">
                <button wire:click="setTab('all')"
                    class="px-2 xxxs:px-6 py-1 xxxs:py-2.5 rounded-full font-medium transition-all duration-300 shadow-lg
                {{ $activeTab === 'all' ? 'bg-accent text-text-white' : 'bg-zinc-50 text-accent hover:bg-gray-50' }}">
                    {{ __('All') }}
                </button>

                {{-- <button wire:click="setTab('positive')"
                class="px-2 xxxs:px-6 py-1 xxxs:py-2.5 rounded-full font-medium transition-all duration-300 shadow-md flex items-center gap-2
                {{ $activeTab === 'positive' ? 'bg-accent text-text-white' : 'bg-zinc-50 text-accent hover:bg-gray-50' }}">
                {{ __('Positive') }}
                <x-phosphor-thumbs-up-fill class="w-5 h-5 fill-zinc-500 "  />
            </button> --}}
                <button wire:click="setTab('positive')"
                    class="px-2 xxxs:px-6 py-1 xxxs:py-2.5 rounded-full font-medium transition-all duration-300 shadow-md flex items-center gap-2  {{ $activeTab === 'positive' ? 'bg-accent text-text-white' : 'bg-zinc-50 text-accent hover:bg-gray-50' }}">
                    {{ __('Positive') }}
                    <x-phosphor-thumbs-up-fill
                        class="w-5 h-5 {{ $activeTab === 'positive' ? 'fill-white' : 'fill-zinc-500' }}" />
                </button>


                <button wire:click="setTab('negative')"
                    class="px-2 xxxs:px-6 py-1 xxxs:py-2.5 rounded-full font-medium transition-all duration-300 shadow-md flex items-center gap-2
                {{ $activeTab === 'negative' ? 'bg-accent text-text-white' : 'bg-zinc-50 text-accent hover:bg-gray-50' }}">
                    {{ __('Negative') }}
                    <x-phosphor-thumbs-down-fill class="w-5 h-5 fill-red-500" />
                </button>
            </div>

            <!-- Feedback List -->
            <div class="space-y-4">
                @forelse($feedbacks as $feedback)
                    <div
                        class="bg-bg-info backdrop-blur-sm rounded-2xl p-6 border border-zinc-800/10 hover:border-zinc-700 transition-all duration-300">
                        <div
                            class="flex items-start justify-between {{ $feedback['type'] === 'negative' ? 'mb-3' : '' }}">
                            <div class="flex items-start gap-3">
                                @if ($feedback['type'] === 'positive')
                                    <x-phosphor-thumbs-up-fill class="w-5 h-5 text-accent mt-1 flex-shrink-0" />
                                @else
                                    <x-phosphor-thumbs-down-fill
                                        class="w-5 h-5 text-red-500 mt-1 fill-red-500 flex-shrink-0" />
                                @endif

                                <div>
                                    <div class="flex items-center gap-2 mb-1">
                                        <span
                                            class="text-text-white font-semibold">{{ __($feedback['category']) }}</span>
                                        <span class="text-zinc-500">|</span>
                                        <span
                                            class="text-text-secondary text-sm">{{ __($feedback['username']) }}</span>
                                    </div>

                                    @if ($feedback['type'] === 'positive')
                                        <p class="text-text-secondary text-sm">{{ __($feedback['comment']) }}</p>
                                    @endif
                                </div>
                            </div>
                            <span class="text-text-secondary text-sm">{{ $feedback['date'] }}</span>
                        </div>

                        @if ($feedback['type'] === 'negative')
                            <p class="text-text-secondary text-sm leading-relaxed ml-8">
                                {{ __($feedback['comment']) }}
                            </p>
                        @endif
                    </div>
                @empty
                    <div class="text-center py-10">
                        <p class="text-text-secondary">{{ __('No feedback found') }}</p>
                    </div>
                @endforelse
            </div>
        </div>
        <div>
            <ul class="flex justify-end items-center gap-1 mt-14 pr-4">
                <li class="py-0.5 px-3 text-text-primary cursor-pointer rounded hover:bg-zinc-500">Previous</li>
                <li class="py-0.5 px-3 text-text-primary cursor-pointer rounded hover:bg-zinc-500 ">1</li>
                <li class="py-0.5 px-3 bg-zinc-500 text-text-primary cursor-pointer rounded hover:bg-zinc-500 ">2</li>
                <li class="py-0.5 px-3 text-text-primary cursor-pointer rounded hover:bg-zinc-500">Next</li>
            </ul>
        </div>
    </div>
</div>
