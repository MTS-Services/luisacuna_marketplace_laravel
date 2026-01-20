<div>
    {{-- Page Header --}}
    <div class="glass-card rounded-2xl lg:p-6 mb-6">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <h2 class="text-xl lg:text-2xl font-bold text-text-primary">
                {{ __('User Method Details') }}
            </h2>
            <div class="flex items-center gap-2">
                <x-ui.button href="{{ route('admin.wm.user-method.index') }}" class="w-auto! py-2!">
                    <flux:icon name="arrow-left"
                        class="w-4 h-4 stroke-text-btn-primary group-hover:stroke-text-btn-secondary" />
                    {{ __('Back') }}
                </x-ui.button>
            </div>
        </div>
    </div>
    <div class="rounded-xl p-6 min-h-[500px]">
        {{-- Right Column --}}
        <div class="w-full col-span-1 lg:col-span-2 ">
            <div class="bg-bg-primary rounded-2xl shadow-lg overflow-hidden border border-gray-500/20 p-5">
                <!-- Old Data Section -->
                <div class="space-y-10">
                    <!-- Info Cards -->
                    <div class="grid grid-cols-1 sm:grid-cols-4 gap-6 w-full">
                        <div class="bg-slate-50 dark:bg-gray-700 rounded-2xl p-6 border border-slate-200 shadow-md ">
                            <p class="text-text-white text-xs font-semibold mb-2">{{ __('NAME') }}</p>
                            <p class="text-slate-400 text-lg font-bold ">{{ $data?->user?->full_name }}</p>
                        </div>
                        <div class="bg-slate-50 dark:bg-gray-700 rounded-2xl p-6 border border-slate-200 shadow-md ">
                            <p class="text-text-white text-xs font-semibold mb-2">{{ __('ACCOUNT NAME') }}</p>
                            <p class="text-slate-400 text-lg font-bold">{{ $data?->account_name }}</p>
                        </div>

                        <div class="bg-slate-50 dark:bg-gray-700 rounded-2xl p-6 border border-slate-200 shadow-md ">
                            <p class="text-text-white text-xs font-semibold mb-2">{{ __('WITHDRAWAL METHOD') }}</p>
                            <p class="text-slate-400 text-lg font-bold">{{ $data?->withdrawalMethod?->name }}</p>
                        </div>
                        <div class="bg-slate-50 dark:bg-gray-700 rounded-lg p-4 border border-slate-200">
                            <p class="text-text-white text-xs font-semibold mb-2">{{ __('STATUS') }}</p>
                            <p class="text-slate-400 text-lg font-bold">{{ $data->status }}</p>
                        </div>
                        <div class="bg-slate-50 dark:bg-gray-700 rounded-2xl p-6 border border-slate-200 shadow-md ">
                            <p class="text-text-white text-xs font-semibold mb-2">{{ __('IS DEFAULT') }}</p>
                            <p class="text-slate-400 text-lg font-bold">{{ $data->is_default ? 'Yes' : 'No' }}</p>
                        </div>

                        {{-- Default Operation Information  --}}
                        <div class="bg-slate-50 dark:bg-gray-700 rounded-2xl p-6 border border-slate-200 shadow-md">
                            <p class="text-text-white text-xs font-semibold mb-2">{{ __('LAST USED AT') }}
                            </p>
                            <p class="text-slate-400 text-lg font-bold">{{ $data->last_used_at ?? 'N/A' }}
                            </p>
                        </div>
                        <div class="bg-slate-50 dark:bg-gray-700 rounded-2xl p-6 border border-slate-200 shadow-md">
                            <p class="text-text-white text-xs font-semibold mb-2">{{ __('CREATED BY') }}
                            </p>
                            <p class="text-slate-400 text-lg font-bold">{{ $data->creater?->name ?? 'N/A' }}
                            </p>
                        </div>
                        <div class="bg-slate-50 dark:bg-gray-700 rounded-2xl p-6 border border-slate-200 shadow-md">
                            <p class="text-text-white text-xs font-semibold mb-2">{{ __('AUDIT BY') }}
                            </p>
                            <p class="text-slate-400 text-lg font-bold">{{ $data->auditedBy?->name ?? 'N/A' }}
                            </p>
                        </div>
                        {{-- Default Operation Information  --}}
                        <div class="bg-slate-50 dark:bg-gray-700 rounded-2xl p-6 border border-slate-200 shadow-md">
                            <p class="text-text-white text-xs font-semibold mb-2">{{ __('CREATED AT') }}
                            </p>
                            <p class="text-slate-400 text-lg font-bold">{{ $data->created_at_formatted ?? 'N/A' }}
                            </p>
                        </div>
                        <div class="bg-slate-50 dark:bg-gray-700 rounded-2xl p-6 border border-slate-200 shadow-md">
                            <p class="text-text-white text-xs font-semibold mb-2">{{ __('AUDIT AT') }}
                            </p>
                            <p class="text-slate-400 text-lg font-bold">
                                {{ $data->audit_at?->format('d M Y h:i A') ?? 'N/A' }}
                            </p>
                        </div>
                    </div>
                    <div class="bg-slate-50 dark:bg-gray-700 rounded-lg p-4 mt-8 border border-slate-200">
                        <p class="text-text-white text-xs font-semibold mb-2">{{ __('Note') }}</p>
                        <p class="text-pink-500 text-lg font-bold">{{ $data->note ?? 'N/A' }} </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="w-full col-span-1 lg:col-span-2 mt-5">
            <div class="bg-bg-primary rounded-2xl shadow-lg overflow-hidden border border-gray-500/20 p-5">
                <h2 class="text-base font-bold mb-4">{{ __('Account Info') }}</h2>
                <!-- Old Data Section -->
                <div class="space-y-10">
                    <!-- Info Cards -->
                    <div class="grid grid-cols-1 sm:grid-cols-4 gap-6 w-full">
                        @php
                            $accountData = is_array($data->account_data)
                                ? $data->account_data
                                : json_decode($data->account_data, true) ?? [];
                        @endphp
                        @foreach ($accountData as $key => $value)
                            <div
                                class="bg-slate-50 dark:bg-gray-700 rounded-2xl p-6 border border-slate-200 shadow-md ">
                                <p class="text-text-white text-xs font-semibold mb-2">
                                    {{ strtoupper(str_replace('_', ' ', $key)) }}</p>
                                <p class="text-slate-400 text-lg font-bold ">{{ $value }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="flex justify-end items-end gap-2 mt-5">
                    @if ($data->status->value == \App\Enums\UserWithdrawalAccount::PENDING->value)
                        <div>
                            <x-ui.button wire:click.prevent="makeVerified('{{ encrypt($data->id) }}')"
                                class="w-auto! py-2!" type="submit">
                                <span class="text-text-btn-primary group-hover:text-text-btn-secondary">
                                    {{ __('Accept') }}
                                </span>
                            </x-ui.button>
                        </div>
                        <div class="">
                            <x-ui.button wire:click="openModal" variant="tertiary" type="button" class="w-auto! py-2!">
                                {{ __('Reject') }}
                            </x-ui.button>
                        </div>
                    @elseif ($data->status->value == \App\Enums\UserWithdrawalAccount::DECLINED->value)
                        <div>
                            <x-ui.button wire:click.prevent="makeVerified('{{ encrypt($data->id) }}')"
                                class="w-auto! py-2!" type="submit">
                                <span class="text-text-btn-primary group-hover:text-text-btn-secondary">
                                    {{ __('Accept') }}
                                </span>
                            </x-ui.button>
                        </div>
                    @endif
                </div>
                @if ($showModal)
                    <div class="fixed inset-0 bg-black/50 backdrop-blur-sm flex justify-center items-center z-50">
                        <div class="bg-white dark:bg-zinc-700 p-6 rounded-lg shadow-xl w-full max-w-md">
                            <h2 class="text-xl font-semibold mb-4 text-text-white">{{ __('Reject Reason') }}</h2>

                            <div class="mb-5">
                                <label for="note"
                                    class="block text-sm font-medium text-text-white mb-1">{{ __('Note') }}</label>
                                <textarea type="text" wire:model="note" id="note"
                                    class="w-full border border-zinc-50 rounded-md px-3 py-2 focus:outline-none" placeholder="Type something here..."> </textarea>
                            </div>
                            <div class="flex justify-end space-x-3">
                                <div class="">
                                    <x-ui.button wire:click="closeModal" variant="tertiary" type="button"
                                        class="w-auto! py-2!">
                                        {{ __('Cancel') }}
                                    </x-ui.button>
                                </div>
                                <x-ui.button wire:click="makeRejected('{{ encrypt($data->id) }}')"
                                    class="w-auto! py-2!" type="submit">
                                    <span class="text-text-btn-primary group-hover:text-text-btn-secondary">
                                        {{ __('Submit') }}
                                    </span>
                                </x-ui.button>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

</div>
