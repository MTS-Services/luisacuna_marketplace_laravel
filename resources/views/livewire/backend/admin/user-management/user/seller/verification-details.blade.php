<section>
    {{-- Page Header --}}
    <div class="glass-card rounded-2xl p-4 lg:p-6 mb-6">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <h2 class="text-xl lg:text-2xl font-bold text-text-black dark:text-text-white">
                {{ __('Seller Verificaiton Details') }}
            </h2>
            <div class="flex items-center gap-2">
                <x-ui.button href="{{ route('admin.um.user.seller-verification') }}" class="w-auto! py-2!">
                    <flux:icon name="arrow-left" class="w-4 h-4 stroke-white" />
                    {{ __('Back') }}
                </x-ui.button>
            </div>
        </div>
    </div>

    {{-- Table Component --}}


</section>

