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


    <div class="admin_details">
              <div class="block inset-0 z-50 overflow-y-auto">
            <div class="block items-center justify-center min-h-screen py-6">

                
                {{-- Modal --}}
                <div
                    class="relative bg-zinc-50  rounded-2xl text-left overflow-hidden  transform transition-all w-full border border-zinc-50">
                   

                    {{-- Body --}}
                    <div class="px-6 py-6 space-y-6">
                        {{-- Profile Section --}}
                    
                        {{-- Information Grid --}}
                        <div class="grid grid-cols-3 gap-4">
                            <div class="bg-white rounded-lg p-4 border border-zinc-700" >
                                <p class="text-xs text-zinc-500 uppercase tracking-wider mb-1">id</p>
                                <p class="text-zinc-500 font-medium">{{ '#'.$admin->id }}</p>
                            </div>

                            <div class="bg-white rounded-lg p-4 border border-zinc-700 ">
                                <p class="text-xs text-zinc-500 uppercase tracking-wider mb-1">Name</p>
                                <div class="text-zinc-500 font-medium flex items-center ">
                                  <p class="inline-block !rounded-full overflow-hidden">  <img src="{{ $existingAvatar }}" alt="" class="w-[50px] h-[50px] "></p>
                                  <p class="font-bold text-zinc-500 pl-3">{{ $admin->name }}</p> 
                                </div>
                              
                            </div>

                            <div class="bg-white rounded-lg p-4 border border-zinc-700">
                                <p class="text-xs text-zinc-500 uppercase tracking-wider mb-1">Status</p>
                               
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium border">
                                 
                                  {{ $admin->status }}
                                </span>
                            </div>
                            <div class="bg-white rounded-lg p-4 border border-zinc-700 ">
                                <p class="text-xs text-zinc-500 uppercase tracking-wider mb-1">Email</p>
                                <p class="text-zinc-500 font-medium">{{ $admin->email}}</p>
                            </div>

                            <div class="bg-white rounded-lg p-4 border border-zinc-700" >
                                <p class="text-xs text-zinc-500 uppercase tracking-wider mb-1">Phone</p>
                                <p class="text-zinc-500 font-medium">{{ $admin->phone }}</p>
                            </div>

                            <div class="bg-white rounded-lg p-4 border border-zinc-700">
                                <p class="text-xs text-zinc-500 uppercase tracking-wider mb-1">Address</p>
                               
                                <p class="text-zinc-500 font-medium">{{ $admin->address }}</p>
                            </div>
                            <div class="bg-white rounded-lg p-4 border border-zinc-700 ">
                                <p class="text-xs text-zinc-500 uppercase tracking-wider mb-1">Verified</p>
                                <p class="text-zinc-500 font-medium">{{ $admin->verify_label}}</p>
                            </div>

                            <div class="bg-white rounded-lg p-4 border border-zinc-700" >
                                <p class="text-xs text-zinc-500 uppercase tracking-wider mb-1">Created By</p>
                                <p class="text-zinc-500 font-medium">{{ $admin->created_at_human }}</p>
                            </div>

                            <div class="bg-white rounded-lg p-4 border border-zinc-700">
                                <p class="text-xs text-zinc-500 uppercase tracking-wider mb-1">Created at</p>
                               
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium border">
                                  {{$admin->created_at_formatted}}
                                </span>
                            </div>
                            
                    </div>

                

                    
                </div>
            </div>
        </div>
    </div>

</section>
