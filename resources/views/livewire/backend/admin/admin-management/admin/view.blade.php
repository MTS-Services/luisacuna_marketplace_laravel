<div>
    {{-- Page Header --}}
    <div class="glass-card rounded-2xl p-4 lg:p-6 mb-6">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <h2 class="text-xl lg:text-2xl font-bold text-text-primary">
                {{ __('Permission Details') }}
            </h2>
            <div class="flex items-center gap-2 w-full sm:w-auto">
                <x-ui.button href="{{ route('admin.am.permission.edit', encrypt($data->id)) }}" variant="secondary"
                    class="w-auto py-2!">
                    <flux:icon name="pencil" class="w-4 h-4 stroke-text-btn-secondary group-hover:stroke-text-btn-primary" />
                    {{ __('Edit') }}
                </x-ui.button>

                <x-ui.button href="{{ route('admin.am.permission.index') }}" class="w-auto! py-2!">
                    <flux:icon name="arrow-left"
                        class="w-4 h-4 stroke-text-btn-primary group-hover:stroke-text-btn-secondary" />
                    {{ __('Back') }}
                </x-ui.button>
            </div>
        </div>
    </div>
</div>
