<div>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">
        <!-- Completed Orders Card -->
        <div class="bg-bg-primary/70 p-6 rounded-2xl  hover:border-zinc-700 transition-all duration-300">
            <div class="flex flex-col space-y-4">
                <div class="bg-bg-hover w-15 h-15 rounded-xl flex items-center justify-center">
                    <x-phosphor name="arrows-down-up" class="w-6 h-6 text-zinc-400 rotate-90" />
                </div>
                <div>
                    <p class="text-text-secondary text-sm mb-1">Completed orders</p>
                    <p class="text-white text-3xl font-bold">{{ $completedOrders ?? 1300 }}</p>
                </div>
            </div>
        </div>

        <!-- Positive Feedback Card -->
        <div class="bg-bg-primary/70 p-6 rounded-2xl  hover:border-zinc-700 transition-all duration-300">
            <div class="flex flex-col space-y-4">
                <div class="bg-bg-hover w-15 h-15 rounded-xl flex items-center justify-center">
                    <x-phosphor-thumbs-up-fill class="w-6 h-6 fill-zinc-500" />
                </div>
                <div>
                    <p class="text-text-secondary text-sm mb-1">Positive feedback</p>
                    <p class="text-white text-3xl font-bold">{{ $positiveFeedback ?? 1290 }}</p>
                </div>
            </div>
        </div>

        <!-- Negative Feedback Card -->
        <div class="bg-bg-primary/70 p-6 rounded-2xl  hover:border-zinc-700 transition-all duration-300">
            <div class="flex flex-col space-y-4">
                <div class="bg-bg-hover w-15 h-15 rounded-xl flex items-center justify-center">
                    <x-phosphor-thumbs-up-fill class="w-6 h-6 fill-red-500 rotate-180" />
                </div>
                <div>
                    <p class="text-text-secondary text-sm mb-1">Negative feedback</p>
                    <p class="text-white text-3xl font-bold">{{ $negativeFeedback ?? 10 }}</p>
                </div>
            </div>
        </div>

        <!-- Feedback Score Card -->
        <div class="bg-bg-primary/70 p-6 rounded-2xl  hover:border-zinc-700 transition-all duration-300">
            <div class="flex flex-col space-y-4">
                <div class="bg-bg-hover w-15 h-15 rounded-xl flex items-center justify-center">
                    <x-phosphor-star-fill class="w-6 h-6 fill-yellow-400" />
                </div>
                <div>
                    <p class="text-text-secondary text-sm mb-1">Feedback score</p>
                    <p class="text-white text-3xl font-bold">{{ $feedbackScore ?? '99.23%' }}</p>
                </div>
            </div>
        </div>
    </div>
</div>