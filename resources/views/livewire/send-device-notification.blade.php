<div class="h-[50vh] flex items-center justify-center">
    <form wire:submit.prevent="sendNotification"
        class="w-full max-w-7xl mx-auto bg-base-100 dark:bg-zinc-900 h-full flex items-center justify-center flex-col gap-5">
        <textarea type="text" class="textarea bg-base-100 dark:bg-zinc-800 border w-full max-w-xs"
            placeholder="Enter Device Token" wire:model="deviceToken" rows="5"></textarea>
        <input type="text" class="input bg-base-100 dark:bg-zinc-800 w-full max-w-xs"
            placeholder="Enter Notification Title" wire:model="title">
        <textarea class="textarea bg-base-100 dark:bg-zinc-800" placeholder="Enter Notification Body" wire:model="body"></textarea>
        <button type="submit" class="btn btn-primary">Send Notification</button>
    </form>
</div>
