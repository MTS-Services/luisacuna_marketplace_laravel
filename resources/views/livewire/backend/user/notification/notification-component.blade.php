<div class="space-y-6">
    <div class="p-5 sm:p-10 md:p-20  bg-bg-primary rounded-3xl">
        <div class="flex justify-between">
            <h2 class="text-text-white text-3xl font-semibold">{{  __('Notification')}}</h2>
            <a href="#" class="text-pink-500 text-base">{{ __('Mark all as read') }}</a>
        </div>
        @forelse ($items as $item)
            <div class="flex flex-col gap-2 sm:flex-row sm:justify-between sm:gap-5 mt-10 mb-5 p-6 bg-zinc-200/20 rounded-xl">
                <div class="flex flex-col sm:flex-row gap-5">
                    <div class="bg-zinc-200/20 flex items-center w-12 h-12 rounded-full text-center flex-shrink-0">
                        <x-phosphor name="bell" variant="regular" class="fill-zinc-200 w-full" />
                    </div>
                    <div class="">
                        <h3 class="text-text-white text-xl sm:text-base font-medium">{{ $item->title }}</h3>
                        <span class="text-text-white tetx-base sm:text-sm mt-1">{{ $item->subtitle }}</span>
                    </div>
                </div>
                <div class="">
                    <h6 class="text-xs text-pink-500">{{ $item->uploaded_at }}</h6>
                </div>
            </div>
        @empty
            <div class="mt-5">
                <h3 class="text-text-white text-xl sm:text font-semibold mb-2">{{ __('No notifications yet') }}</h3>
            <p class="text-text-gray-400 text-sm">{{ __('Well notify you when something arrives!') }}</p>
            </div>
        @endforelse
    </div>
    <x-frontend.pagination-ui :pagination="$pagination" />
</div>
