<div class="max-w-3xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
    <div class="mb-6">
        <h1 class="text-2xl font-semibold text-text-primary">
            {{ __('Open a Dispute') }}
        </h1>
        <p class="mt-2 text-sm text-text-muted">
            {{ __('Describe the issue with your order and attach any evidence to help our team review your case.') }}
        </p>
    </div>

    <form wire:submit.prevent="submit" class="space-y-6">
        <div class="bg-bg-secondary border border-zinc-800/40 rounded-xl p-5 space-y-4">
            <div class="grid grid-cols-1 gap-4">
                <flux:field>
                    <flux:label for="reason_category">{{ __('Reason') }}</flux:label>
                    <flux:select id="reason_category" wire:model="form.reason_category">
                        <option value="">{{ __('Select a reason') }}</option>
                        <option value="item_not_received">{{ __('Item not received') }}</option>
                        <option value="not_as_described">{{ __('Item not as described') }}</option>
                        <option value="payment_issue">{{ __('Payment issue') }}</option>
                        <option value="other">{{ __('Other') }}</option>
                    </flux:select>
                    <flux:error name="form.reason_category" />
                </flux:field>

                <flux:field>
                    <flux:label for="description">{{ __('Description') }}</flux:label>
                    <flux:textarea
                        id="description"
                        rows="5"
                        wire:model="form.description"
                        placeholder="{{ __('Provide as many details as possible about the issue...') }}"
                    />
                    <flux:error name="form.description" />
                </flux:field>
            </div>
        </div>

        <div
            x-data="{
                isDropping: false,
                handleDrop(e) {
                    this.isDropping = false;
                    const files = e.dataTransfer.files;
                    if (!files || !files.length) return;
                    this.$refs.fileInput.files = files;
                    this.$refs.fileInput.dispatchEvent(new Event('change'));
                }
            }"
            class="bg-bg-secondary border border-dashed border-zinc-700/60 rounded-xl p-5 space-y-4"
        >
            <flux:field>
                <flux:label>{{ __('Evidence (optional)') }}</flux:label>

                <input
                    x-ref="fileInput"
                    type="file"
                    multiple
                    class="hidden"
                    wire:model="evidence"
                />

                <div
                    x-on:dragover.prevent="isDropping = true"
                    x-on:dragleave.prevent="isDropping = false"
                    x-on:drop.prevent="handleDrop($event)"
                    x-on:click="$refs.fileInput.click()"
                    class="flex flex-col items-center justify-center gap-2 rounded-lg border border-zinc-700/60 cursor-pointer px-6 py-8 text-center transition
                           bg-bg-primary/60 hover:bg-bg-primary/80"
                    :class="isDropping ? 'border-primary-500 bg-primary-500/10' : ''"
                >
                    <p class="text-sm font-medium text-text-primary">
                        {{ __('Drag & drop files here, or click to browse') }}
                    </p>
                    <p class="text-xs text-text-muted">
                        {{ __('Images, videos, or documents up to 10MB each (max 5 files).') }}
                    </p>
                </div>

                <div class="mt-3 space-y-2">
                    @error('evidence') <p class="text-xs text-red-500">{{ $message }}</p> @enderror
                    @error('evidence.*') <p class="text-xs text-red-500">{{ $message }}</p> @enderror

                    @if($evidence)
                        <ul class="space-y-1 text-sm text-text-secondary">
                            @foreach($evidence as $file)
                                <li class="flex items-center justify-between rounded-md bg-bg-primary px-3 py-1.5">
                                    <span class="truncate">
                                        {{ $file->getClientOriginalName() }}
                                    </span>
                                    <span class="ml-2 text-xs text-text-muted">
                                        {{ number_format($file->getSize() / 1024 / 1024, 2) }} MB
                                    </span>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </flux:field>
        </div>

        <div class="flex items-center justify-end gap-3">
            <flux:button
                type="button"
                variant="ghost"
                color="zinc"
                href="{{ route('user.order.detail', $order->order_id) }}"
            >
                {{ __('Cancel') }}
            </flux:button>

            <flux:button
                type="submit"
                variant="primary"
                wire:target="submit"
                wire:loading.attr="disabled"
            >
                <span wire:loading.remove wire:target="submit">
                    {{ __('Submit Dispute') }}
                </span>
                <span wire:loading wire:target="submit">
                    {{ __('Submitting...') }}
                </span>
            </flux:button>
        </div>
    </form>
</div>

