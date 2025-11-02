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
                    {{ __('Back') }}
                </a>
            </div>
        </div>



        <div class="chat mt-10 mb-16  p-4 md:p-20 bg-zinc-50 dark:bg-bg-base rounded-3xl">
            <div class="mb-10">
                <div class="py-7">
                    <p class="text-center text-primary-50 text-2xl md:text-4xl font-semibold mb-3"> {{ __('Start Selling') }}</p>
                    <p class="text-center text-primary-50 text-base md:text-2xl font-normal"> {{ __('Choose category') }}</p>
                </div>
            </div>
            
            <a  href="javascript:void(0)" wire:navigate class="w-full mb-10 p-3 md:p-12 flex justify-between items-center bg-bg-light rounded-2xl ">
                <div class="flex flex-row items-center">
                    <div>
                        <img src="{{ asset('assets/images/icons/coin.png')}}" alt="currency" class="w-8 h-8 md:w-16 md:h-16">
                    </div>
                    <p class="pl-3 font-semibold text-2xl md:text-3xl text-primary-50">
                        {{ __('Currency') }}
                    </p>
                </div>
                <span  class="text-primary-50 text-2xl md:text-3xl font-semibold"> > </span>
            </a>
            <a  href="javascript:void(0)" wire:navigate class="w-full mb-10 p-3 md:p-12 flex justify-between items-center bg-bg-light rounded-2xl ">
                <div class="flex flex-row items-center">
                    <div>
                        <img src="{{ asset('assets/images/icons/accounts.png')}}" alt="Acounts" class="w-8 h-8 md:w-16 md:h-16">
                    </div>
                    <p class="pl-3 font-semibold text-2xl md:text-3xl text-primary-50">
                        {{ __('Acounts') }}
                    </p>
                </div>
                <span  class="text-primary-50 text-3xl font-semibold"> > </span>
            </a>
            <a  href="javascript:void(0)" wire:navigate class="w-full mb-10 p-3 md:p-12 flex justify-between items-center bg-bg-light rounded-2xl ">
                <div class="flex flex-row items-center">
                    <div>
                        <img src="{{ asset('assets/images/icons/top-ups.png')}}" alt="Acounts" class="w-8 h-8 md:w-16 md:h-16">
                    </div>
                    <p class="pl-3 font-semibold text-2xl md:text-3xl text-primary-50">
                        {{ __('Top ups') }}
                    </p>
                </div>
                <span  class="text-primary-50 text-2xl md:text-3xl font-semibold"> > </span>
            </a>
            <a  href="javascript:void(0)" wire:navigate class="w-full mb-10 p-3 md:p-12 flex justify-between items-center bg-bg-light rounded-2xl ">
                <div class="flex flex-row items-center">
                    <div>
                        <img src="{{ asset('assets/images/icons/items.png')}}" alt="Acounts" class="w-8 h-8 md:w-16 md:h-16">
                    </div>
                    <p class="pl-3 font-semibold text-2xl md:text-3xl text-primary-50">
                        {{ __('Items') }}
                    </p>
                </div>
                <span  class="text-primary-50 text-2xl md:text-3xl font-semibold"> > </span>
            </a>
            <a  href="javascript:void(0)" wire:navigate class="w-full mb-10 p-3 md:p-12 flex justify-between items-center bg-bg-light rounded-2xl ">
                <div class="flex flex-row items-center">
                    <div>
                        <img src="{{ asset('assets/images/icons/gift-card.png')}}" alt="Acounts" class="w-8 h-8 md:w-16 md:h-16">
                    </div>
                    <p class="pl-3 font-semibold text-2xl md:text-3xl text-primary-50">
                        {{ __('Gift Cards') }}
                    </p>
                </div>
                <span  class="text-primary-50 text-2xl md:text-3xl font-semibold"> > </span>
            </a>
            <a  href="javascript:void(0)" wire:navigate class="w-full mb-10 p-3 md:p-12 flex justify-between items-center bg-bg-light rounded-2xl ">
                <div class="flex flex-row items-center">
                    <div>
                        <img src="{{ asset('assets/images/icons/gift-card.png')}}" alt="Acounts" class="w-8 h-8 md:w-16 md:h-16">
                    </div>
                    <p class="pl-3 font-semibold text-2xl md:text-3xl text-primary-50">
                        {{ __('Steam Games') }}
                    </p>
                </div>
                <span  class="text-primary-50 text-2xl md:text-3xl font-semibold"> > </span>
            </a>
            <a  href="javascript:void(0)" wire:navigate class="w-full mb-10 p-3 md:p-12 flex justify-between items-center bg-bg-light rounded-2xl ">
                <div class="flex flex-row items-center">
                    <div>
                        <img src="{{ asset('assets/images/icons/bulk-upload.png')}}" alt="Acounts" class="w-8 h-8 md:w-16 md:h-16">
                    </div>
                    <p class="pl-3 font-semibold text-2xl md:text-3xl text-primary-50">
                        {{ __('Bulk Upload') }}
                    </p>
                </div>
                <span  class="text-primary-50 text-2xl md:text-3xl font-semibold"> > </span>
            </a>

        </div>

    </div>
</section>
