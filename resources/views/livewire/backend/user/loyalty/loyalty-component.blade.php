<div class="min-h-screen py-8 px-4">
    <div class="">
        {{-- Top Cards Section --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            {{-- Bronze Level Card --}}
            <div class="bg-bg-secondary rounded-2xl p-4 sm:p-10  border-primary-700/30">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-text-primary font-open-sans text-lg">{{ __('How it works?') }}</h3>
                    <div class="flex items-center gap-2 bg-zinc-50/10 px-3 py-1.5 rounded-full">
                        <x-phosphor-coin class="fill-yellow-500 w-5 h-5" weight="fill" />
                        {{-- <span class="text-text-white font-semibold">{{ user()->rank_points }}</span> --}}
                        <span class="text-text-white font-semibold">{{ $user->userPoint?->points ?? 0 }}</span>
                    </div>
                </div>

                <div class="px-0 2xl:px-24">
                    <div class="flex justify-center mb-6">
                        <div class="relative">
                            <div
                                class="w-26 h-26 rounded-full flex items-center justify-center shadow-lg overflow-hidden">
                                <img src="{{ storage_url($rank?->icon) }}" alt="" class="w-full h-full">
                            </div>
                        </div>
                    </div>
                    <div class="text-center mb-4">
                        <div class="flex justify-between">
                            <h4 class="text-text-white font-semibold text-xl mb-2">{{ $currentRank?->name ?? 'N/A' }}
                            </h4>
                            <div class="text-text-white text-sm">
                                {{-- {{ $user->userPoint?->points ?? 0 . ' / ' . ($currentRank?->maximum_points === null ? $user->rank_points . '-' : $currentRank->maximum_points) }} --}}
                                {{ $this->user->userPoint?->points ?? 0 }} /
                                {{ $currentRank?->maximum_points === null ? $this->user->rank_points . '-' : $currentRank->maximum_points }}
                            </div>
                        </div>
                        <div class="w-full xl:max-w-full mx-auto bg-white rounded-full h-2 mt-2">
                            <div class="bg-linear-to-r from-pink-500 to-pink-600 h-2 rounded-full"
                                style="width: {{ $progress }}%">
                            </div>
                        </div>
                    </div>
                </div>

                @if ($nextRank)
                    <p class="text-text-white text-center text-xl">
                        {{ __('You need an additional') }}
                        {{ $pointsNeeded }}
                        {{ __('points to reach the') }} {{ $nextRank?->name }} {{ __('level.') }}
                    </p>
                @endif

            </div>

            {{-- Available Points Card --}}
            <div class="rounded-3xl p-4 sm:p-10 bg-pink-200 dark:bg-pink-900">
                <div class="mb-6">
                    <h3 class="text-text-white font-semibold text-xl mb-4">{{ __('Available points') }}</h3>
                    <div class="flex items-center gap-2">
                        <x-phosphor-coin class="fill-yellow-500 w-6 h-6" weight="fill" />
                        <span class="text-text-white font-bold text-3xl">{{ $user->userPoint?->points ?? 0 }}</span>
                    </div>
                </div>

                <p class="text-text-white/90 text-sm mb-6">
                    {{ __('Collect a minimum of 10,000 points and unlock a $1 reward.') }}
                </p>

                <div class="border-t-3 border-pink-600 mb-6"></div>

                <div class="flex items-center justify-between">
                    <div>
                        <div class="text-text-white font-bold text-2xl mb-1">{{ __('10,000 points') }}</div>
                        <div class="text-text-white/70 text-sm">{{ __('$1 Store credit') }}</div>
                    </div>
                    <x-ui.button class="sm:w-auto! py-2!">
                        {{ __('Redeem') }}
                    </x-ui.button>
                </div>
            </div>
        </div>

        {{-- Achievements Section --}}
        <div class="mb-8">
            <div class="flex items-center gap-3 mb-2">
                <h2 class="text-text-white font-open-sans text-2xl font-bold">{{ __('Achievements completed') }}</h2>
            </div>
            <p class="text-text-white text-sm ">0 / {{ $achievements?->count() ?? 0 }} {{ __('completed') }}</p>
        </div>

        {{-- Achievement Cards Grid --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            {{-- Critic Achievement --}}

            @if ($achievements)
                @forelse ($achievements as $achievement)
                    <div class="glass-card rounded-2xl p-6  border-primary-700/30">
                        <div class="flex items-center gap-4 mb-9">
                            <div
                                class="bg-bg-secondary w-20 h-20 rounded-xl flex items-center justify-center flex-shrink-0">
                                <img src="{{ storage_url($achievement->icon) }}" alt=""
                                    class="w-full h-full rounded-xl">
                            </div>
                            <div class="flex-1">
                                <h4 class="text-text-white font-semibold font-lato text-lg sm:text-3xl mb-1">
                                    {{ $achievement->title }}</h4>
                                <p class="text-text-white text-sm sm:text-base">{!! $achievement->description !!}</p>
                            </div>
                        </div>
                        <div class="flex items-center justify-between text-sm mb-2">
                            <span class="text-text-white text-base sm:text-xl">{{ __('0 / 1 To unlock') }}</span>
                            <div class="flex items-center gap-1">
                                <x-phosphor-coin class="fill-yellow-500 w-4 h-4" weight="fill" />
                                <span
                                    class="text-text-white font-semibold text-base sm:text-xl">+{{ $achievement->point_reward }}</span>
                            </div>
                        </div>
                        <div class="w-full bg-white rounded-full h-2">
                            <div class="bg-gradient-to-r from-pink-500 to-pink-600 h-2 rounded-full" style="width: 10%">
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="bg-bg-secondary rounded-2xl p-6  border-primary-700/30 text-center lg:col-span-2">
                        <h2 class="text-text-white font-open-sans text-3xl xl:text-4xl font-bold mb-6">
                            {{ __('No achievements') }}
                        </h2>
                        <p class="text-text-white max-w-3xl font-open-sans text-xl font-normal mx-auto mb-6">
                            {{ __('You have not unlocked any achievements yet. Start engaging with our platform to earn points and unlock exciting rewards!') }}
                        </p>
                    </div>
                @endforelse
            @else
                <div class="bg-bg-primary rounded-2xl p-6  border-primary-700/30 text-center lg:col-span-2">
                    <h2 class="text-text-white font-open-sans text-2xl sm:text-3xl xl:text-4xl font-bold mb-6">
                        {{ __('No achievements') }}
                    </h2>
                    <p class="text-text-white max-w-3xl font-open-sans text-xl font-normal mx-auto mb-6">
                        {{ __('You have not unlocked any achievements yet. Start engaging with our platform to earn points and unlock exciting rewards!') }}
                    </p>
                </div>
            @endif
        </div>

        {{-- CTA Card --}}
        <div class="glass-card rounded-2xl p-4 sm:p-8 py-6 sm:py-12 bg-linear-to-r from-zinc-500/30 from-0% via-zinc-500/30 via-20% to-pink-500/30 text-center">
            <h2 class="text-text-white font-open-sans text-2xl sm:text-3xl xl:text-4xl font-bold mb-6">
                {{ __('Start Your Reward Journey Today') }}
            </h2>
            <p class="text-text-white max-w-3xl font-open-sans text-base sm:text-xl font-normal mx-auto mb-6">
                {{ __('Make your first purchase today and start tracking your journey toward exciting rewards. Each order helps you unlock new levels, bonuses, and exclusive offers. Stay motivated and see your progress grow with every step!') }}
            </p>

            <a wire:navigate href="{{ route('home') }}" class="inline-block mx-auto">
                <x-ui.button class="sm:w-auto! py-2! mt-6">
                    {{ __('Browse for more') }}
                </x-ui.button>
            </a>
        </div>
    </div>
</div>
