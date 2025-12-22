<div x-data="{
    MessageNotificationShow: @entangle('MessageNotificationShow').live
}" @user-message-notification-show.window="MessageNotificationShow = true" x-show="MessageNotificationShow"
    x-cloak @click.outside="MessageNotificationShow = false" x-transition:enter="transition ease-out duration-100"
    x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100"
    x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100"
    x-transition:leave-end="transform opacity-0 scale-95"
    
    {{-- wire:init="fetchNotifications" --}}
    class="absolute top-18 right-3 w-[90%] xs:w-3/4 md:max-w-[750px] dark:bg-bg-secondary bg-bg-primary rounded-2xl backdrop:blur-md z-10 shadow-lg overflow-hidden flex flex-col max-h-[75vh] p-10">



        <div class="shrink-0 border-b border-zinc-600 mb-5">
        <div class="flex justify-between items-center">
            <h2 class="text-lg font-semibold text-text-white">{{ __('Messages') }}</h2>
            <button @click="MessageNotificationShow = false"
                class="text-text-secondary hover:text-gray-600 transition-colors">
                <flux:icon name="x-mark" class="w-5 h-5 stroke-current hover:stroke-pink-600" />
            </button>
        </div>
        <div>
            <button wire:click="markAllAsRead" wire:loading.attr="disabled" 
            {{-- :disabled="@js($isLoading || $notifications->isEmpty())" --}}
                
                >
                <span wire:loading.remove wire:target="markAllAsRead"
                    class="text-sm text-pink-500 hover:text-text-hover">
                    {{ __('Mark all as read') }}
                </span>
                <span wire:loading wire:target="markAllAsRead" class="text-sm text-pink-500 hover:text-text-hover">
                    {{ __('Marking...') }}
                </span>
            </button>
        </div>
    </div>

    <div class="flex-1 overflow-y-auto">
        
        @foreach([1,2,3,4,5] as  $item)
        <div class="flex justify-start p-4 rounded hover:bg-bg-info">
            <div class="relative">
                <div class="border borer-white w-12 h-12 rounded-full overflow-hidden">
                    <img src="{{ storage_url('') }}" alt="" class="w-full h-full">
                </div>
                <div class="h-3 w-3 bg-[#12D212] border border-white rounded-full absolute top-8 right-0">

                </div>
            </div>
            <div class="relative w-full pl-3">
                <h2 class="text-base font-semibold text-text-primary">Ltc_spamz </h2>
                <p class="font-normal text-xs text-text-secondary mt-1">
                    Order for Items Do you sell stuff for call of duty moder
                </p>
                <div class="absolute top-0 right-0 ">
                    <p class="text-text-secondary text-xs font-normal" >
                        Sep 20
                    </p>
                </div>
            </div>
        </div>

        @endforeach
    </div>

        <div class="shrink-0 pt-4 flex items-center justify-center">
                <x-ui.button href="{{ route('user.notifications') }}" wire:navigate class="py-2! max-w-80">
                    {{ __('View all') }}
                </x-ui.button>
            </div>
    {{-- <div wire:loading.remove wire:target="fetchNotifications">
        @if (!$isLoading && $notifications->count() > 0)
            <div class="shrink-0 pt-4 flex items-center justify-center">
                <x-ui.button href="{{ route('user.notifications') }}" wire:navigate class="py-2! max-w-80">
                    {{ __('View all') }}
                </x-ui.button>
            </div>
        @endif
    </div>  --}}
</div>

@push('scripts')
    <script>
        // Listen for real-time notifications
        window.addEventListener('notification-received', () => {
            Livewire.dispatch('notification-received');
        });
    </script>
@endpush
