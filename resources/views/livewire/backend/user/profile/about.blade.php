<div class="bg-bg-primary pb-10">
  <livewire:backend.user.profile.profile-component :user="$user" />
    <section class="container mx-auto bg-bg-secondary rounded-2xl mb-10 p-5 sm:p-10 md:p-20">
        <div class="mb-5">
            <h2 class="font-semibold text-3xl">{{ __('About') }}</h2>
        </div>
        <div class="flex flex-col gap-5">
            <div class="p-6 bg-bg-info rounded-2xl">
                <div class="flex items-center justify-between">
                    <div class="">
                        <h3 class="text-2xl font-semibold text-text-white">{{ __('Description') }}</h3>
                    </div>

                    @if(isLoggedIn())

                        @if(auth()->user()->id == $user->id)
                            <div class="" >
                                @if(!$editMode)
                                <button type="button" class="" wire:click="switchToEditMode">
                                    <flux:icon name="pencil-square" class="w-5 h-5 inline-block" stroke="white" />
                                </button>
                                @else 
                                {{-- <x-flux::icon name="pencil-cross" class="w-5 h-5 inline-block" stroke="white" /> --}}
                                <button type="button" class="" wire:click="switchToEditMode">
                                    <flux:icon name="x-mark" class="w-5 h-5 inline-block" stroke="white" />
                                </button>

                                <button type="button" class="" wire:click="save">
                                   <flux:icon name="check" class="w-5 h-5 inline-block" stroke="white" />
                                </button>
                             
                              
                                @endif
                            </div>
                        @endif
                    @endif
                   
                   
                </div>
                <div class="mt-2">
                   @if(!$editMode)
                    <div class="">
                        <p class="text-base text-text-white">
                            {{ $user->translatedDescription(app()->getLocale()) ?? 'N/A' }}
                        </p>
                    </div>
                    @else 

                    <div class="">
                       <x-ui.textarea wire:model="description" class="w-full" placeholder="{{ __('Description') }}" >
                            {{ $user->description}}
                       </x-ui.textarea>
                       
                    </div>

                    @endif
                </div>
            </div>
            <div class="p-6 bg-bg-info rounded-2xl">
                <div class="">
                    <p class="text-base text-text-white">
                        {{ __('Registered:') }} {{ $user->created_at_formatted ?? 'N/A' }}
                    </p>
                </div>
            </div>
        </div>
    </section>

</div>
