<div class="min-h-[70vh] bg-bg-primary py-12 px-4">
    <div class="max-w-4xl mx-auto">

        @if (session('success'))
            <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                {{ session('error') }}
            </div>
        @endif

           <div class="text-center w-full rounded-2xl bg-bg-secondary px-5 py-8 lg:p-20">
                <div class="mb-6">
                    <div class="mx-auto flex flex-row items-center justify-center">
                        <span class="text-8xl pr-2.5">
                            <flux:icon name="shield-check" class="stroke-zinc-500"></flux:icon>
                        </span>
                        <p class="font-semibold text-base ">Seller ID verification</p>
                    </div>
                    <div class="text-sm text-text-primary font-normal pt-2">
                        Step <span>2</span>/<span>7</span>
                    </div>
                </div>

                <div class="p-5 lg:px-15 lg:py-10 bg-bg-optional  rounded-2xl">

                    <div class="p-5 bg-bg-info shadow rounded-2xl">
                        <h2 class="font-semibold text-text-primary text-base  lg:text-2xl pb-5 text-left">Selling
                            experience:</h2>

                        <div class="flex items-center gap-2 mb-3">
                            <input type="radio" wire:model="sellingExperience" value="new" id="new"
                                class="accent-pink-500">
                            <label for="new">New Seller (This is my first selling)</label>
                        </div>

                        <div class="flex items-center gap-2">
                            <input type="radio" wire:model="sellingExperience" value="experienced" id="company"
                                class="accent-pink-500">
                            <label for="company">Experieced Seller (I have worked on others platform)</label>
                        </div>
                    </div>
                </div>

               <div class="flex justify-center space-x-4 pt-10">
                <a href="{{route('user.seller.verification',['step' => 2])}}" class="px-8 py-2  hover:bg-zinc-50 rounded-lg">
                    BACK
                </a>
                <a href="{{route('user.seller.verification',['step' => 4])}}" wire:navigate class="px-8 py-2 text-white rounded-lg transition" 
                    :class="{
                        'bg-zinc-600 hover:bg-zinc-700': $wire.selectedCategories.length > 0,
                        'bg-zinc-200 text-zinc-950 cursor-pointer!': $wire.selectedCategories.length === 0
                    }">
                    NEXT
                </a>
            </div>

            </div>

    </div>
</div>
