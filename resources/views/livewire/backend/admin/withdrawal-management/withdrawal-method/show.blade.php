<div>
    {{-- Page Header --}}

    <div class="bg-bg-secondary w-full rounded">
        <div class="mx-auto">
            <div class="glass-card rounded-2xl p-4 lg:p-6 mb-6">
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                    <h2 class="text-xl lg:text-2xl font-bold text-text-black dark:text-text-white">
                        {{ __('Withdrawal Method Details') }}
                    </h2>
                    <div class="flex items-center gap-2 w-full sm:w-auto">
                        <x-ui.button href="{{ route('admin.wm.method.index') }}" class="w-auto py-2!">
                            <flux:icon name="arrow-left"
                                class="w-4 h-4 stroke-text-btn-primary group-hover:stroke-text-btn-secondary" />
                            {{ __('Back') }}
                        </x-ui.button>
                    </div>
                </div>
            </div>
            <!-- Main Card -->
            <div class="bg-bg-primary rounded-2xl shadow-lg overflow-hidden border border-gray-500/20">

                <!-- Product Data Section -->
                <div class="px-8 py-8">
                    <div class="mb-10">
                        <div
                            class="w-full max-w-96 bg-slate-50 dark:bg-gray-700 rounded-lg p-4 border border-slate-200">
                            <p class="text-text-white text-xs font-semibold mb-2 capitalize">{{ __('Image') }}</p>

                            <div class="rounded-lg overflow-hidden">
                                <img src="{{ storage_url($data->icon) }}" alt="{{ $data->name }}" class="w-full">
                            </div>
                        </div>
                        <div class="bg-slate-50 dark:bg-gray-700 rounded-lg p-4 mt-8 border border-slate-200">
                            <p class="text-text-white text-xs font-semibold mb-2">{{ __('Description') }}</p>
                            <p class="text-slate-400 text-lg font-bold">{!! $data->description !!}</p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mt-8">

                            <div class="bg-slate-50 dark:bg-gray-700 rounded-lg p-4 border border-slate-200">
                                <p class="text-text-white text-xs font-semibold mb-2">{{ __('NAME') }}</p>
                                <p class="text-slate-400 text-lg font-bold">{{ $data->name }}</p>
                            </div>
                            <div class="bg-slate-50 dark:bg-gray-700 rounded-lg p-4 border border-slate-200">
                                <p class="text-text-white text-xs font-semibold mb-2">{{ __('Code') }}</p>
                                <p class="text-slate-400 text-lg font-bold">{{ $data->code }}</p>
                            </div>
                            <div class="bg-slate-50 dark:bg-gray-700 rounded-lg p-4 border border-slate-200">
                                <p class="text-text-white text-xs font-semibold mb-2">{{ __('Status') }}</p>
                                <p class="text-slate-400 text-lg font-bold">
                                    <span
                                        class="badge badge-{{ $data->status->color() }}">{{ $data->status->label() }}</span>
                                </p>
                            </div>
                            <div class="bg-slate-50 dark:bg-gray-700 rounded-lg p-4 border border-slate-200">
                                <p class="text-text-white text-xs font-semibold mb-2">{{ __('Minimum Amount') }}</p>
                                <p class="text-slate-400 text-lg font-bold">{{ $data->minimum_amount }}</p>
                            </div>
                            <div class="bg-slate-50 dark:bg-gray-700 rounded-lg p-4 border border-slate-200">
                                <p class="text-text-white text-xs font-semibold mb-2">{{ __('Maximum Amount') }}</p>
                                <p class="text-slate-400 text-lg font-bold">{{ $data->maximum_amount }}</p>
                            </div>

                            <div class="bg-slate-50 dark:bg-gray-700 rounded-lg p-4 border border-slate-200">
                                <p class="text-text-white text-xs font-semibold mb-2">{{ __('Daily Limit') }}</p>
                                <p class="text-slate-400 text-lg font-bold">{{ $data->daily_limit ?? 'N/A' }}</p>
                            </div>
                            <div class="bg-slate-50 dark:bg-gray-700 rounded-lg p-4 border border-slate-200">
                                <p class="text-text-white text-xs font-semibold mb-2">{{ __('Weekly Limit') }}</p>
                                <p class="text-slate-400 text-lg font-bold">{{ $data->weekly_limit ?? 'N/A' }}</p>
                            </div>
                            <div class="bg-slate-50 dark:bg-gray-700 rounded-lg p-4 border border-slate-200">
                                <p class="text-text-white text-xs font-semibold mb-2">{{ __('Monthly Limit') }}</p>
                                <p class="text-slate-400 text-lg font-bold">{{ $data->monthly_limit ?? 'N/A' }}</p>
                            </div>
                            <div class="bg-slate-50 dark:bg-gray-700 rounded-lg p-4 border border-slate-200">
                                <p class="text-text-white text-xs font-semibold mb-2">{{ __('Fee Type') }}</p>
                                <p class="text-slate-400 text-lg font-bold">{{ $data->fee_type }}</p>
                            </div>
                            <div class="bg-slate-50 dark:bg-gray-700 rounded-lg p-4 border border-slate-200">
                                <p class="text-text-white text-xs font-semibold mb-2">{{ __('Fee Amount') }}</p>
                                <p class="text-slate-400 text-lg font-bold">{{ $data->fee_amount }}</p>
                            </div>
                            <div class="bg-slate-50 dark:bg-gray-700 rounded-lg p-4 border border-slate-200">
                                <p class="text-text-white text-xs font-semibold mb-2">{{ __('Fee Percentage') }}</p>
                                <p class="text-slate-400 text-lg font-bold">{{ $data->fee_percentage }}</p>
                            </div>
                            <div class="bg-slate-50 dark:bg-gray-700 rounded-lg p-4 border border-slate-200">
                                <p class="text-text-white text-xs font-semibold mb-2">{{ __('Processing Time') }}</p>
                                <p class="text-slate-400 text-lg font-bold">{{ $data->processing_time }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="mb-10">
                        <h2 class="text-base font-bold mb-4">Required Fields</h2>
                        @if ($data->required_fields && count(json_decode($data->required_fields)) > 0)
                            <div class="overflow-x-auto">
                                <table class="min-w-full border border-slate-200 rounded-lg">
                                    <thead class="bg-slate-100 dark:bg-gray-800">
                                        <tr class="text-left text-sm font-semibold text-slate-600 dark:text-gray-300">
                                            <th class="px-4 py-3 border">#</th>
                                            <th class="px-4 py-3 border">Label</th>
                                            <th class="px-4 py-3 border">Name</th>
                                            <th class="px-4 py-3 border">Input Type</th>
                                            <th class="px-4 py-3 border">Validation</th>
                                            <th class="px-4 py-3 border">Placeholder</th>
                                            <th class="px-4 py-3 border">Help Text</th>
                                        </tr>
                                    </thead>

                                    <tbody class="bg-white dark:bg-gray-700">
                                        @foreach (json_decode($data->required_fields) as $field)
                                            <tr class="text-sm text-slate-600 dark:text-gray-200">
                                                <td class="px-4 py-3 border">
                                                    {{ $loop->iteration }}
                                                </td>
                                                <td class="px-4 py-3 border font-medium">
                                                    {{ $field->label ?? '-' }}
                                                </td>

                                                <td class="px-4 py-3 border">
                                                    {{ $field->name ?? '-' }}
                                                </td>

                                                <td class="px-4 py-3 border capitalize">
                                                    {{ $field->input_type ?? '-' }}
                                                </td>

                                                <td class="px-4 py-3 border">
                                                    <span
                                                        class="inline-flex items-center px-2 py-1 text-xs rounded bg-slate-200 dark:bg-gray-600">
                                                        {{ $field->validation ?? '-' }}
                                                    </span>
                                                </td>

                                                <td class="px-4 py-3 border">
                                                    {{ $field->placeholder ?? '-' }}
                                                </td>

                                                <td class="px-4 py-3 border">
                                                    {{ $field->help_text ?? '-' }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="text-sm text-slate-400">
                                No required fields defined.
                            </p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
