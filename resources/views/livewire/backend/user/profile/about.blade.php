<div>
  <livewire:backend.user.profile.profile-component :user="$user" />
    <section class="container mx-auto bg-bg-primary rounded-2xl mb-10 p-5 sm:p-10 md:p-20">
        <div class="mb-5">
            <h2 class="font-semibold text-3xl">{{ __('About') }}</h2>
        </div>
        <div class="flex flex-col gap-5">
            <div class="p-6 bg-white/10 rounded-2xl">
                <div class="flex items-center justify-between">
                    <div class="">
                        <h3 class="text-2xl font-semibold text-text-white">{{ __('Description') }}</h3>
                    </div>
                    <div class="">
                        <x-flux::icon name="pencil-square" class="w-5 h-5 inline-block" stroke="white" />
                    </div>
                </div>
                <div class="mt-2">
                    <div class="">
                        <p class="text-base text-text-white">
                            {{ __('Hey there!') }}
                        </p>
                    </div>
                    <div class="">
                        <p class="text-base text-text-white">
                            {{ __('At PixelStoreLAT, we bring you the best digital deals, game keys, and in-game items —fast, safe, and hassle-free. Trusted by thousands of gamers worldwide with 97% positive reviews. Level up your experience with us today!') }}
                        </p>
                    </div>
                </div>
            </div>
            <div class="p-6 bg-white/10 rounded-2xl">
                <div class="">
                    <p class="text-base text-text-white">
                        {{ __('Registered: Feb 20, 2023') }}
                    </p>
                </div>
            </div>
        </div>
    </section>

</div>
