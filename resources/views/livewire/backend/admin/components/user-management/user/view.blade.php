{{-- <div>
    <p><strong>Name:</strong> {{ $user->name }}</p>
    <p><strong>Email:</strong> {{ $user->email }}</p>
    <p><strong>Phone:</strong> {{ $user->phone ?? 'N/A' }}</p>
    <p><strong>Address:</strong> {{ $user->address ?? 'N/A' }}</p>
    <p><strong>Status:</strong> {{ ucfirst($user->status->label()) }}</p>
</div> --}}


<section class="container mx-auto mt-5">
    <div class="grid lg:grid-cols-3 gap-5">
        {{-- Left Column: Profile Image and Role --}}
        <div class="flex flex-col h-auto shadow rounded-xl p-6">
            <h1 class="text-xl text-bg-black font-bold">Profile Image</h1>

            <div class="w-28 h-28 rounded-full mx-auto mt-10 border-4 border-black overflow-hidden">
                    <img src="{{ asset('storage/' . $user->avatar) }}" alt="Profile Image" class="w-full h-full">
            </div>

            <div class="flex flex-col items-center justify-between mt-6">
                <h1 class="text-2xl font-bold text-center">{{ $user->username }}</h1>
                <h1 class="text-gray-600">{{ $user->email }}</h1>
            </div>

            {{-- <div class="flex items-start space-x-2">
                <span class="text-gray-500"></span>
                <div>
                    <p class="text-gray-500 mb-1">User Name</p>
                    <p class="font-medium">{{ $user->username }}</p>
                </div>
            </div> --}}
            
            <div class="flex items-start space-x-2">
                <span class="text-gray-500"></span>
                <div>
                    <p class="text-gray-500 mb-1">Phone</p>
                    <p class="font-medium">{{ $user->phone }}</p>
                </div>
            </div>

            <div class="flex items-start space-x-2">
                <span class="text-gray-500"></span>
                <div>
                    <p class="text-gray-500 mb-1">Email</p>
                    <p class="font-medium">{{ $user->email }}</p>
                </div>
            </div>

            <div class="flex items-start space-x-2">
                <span class="text-gray-500"></span>
                <div>
                    <p class="text-gray-500 mb-1">Account Status</p>
                    <span
                        class="px-3 py-1 rounded-full text-xs badge badge-soft {{ $user->status_color }} transition">
                        {{ $user->status_label }}
                    </span>
                </div>
            </div>
        </div>

        {{-- Right Column: Profile Information --}}
        <div class="bg-white shadow rounded-xl p-6 col-span-1 lg:col-span-2 relative">
            <h2 class="text-lg font-semibold mb-6">Profile Information</h2>



                <div class="grid md:grid-cols-2 gap-6 text-sm">
                    {{-- Full Name --}}
                    <div class="flex items-start space-x-2">
                        <span class="text-gray-500"></span>
                        <div class="flex-1">
                            <p class="text-gray-500 mb-1">First Name</p>
                            <h1>{{ $user->first_name }}</h1>
                        </div>
                    </div>

                    <div class="flex items-start space-x-2">
                        <span class="text-gray-500"></span>
                        <div class="flex-1">
                            <p class="text-gray-500 mb-1">Last Name</p>
                            <h4>{{ $user->last_name }}</h4>
                        </div>
                    </div>

                    <div class="flex items-start space-x-2">
                        <span class="text-gray-500"></span>
                        <div class="flex-1">
                            <p class="text-gray-500 mb-1">Display Name</p>
                            <h4>{{ $user->display_name }}</h4>
                        </div>
                    </div>

                    <div class="flex items-start space-x-2">
                        <span class="text-gray-500"></span>
                        <div class="flex-1">
                            <p class="text-gray-500 mb-1">Date of Birth</p>
                            <h4>{{ $user->date_of_birth }}</h4>
                        </div>
                    </div>

                    <div class="flex items-start space-x-2">
                        <span class="text-gray-500"></span>
                        <div class="flex-1">
                            <p class="text-gray-500 mb-1">Country</p>
                            <h4>{{ $user->country->name }}</h4>
                        </div>
                    </div>
                </div>
        </div>

    </div>

</section>
