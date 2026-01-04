<div class="h-[50vh] flex items-center justify-center">
    <form wire:submit.prevent="sendNotification" class="w-full max-w-7xl mx-auto bg-base-100 h-full flex items-center justify-center flex-col gap-5">
        <input type="text" class="input input-bordered w-full max-w-xs" placeholder="Enter Device Token"
            wire:model="deviceToken">
        <input type="text" class="input input-bordered w-full max-w-xs" placeholder="Enter Notification Title"
            wire:model="title">
        <textarea class="textarea textarea-bordered w-full max-w-xs" placeholder="Enter Notification Body" wire:model="body"></textarea>
        <button type="submit" class="btn btn-primary">Send Notification</button>
    </form>
</div>
