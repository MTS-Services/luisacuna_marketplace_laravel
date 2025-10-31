<div class="space-y-6">
    <div class=" p-4 w-full">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">

            <div class="flex flex-col sm:flex-row gap-4 w-full md:w-auto">

                <div class="relative w-full sm:w-56">
                    <x-ui.select>
                        <option value="">All statuses</option>
                        <option value="completed">Completed</option>
                        <option value="pending">Pending</option>
                        <option value="processing">Processing</option>
                    </x-ui.select>
                </div>

                <div class="relative w-full sm:w-56">
                    <x-ui.select>
                        <option value="">All Game</option>
                        <option value="game1">Game 1</option>
                        <option value="game2">Game 2</option>
                        <option value="game3">Game 3</option>
                    </x-ui.select>
                </div>

                <div class="relative w-full sm:w-56">
                    <x-ui.input type="text" placeholder="Search" class="pl-5" />
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                        <x-phosphor-magnifying-glass class="w-5 h-5 fill-text-text-white" />
                    </div>
                </div>

            </div>

            <div class="w-full md:w-auto">
                <x-ui.button class="w-auto py!">
                    <x-phosphor-download class="w-5 h-5 fill-text-text-white" />
                    <span>Download invoice</span>
                </x-ui.button>
            </div>

        </div>
    </div>
    <div>
        <x-ui.user-table :data="$items" :columns="$columns"
            emptyMessage="No data found. Add your first data to get started." class="rounded-lg overflow-hidden" />

        <x-frontend.pagination-ui :pagination="$pagination" />
    </div>
</div>
