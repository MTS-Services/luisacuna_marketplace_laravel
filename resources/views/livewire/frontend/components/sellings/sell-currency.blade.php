<section>
    <div class="container">
        <div class="breadcrumb">
            <div class="back py-10 flex flex-wrap items-center">

                <a href="javascript:void(0)" wire:navigate class="text-primary-50 text-xl py-2">

                    {{ __('Home') }}
                </a>
                <span class="text-primary-50 text-xl px-2 py-2">
                    <flux:icon icon="arrow-right" class="inline-block pr-2" />
                </span>
                <a href="javascript:void(0)" wire:navigate class="text-primary-50 text-xl py-2">
                    {{ __('Select Game') }}
                </a>

                <span class="text-primary-50 text-xl px-2 py-2">
                    <flux:icon icon="arrow-right" class="inline-block pr-2" />
                </span>
                <a href="javascript:void(0)" wire:navigate class="text-primary-50 text-xl py-2 ">
                    {{ __('Item delivery and details') }}
                </a>
            </div>
        </div>


        <div class="title mt-10">
            <div class="mb-10">
                <div class="">
                    <p class="text-center text-primary-50 text-2xl md:text-4xl font-semibold mb-3">
                        {{ __('Select Game Currency') }}</p>

                    <div class="game-logo flex items-center justify-center flex-row  mt-3 md:mt-5">
                        <img src="{{ asset('assets/images/icons/game_ball.png') }}" alt=""
                            class="w-8 h-8 md:w-10 md:h-10 mr-3">
                        <p class="text-base text-primary-50 md:text-2xl ">
                            {{ __('8 Ball Poll') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-10  p-4 md:p-20 bg-zinc-50 dark:bg-bg-base rounded-3xl">

            <div class=" ">
                <div class="mb-3 mb:mb-10">
                    <p class="text-xl md:text-4xl "> {{ __('Your Item') }} </p>
                </div>
                <div class="w-full bg-bg-light rounded-2xl p-3 md:p-13 flex flex-row items-center mt-3 md:mt-10">
                    <img src="{{ asset('assets/images/icons/game_thumbnail.png') }}" alt=""
                        class="w-10 h-10 md:w-30 md:h-30">
                    <p class="text-base md:text-2xl font-semibold ml-4">{{ __('8 Ball Poll') }}</p>
                </div>
            </div>

        </div>
        <div class="mt-10 md:mt-13 mb-16  p-4 md:p-20 bg-zinc-50 dark:bg-bg-base rounded-3xl">


            <div class="">
                <div class="mb-3 mb:mb-10">
                    <p class="text-xl md:text-4xl border-b border-zinc-500 pb-4  "> {{ __('Decription (Optional)') }}
                    </p>
                    <p class="text-xs font-normal mt-3 text-end"> {{ __('Step 1/3 ') }}</p>
                </div>
                <div class="w-full">
                    <p class="text-xs font-normal my-4 text-end"> {{ __('0/3 ') }}</p>

                    <div class="w-full">
                        <textarea name="" id="" cols="" rows="10" placeholder="Type here..."
                            class="w-full rounded-3xl bg-bg-light  p-3"></textarea>
                    </div>
                    <p class="mt-5 text-base md:text-2xl font-normal">
                        The listing title and description must be accurate and as informative as possible (no random or
                        lottery). Misleading description is a violation of our <span class="text-btn-danger"> Seller
                            Rules</span>.
                    </p>
                </div>
            </div>

        </div>

        <div class="mt-10 md:mt-13 mb-16  p-4 md:p-20 bg-zinc-50 dark:bg-bg-base rounded-3xl">


            <div class="">
                <div class="mb-3 mb:mb-10">
                    <p class="text-xl md:text-4xl border-b border-zinc-500 pb-4  "> {{ __('Delivery') }}
                    </p>

                </div>
                <div class="w-full">
                    <div class="mb-3 md:mt-10">
                        <p class="text-base md:text-2xl "> {{ __('Guaranteed Delivery Time:') }} </p>
                    </div>
                    <div class="w-full mt-4">
                        <x-ui.select id="status-select"
                            class="py-0.5! w-full!  rounded-xl! dark:bg-black! border-bg-base! ">
                            <option value="">Choose</option>
                            <option value="completed">20 M</option>
                            <option value="pending">1 H</option>
                        </x-ui.select>
                    </div>
                    <div>
                        <p class="text-xs md:text-xl text-primary-50 mt-4">
                            {{ __('Faster delivery time improves your offer\'s ranking in the offer list.') }}</p>
                    </div>
                </div>
            </div>

        </div>

        <div class="mt-10 md:mt-13 mb-16  p-4 md:p-20 bg-zinc-50 dark:bg-bg-base rounded-3xl">


            <div class="">
                <div class="mb-3 mb:mb-10">
                    <p class="text-xl md:text-4xl border-b border-zinc-500 pb-4  "> {{ __('Delivery Method') }}
                    </p>

                </div>
                <div class="w-full">
                    <div class="mb-3 md:mt-10">
                        <p class="text-base md:text-2xl "> {{ __('Choose Delivery Method') }} </p>
                    </div>
                    <div class="w-full mt-4">
                        <ul>
                            <li class="mb-3">
                                <input type="radio" id="radio1" class="text-btn-danger mr-2">
                                <label for="radio1" class="text-base text-primary-50"> {{ __('Aucation House') }}
                                </label>
                            </li>
                            <li class="mb-3">
                                <input type="radio" id="radio1" class="text-btn-danger mr-2">
                                <label for="radio1" class="text-base text-primary-50"> {{ __('Aucation House') }}
                                </label>
                            </li>
                            <li class="mb-3">
                                <input type="radio" id="radio1" class="text-btn-danger mr-2">
                                <label for="radio1" class="text-base text-primary-50"> {{ __('Aucation House') }}
                                </label>
                            </li>
                            <li class="mb-3">
                                <input type="radio" id="radio1" class="text-btn-danger mr-2">
                                <label for="radio1" class="text-base text-primary-50"> {{ __('Aucation House') }}
                                </label>
                            </li>
                            <li class="mb-3">
                                <input type="radio" id="radio1" class="text-btn-danger mr-2">
                                <label for="radio1" class="text-base text-primary-50"> {{ __('Aucation House') }}
                                </label>
                            </li>
                            <li class="">
                                <input type="radio" id="radio1" class="text-btn-danger mr-2">
                                <label for="radio1" class="text-base text-primary-50"> {{ __('Aucation House') }}
                                </label>
                            </li>
                        </ul>
                    </div>

                </div>
            </div>

        </div>



        <div class="mt-10 md:mt-13 mb-16  p-4 md:p-20 bg-zinc-50 dark:bg-bg-base rounded-3xl">


            <div class="">
                <div class="mb-3 mb:mb-10">
                    <p class="text-xl md:text-4xl border-b border-zinc-500 pb-4  "> {{ __('Quantity') }}
                    </p>

                </div>
                <div class="w-full">
                    
                    <div class="mt-4 md:mt-10 flex flex-col md:flex-row md:gap-6 ">
                        <div class="w-full md:w-1/2">
                            <p for="" class="font-semibold text-base md:text-2xl mb-3"> {{ __('Total Quantity Available: ')}} </p>
                            <input type="text" class="text-center bg-bg-light rounded-xl py-6 px-4 w-full" placeholder="18">
                        </div>
                        <div class="w-full md:w-1/2">
                            <p for="" class="font-semibold text-base md:text-2xl mb-3"> {{ __('Minimum Offer Quantity:  ')}} </p>
                            <input type="text" class="text-center bg-bg-light rounded-xl py-6 px-4 w-full" placeholder="18K">
                        </div>

                    </div>

                </div>
            </div>
            
            <div class="mt-10 md:mt-13">
                <div class="mb-3 mb:mb-10">
                    <p class="text-xl md:text-4xl border-b border-zinc-500 pb-4  "> {{ __('Price') }}
                    </p>

                </div>
                <div class="w-full">
                    
                    <div class="mt-4 md:mt-10 ">
                        <div class="w-full ">
                            <p for="" class="font-semibold text-base md:text-2xl mb-3"> {{ __('Total Quantity Available: ')}} </p>
                            <input type="text" class="text-center bg-bg-light rounded-xl py-6 px-4 w-full" placeholder="18">
                        </div>

                    </div>

                </div>

                <div>
                    <p class="text-base md:text-xl text-primary-50 mt-5">Competitive prices improve your offer's ranking in the offer list.</p>
                </div>
            </div>

        </div>


        <div class="mt-10 md:mt-13 mb-16  p-4 md:p-20 bg-zinc-50 dark:bg-bg-base rounded-3xl">


            <div class="">
                <div class="mb-3 mb:mb-10">
                    <p class="text-xl md:text-4xl border-b border-zinc-500 pb-4  "> {{ __('Volume Discount') }}
                    </p>

                </div>
                <div class="w-full">
                    
                    <div class="mt-4 md:mt-10 flex flex-col md:flex-row md:gap-6 ">
                        <div class="w-full md:w-2/5">
                            <p for="" class="font-semibold text-base md:text-2xl mb-3"> {{ __('Minimum Quantity for discount: ')}} </p>
                            <input type="text" class="text-center bg-bg-light rounded-xl py-6 px-4 w-full" placeholder="18">
                        </div>
                        <div class="w-full md:w-3/5 flex flex-row items-center justify-center ">
                            <div class="w-4/5">
                                <p  class="font-semibold text-base md:text-2xl mb-3"> {{ __('Discount Percentage  ')}} </p>
                                 <input type="text" class="text-center bg-bg-light rounded-xl py-6 px-4 w-full" placeholder="18K" />
                            </div>

                           <div class="mt-9">
                             <x-ui.button class="w-auto! ml-3 rounded-xl! px-4 py-4 bg-btn-danger!" :variant="'tertiary'"> {{ __('Trash') }} </x-ui.button>
                           </div>
                        </div>

                    </div>

                    <div class="button mt-4 md:mt-10">
                        <x-ui.button class="w-auto!" :variant="'primary'"> 
                            <flux:icon name="plus" class="w-5 h-5" />
                            {{ __('Add New') }} </x-ui.button>
                    </div>

                </div>
            </div>

        </div>



        <div class="mt-10 md:mt-13 mb-16  p-4 md:p-20 bg-zinc-50 dark:bg-bg-base rounded-3xl">


            <div class="">
                <div class="mb-3 mb:mb-10">
                    <p class="text-xl md:text-4xl border-b border-zinc-500 pb-4  "> {{ __('Free Stuctures') }}
                    </p>

                </div>
                <div class="w-full mt-4 md:mt-10">
                    <div class="w-full mt-4">
                        <p class="text-xs md:text-xl text-primary-50 mb-3 md:mb-4 ">Flat fee (Per Purchase): <span
                                class="text-primary-50 font-semibold text-2xl ml-3">$0.00 USD</span></p>
                        <p class="text-xs md:text-xl text-primary-50 mb-3 md:mb-4 ">Percantage fee (Per Purchase):
                            <span class="text-primary-50 font-semibold text-2xl ml-3">$0.00 USD</span></p>
                    </div>
                </div>
            </div>

        </div>

        <div class="w-full mt-4">
            <ul>
                
                <li class="mb-3">
                    <input type="checkbox" id="checkbox2" class="text-btn-danger mr-2">
                    <label for="checkbox2" class="text-xs md:text-base text-primary-50 font-normal"> {{ __('I have read and agree to the ') }}  <span class="text-btn-danger"> {{ __('Terms of Service.')}}</span></label>
                </li>
                <li class="mb-3">
                    <input type="checkbox" id="checkbox1" class="text-btn-danger mr-2">
                    <label for="checkbox1" class="text-xs md:text-base text-primary-50"> {{ __('I have read and agree to the ') }} <span class="text-btn-danger"> {{ __('Seller Rules.')}}</span></label>
                </li>
            </ul>
        </div>

        <div class="button mb-13 mt-8 md:mb-30 md:mt-10 ">
            <x-ui.button class="w-auto!" :variant="'primary'"> {{ __('Place Offer') }} </x-ui.button>
        </div>


    </div>
</section>
