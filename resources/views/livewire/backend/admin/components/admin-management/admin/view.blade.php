<section>
    <div class="glass-card rounded-2xl p-6 mb-6">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-bold text-text-black dark:text-text-white">{{ __('Admin List') }}</h2>
            <div class="flex items-center gap-2">
                <x-ui.button href="{{ route('admin.am.admin.trash') }}" type='secondary'>
                    <flux:icon name="trash" class="w-4 h-4 stroke-white" />
                    {{ __('Trash') }}
                </x-ui.button>
                <x-ui.button href="{{ route('admin.am.admin.create') }}">
                    <flux:icon name="user-plus" class="w-4 h-4 stroke-white" />
                    {{ __('Add') }}
                </x-ui.button>
            </div>
        </div>
    </div>

    <div class=" mx-auto mt-10 bg-white shadow glass-card rounded-2xl p-6 ">
        <!-- Profile Header -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between border-b pb-6 mb-6">
            <div class="flex items-center space-x-4">
                <img src="{{ $existingAvatar ?? '' }}" alt="Profile" class="w-24 h-24 rounded-full object-cover">
                <div>
                    <h2 class="text-2xl font-semibold">{{ $admin->name }}</h2>
                    <p class="text-sm text-gray-500">{{ $admin->email }}</p>
                    <p class="text-sm text-gray-500 mt-1"><i class="fa-solid fa-location-dot mr-1"></i>
                        {{ $admin->address }}</p>
                </div>
            </div>


        </div>

        <!-- Profile Info -->
        <div class="grid md:grid-cols-2 gap-6">
            <div>

                <div class="bg-gray-50 rounded-xl border border-gray-200 overflow-hidden">
                    <table class="w-full text-sm">
                        <tbody class="divide-y divide-gray-200">
                            <tr class="hover:bg-white transition-colors">
                                <td class="p-4 w-2/5 text-gray-600 font-semibold">Full Name</td>
                                <td class="p-4 text-gray-900">{{ $admin->name }}</td>
                            </tr>
                            <tr class="hover:bg-white transition-colors">
                                <td class="p-4 text-gray-600 font-semibold">Email</td>
                                <td class="p-4 text-gray-900">{{ $admin->email }}</td>
                            </tr>
                            <tr class="hover:bg-white transition-colors">
                                <td class="p-4 text-gray-600 font-semibold">Phone</td>
                                <td class="p-4 text-gray-900">{{ $admin->phone }}</td>
                            </tr>
                            <tr class="hover:bg-white transition-colors">
                                <td class="p-4 text-gray-600 font-semibold">Address</td>
                                <td class="p-4 text-gray-900">{{ $admin->address }}</td>
                            </tr>
                            <tr class="hover:bg-white transition-colors">
                                <td class="p-4 text-gray-600 font-semibold">Status</td>
                                <td class="p-4">
                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        {{ $admin->status }}
                                    </span>
                                </td>
                            </tr>
                            <tr class="hover:bg-white transition-colors">
                                <td class="p-4 text-gray-600 font-semibold">Verified</td>
                                <td class="p-4">
                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $admin->verify_color }}">
                                        {{ $admin->verify_label }}
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div>
                <div class="bg-gray-50 rounded-xl border border-gray-200 overflow-hidden">
                    <table class="w-full text-sm">
                        <tbody class="divide-y divide-gray-200">
                            <tr class="hover:bg-white transition-colors">
                                <td class="p-4 w-2/5 text-gray-600 font-semibold">Created By</td>
                                <td class="p-4 text-gray-900">{{ $admin->creater }}</td>
                            </tr>
                            <tr class="hover:bg-white transition-colors">
                                <td class="p-4 text-gray-600 font-semibold">Created At</td>
                                <td class="p-4 text-gray-900">{{ $admin->created_at_formatted }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>


    </div>


</section>
