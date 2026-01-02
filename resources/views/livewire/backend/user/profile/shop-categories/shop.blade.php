<div class="bg-bg-primary">
    <livewire:backend.user.profile.profile-component :user="$user" />
    <section class="container mx-auto mb-30">
        <div class="mb-6">
            <h3 class="text-4xl mb-4">{{ __('Shop') }}</h3>
            {{-- profile nav --}}

            <div class="flex gap-2 xxs:gap-3 sm:gap-6 items-start">
                @foreach ($categories as $category )
                
                     <a wire:navigate
                        href="{{ route('profile', ['username' => $user->username, 'activeTab' => $category->slug]) }}"
                        class="flex flex-col items-center">
                        <div
                            class="w-[50px] h-[50px] xxs:w-[60px] xxs:h-[60px] sm:w-[80px] sm:h-[80px] mb-2 {{ $activeTab == $category->slug ? 'bg-zinc-500' : 'bg-zinc-800' }}  rounded-full flex items-center justify-center">
                            <img src="{{ storage_url($category->icon) }}" alt="Currency Icon"
                                class="w-[20px] h-[20px] sm:w-[40px] sm:h-[40px] object-contain">
                        </div>


                        <h3 class="text-xl hidden sm:block font-medium whitespace-nowrap">{{ $category->name  }} ({{ $category->userProduct($user->id) ?? '0'}})</h3>
                    </a>
                @endforeach
               

            </div>
           
           
                <livewire:backend.user.profile.profile-category-items :user="$user" />
        </div>
    </section>
</div>
