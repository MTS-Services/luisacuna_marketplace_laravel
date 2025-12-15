<section>
    {{-- Page Header --}}
    <div class="glass-card rounded-2xl p-4 lg:p-6 mb-6">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <h2 class="text-xl lg:text-2xl font-bold text-text-primary">
                {{ __('Announcement List') }}
            </h2>
            <div class="flex items-center gap-2 w-full sm:w-auto">
                <x-ui.button class="w-auto py-2!" @click="$dispatch('announcement-send-modal-show')">
                    <flux:icon name="megaphone"
                        class="w-4 h-4 stroke-text-btn-primary group-hover:stroke-text-btn-secondary" />
                    {{ __('Announcement') }}
                </x-ui.button>
                <x-ui.button class="w-auto py-2!" @click="$dispatch('announcement-send-modal-show')" variant="tertiary">
                    <flux:icon name="bell"
                        class="w-4 h-4 stroke-text-btn-primary group-hover:stroke-text-btn-tertiary" />
                    {{ __('Individual') }}
                </x-ui.button>
            </div>
        </div>
    </div>

    {{-- Table Component --}}
    <x-ui.table :data="$datas" :columns="$columns" :actions="$actions" :mobileVisibleColumns="2" searchProperty="search"
        perPageProperty="perPage" emptyMessage="No data found. Create your first data to get started." />
</section>
