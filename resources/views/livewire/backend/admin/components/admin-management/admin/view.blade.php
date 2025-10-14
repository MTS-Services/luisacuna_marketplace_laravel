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

    <div class=" mx-auto mt-10 bg-white shadow rounded-lg p-8 glass-card rounded-2xl p-6 ">
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


                <!-- Vertical Table -->
                <table class="w-full border border-gray-200 rounded-lg text-sm">
                    <tbody class="divide-y divide-gray-200">
                        <tr class="hover:bg-gray-50">
                            <td class="p-3  w-1/3 text-gray-700 font-bold">Full Name:</td>
                            <td class="p-3">{{ $admin->name }}</td>
                        </tr>
                        <tr class="hover:bg-gray-50">
                            <td class="p-3  text-gray-700 font-bold">Email:</td>
                            <td class="p-3">{{ $admin->email }}</td>
                        </tr>
                        <tr class="hover:bg-gray-50">
                            <td class="p-3 font-bold text-gray-700">Phone:</td>
                            <td class="p-3">{{ $admin->phone }}</td>
                        </tr>
                        <tr class="hover:bg-gray-50">
                            <td class="p-3 font-bold text-gray-700">Address</td>
                            <td class="p-3">{{ $admin->address }}</td>
                        </tr>
                        <tr class="hover:bg-gray-50">
                            <td class="p-3 font-bold text-gray-700">Status</td>
                            <td class="p-3 badge badge-info align-middle my-2">{{ $admin->status }}</td>
                        </tr>
                        <tr class="hover:bg-gray-50">
                            <td class="p-3 font-bold text-gray-700">Verified:</td>
                            <td class="p-3 badge {{ $admin->verify_color }} align-middle my-2">{{ $admin->verify_label }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div>
                <table class="w-full border border-gray-200 rounded-lg text-sm">
                    <tbody class="divide-y divide-gray-200">
                        <tr class="hover:bg-gray-50">
                            <td class="p-3 font-bold w-1/3 text-gray-700">Created By</td>
                            <td class="p-3">{{ $admin->creater }}</td>
                        </tr>
                        <tr class="hover:bg-gray-50">
                            <td class="p-3 font-bold text-gray-700">Created At</td>
                            <td class="p-3">{{ $admin->created_at_formatted }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>


    </div>


</section>
