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
            <button wire:click="markAllAsRead" wire:loading.attr="disabled" :disabled="@js($isLoading || $conversations->isEmpty())">
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
        

                      @forelse($conversations  as  $conversation)
                             @php
                                $otherParticipant = $conversation->participants->first()?->participant;
                                $lastMessage = $conversation->messages->first();
                            @endphp
        <a class="flex justify-start p-4 rounded hover:bg-bg-info" href="{{ route('user.messages', ['conversation' => $conversation->conversation_uuid]) }}">
            <div class="relative">
               
                <div class="border borer-white w-12 h-12 rounded-full overflow-hidden">
                    <img src="{{ storage_url($otherParticipant->avatar) }}" alt="{{ $otherParticipant->full_name }}" class="w-full h-full">
                </div>
                <div class="h-3 w-3 bg-[#12D212] border border-white rounded-full absolute top-8 right-0">

                </div>
            </div>
            <div class="relative w-full pl-3">
                <h2 class="text-base font-semibold text-text-primary">{{ $otherParticipant->full_name }} </h2>
                <p class="font-normal text-xs text-text-secondary mt-1">
                    {{ $lastMessage->message_body }}
                </p>
                <div class="absolute top-0 right-0 ">
                    <p class="text-text-secondary text-xs font-normal" >
                        {{ $lastMessage->created_at->diffForHumans() }}
                    </p>
                </div>
            </div>
        </a>

        @empty
            <div class="flex flex-col items-center justify-center py-16 text-center">
                <div
                    class="w-16 h-16 bg-zinc-200 dark:bg-zinc-300/10 rounded-full flex items-center justify-center mb-4">
                    <flux:icon name="bell-slash" class="w-8 h-8 stroke-zinc-500" />
                </div>
                <h4 class="text-base font-semibold text-text-white mb-1">
                    {{ __('No Messages') }}
                </h4>
                <p class="text-sm text-text-secondary">
                    {{ __("You're all caught up!") }}
                </p>
            </div>
        @endforelse
    </div>

    @if($conversations->count() > 4)
        <div class="shrink-0 pt-4 flex items-center justify-center">
                <x-ui.button href="{{ route('user.messages') }}" wire:navigate class="py-2! max-w-80">
                    {{ __('View all') }}
                </x-ui.button>
        </div>
    @endif
   
</div>

@push('scripts')
    <script>
        // Listen for real-time notifications
        window.addEventListener('message-received', () => {
            Livewire.dispatch('message-received');
        });
    </script>
@endpush
