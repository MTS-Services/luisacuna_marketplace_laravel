<div>
    @props([
        'gameSlug', 
        'categorySlug' ,
         'data', // Prdocuts as Data
          'game'
          ])



    <a  href="{{ route('game.buy', ['gameSlug' => $gameSlug, 'categorySlug' => $categorySlug, 'productId' => encrypt($data->id) ]) }}"
         >
        <!-- Card -->
        <div class="bg-bg-primary dark:bg-bg-secondary rounded-2xl p-4 shadow-lg transition">

            <div class="flex justify-between items-start">
                <div class="flex items-center space-x-2">
                    @if($game->logo)
                    <div class="bg-orange text-text-white font-bold rounded-md overflow-hidden w-6 h-6 flex items-center justify-center">
                        <img src="{{ storage_url($game->logo)}}" alt="">    
                    </div>
                    @else
                    <div class="bg-orange text-text-white font-bold rounded-md w-6 h-6 flex items-center justify-center">
                        {{ substr($game->name, 0, 1)}}</div>
                    @endif 
                     
                    <span class="text-green w-full text-base font-medium">{{ $data->platform->name }}</span>
                </div>
                <span class="text-text-secondary text-sm">• Stacked</span>
            </div>

            <div class="flex justify-between my-2">
                <p class="text-text-secondary text-sm mt-4 max-w-[60%]">
                
                   <p class="text-start w-full">
                     {{-- {{
                        $data->name ?? ''
                    }} --}}
                     {{ $data->productTranslations->first()?->name ?? $data->name }}
                   </p>
                <img class="w-16 h-16 rounded float-right" src="{{ storage_url($game->logo) }}"
                    alt="Image">
            </div>

            <div class=" flex items-center justify-between ">
                <span class="text-text-white font-medium text-lg">
                  {{ currency_symbol() }}{{ currency_exchange($data->price) }}
                </span>
                <div class="flex items-center space-x-1 text-text-secondary text-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 stroke-text-primary" viewBox="0 0 15 15"
                        fill="none">
                        <path
                            d="M7.26584 4.23838V7.26584L8.47682 5.44936M1.81641 7.26584C1.81641 7.98147 1.95736 8.69009 2.23122 9.35124C2.50508 10.0124 2.90648 10.6131 3.41251 11.1192C3.91853 11.6252 4.51927 12.0266 5.18043 12.3005C5.84159 12.5743 6.55021 12.7153 7.26584 12.7153C7.98147 12.7153 8.69009 12.5743 9.35124 12.3005C10.0124 12.0266 10.6131 11.6252 11.1192 11.1192C11.6252 10.6131 12.0266 10.0124 12.3005 9.35124C12.5743 8.69009 12.7153 7.98147 12.7153 7.26584C12.7153 6.55021 12.5743 5.84159 12.3005 5.18043C12.0266 4.51927 11.6252 3.91853 11.1192 3.41251C10.6131 2.90648 10.0124 2.50508 9.35124 2.23122C8.69009 1.95736 7.98147 1.81641 7.26584 1.81641C6.55021 1.81641 5.84159 1.95736 5.18043 2.23122C4.51927 2.50508 3.91853 2.90648 3.41251 3.41251C2.90648 3.91853 2.50508 4.51927 2.23122 5.18043C1.95736 5.84159 1.81641 6.55021 1.81641 7.26584Z"
                            stroke="currentColor" stroke-width="1.36236" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <span>
                            {{ $data->delivery_timeline ?? '' }}
                    </span>
                </div>
            </div>

            <a href="{{ route('profile', ['username' => $data->user->username]) ?? '' }}" class="border-t border-zinc-500 mt-2 pt-3 flex items-center justify-between gap-3">

                <div class="w-18 h-14 relative ">
                    <img src="{{ storage_url($data->user->avatar) }}"
                        class="w-14 h-14 rounded-full border-2 border-white" alt="profile" />
                    <span
                        class="absolute bottom-0 right-0 w-5 h-5 bg-green border-2 border-white rounded-full"></span>
                    
                </div>

                <div class="w-full ">
                    <p class="text-text-white font-semibold text-base flex items-center gap-2">
                       <span> {{ $data->user->first_name ?? $data->user->username }}</span>
                          <x-phosphor name="seal-check" variant="solid" class="fill-zinc-700 w-5 h-5" />
                    </p>

                    <div class="flex items-center space-x-2 mt-1">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 fill-zinc-500">
                            <path
                                d="M7.493 18.5c-.425 0-.82-.236-.975-.632A7.48 7.48 0 0 1 6 15.125c0-1.75.599-3.358 1.602-4.634.151-.192.373-.309.6-.397.473-.183.89-.514 1.212-.924a9.042 9.042 0 0 1 2.861-2.4c.723-.384 1.35-.956 1.653-1.715a4.498 4.498 0 0 0 .322-1.672V2.75A.75.75 0 0 1 15 2a2.25 2.25 0 0 1 2.25 2.25c0 1.152-.26 2.243-.723 3.218-.266.558.107 1.282.725 1.282h3.126c1.026 0 1.945.694 2.054 1.715.045.422.068.85.068 1.285a11.95 11.95 0 0 1-2.649 7.521c-.388.482-.987.729-1.605.729H14.23c-.483 0-.964-.078-1.423-.23l-3.114-1.04a4.501 4.501 0 0 0-1.423-.23h-.777ZM2.331 10.727a11.969 11.969 0 0 0-.831 4.398 12 12 0 0 0 .52 3.507C2.28 19.482 3.105 20 3.994 20H4.9c.445 0 .72-.498.523-.898a8.963 8.963 0 0 1-.924-3.977c0-1.708.476-3.305 1.302-4.666.245-.403-.028-.959-.5-.959H4.25c-.832 0-1.612.453-1.918 1.227Z" />
                        </svg>
                        <p class="text-text-secondary text-xs">99.3% <span class="ml-1">(234)</span></p>
                    </div>
                </div>
            </a>
        </div>
    </a>
</div>
