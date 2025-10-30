<div class="space-y-6">
    <!-- Filters -->
    <div class="flex flex-col sm:flex-row gap-4">
        <div class="relative" id="dropdown-wrapper">
            <x-ui.select id="status-select" class="py-0.5! w-full sm:w-70">
                <option value="">All statuses</option>
                <option value="completed">Completed</option>
                <option value="pending">Pending</option>
                <option value="processing">Processing</option>
            </x-ui.select>
            <div id="icon-container" class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none">
                <flux:icon name="chevron-down" class="w-4 h-4 text-gray-300" stroke="white" />
            </div>
        </div>

        <div class="relative">
            <x-ui.select class="py-0.5! w-full sm:w-70">
                <option value="">Recent</option>
                <option value="today">Today</option>
                <option value="week">This Week</option>
                <option value="month">This Month</option>
            </x-ui.select>
            <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none">
                <flux:icon name="chevron-down" class="w-4 h-4 text-gray-300" stroke="white" />
            </div>
        </div>
    </div>

    <div>
        <div class="overflow-x-auto shadow-2xl">
           <x-ui.user-table/>
        </div>

       
    </div>
</div>
