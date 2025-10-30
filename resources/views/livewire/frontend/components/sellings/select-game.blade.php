<section>
    <div class="container">
        <div class="breadcrumb">
            <div class="back py-10 flex flex-nowrap items-center">

                <a href="javascript:void(0)" wire:navigate class="text-primary-50 text-xl ">
                   
                    {{ __('Home') }}
                </a>
                <span class="text-primary-50 text-xl px-2">
                   <flux:icon icon="arrow-left" class="inline-block pr-2" />
                </span>
                <a href="javascript:void(0)" wire:navigate class="text-primary-50 text-xl ">
                    {{ __('Select Game') }}
                </a>
            </div>
        </div>



        <div class="chat mt-10 mb-16  p-4 md:p-20 bg-zinc-50 dark:bg-bg-base rounded-3xl">
            <div class="mb-10">
                <div class="">
                    <p class="text-center text-primary-50 text-2xl md:text-4xl font-semibold mb-3"> {{ __('Select Game Currency') }}</p>
                    <p class="text-center text-primary-50 text-base md:text-2xl font-normal"> {{ __('Step 1/3') }}</p>
                </div>
            </div>
            <div class="mb-10 flex items-center justify-center flex-col bg-bg-light p-3 md:p-12 rounded-2xl">
                <div class="mb-3 mb:mb-7">
                    <p class="text-base md:text-2xl "> {{ __('Choose Game') }} </p>
                </div>  
                <div class="w-2/3">
                    <x-ui.select id="status-select" class="py-0.5! w-full! sm:w-70 rounded-xl! bg-bg-base! border-bg-base! ">
                        <option value="">All Game</option>
                        <option value="completed">Completed</option>
                        <option value="pending">Pending</option>
                        <option value="processing">Processing</option>
                    </x-ui.select>
                </div>  
            </div>
            <div class="mb-5 md:mb-10">
                <div class="flex gap-6 justify-center mb-5">
                    <x-ui.button  class="w-auto! bg-primary-50!" >{{ __('Back') }}</x-ui.button>
                    <x-ui.button  class="w-auto! " >{{ __('Next') }}</x-ui.button>
                </div>

                <div>
                    <p class="text-primary-50 text-base text-center mt-">Can't find the game you want to sell? Contact our <a href="#" class="text-btn-danger">customer support</a> to suggest a game.</p>
                </div>
            </div>
            
        </div>

    </div>
</section>
