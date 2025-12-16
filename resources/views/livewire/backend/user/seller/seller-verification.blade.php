<div class="min-h-[70vh] bg-bg-primary py-12 px-4">
    <div class="max-w-4xl mx-auto">

        @if (session('success'))
            <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                {{ session('error') }}
            </div>
        @endif

      

            <div class="text-center">
                <div class="mb-6">
                    <div class="mx-auto w-32 h-32 flex items-center justify-center">
                        <span class="text-8xl">🔍</span>
                    </div>
                </div>

                <h2 class="text-2xl font-bold dark:text-text-white text-zinc-500/80 mb-4">Seller verification required
                </h2>

                <p class="dark:text-text-white text-zinc-500/50 mb-2">To sell currencies, please verify your identity
                    first.</p>
                <p class="dark:text-text-white text-zinc-500/50 mb-8">Our 24/7 support team will review your ID in up to
                    15 minutes.</p>

                <a href="{{ route('user.seller.verification', ['step' => encrypt(1)]) }}" class="bg-bg-secondary rounded-lg p-6 mb-6 inline-block">
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 rounded-full flex items-center justify-center">
                            <img src="{{ asset('assets/images/verification.svg') }}" alt="">
                        </div>
                        <div class="flex-1 text-left">
                            <p class="font-semibold">Seller Verification</p>
                            <span class="inline-block px-3 py-1 bg-pink-500 text-white text-sm rounded-full">Documents
                                required</span>
                        </div>
                        <x-phosphor-caret-right class="w-6 h-6 fill-zinc-500" />
                    </div>
                </a>


                <a href="#" class="block mt-4 text-zinc-600/80 hover:underline">Why do I need to verify my ID?</a>
            </div>

      
    </div>
</div>
