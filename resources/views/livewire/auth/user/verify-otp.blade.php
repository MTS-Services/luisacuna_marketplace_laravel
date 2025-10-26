 <div class="container mx-auto ">
     <div class="min-h-screen flex items-center justify-center bg-[#0D061A] text-white ">
         <form wire:submit="verify"
             class="-mt-28 w-full h-[650px] max-w-lg bg-[#1a0b2e] rounded-2xl p-8 shadow-lg space-y-8">

             @if (session()->has('message'))
                 <div class="rounded-md bg-green-50 p-4 dark:bg-green-900/20">
                     <div class="flex">
                         <div class="flex-shrink-0">
                             <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                                 <path fill-rule="evenodd"
                                     d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                     clip-rule="evenodd" />
                             </svg>
                         </div>
                         <div class="ml-3">
                             <p class="text-sm font-medium text-green-800 dark:text-green-200">
                                 {{ session('message') }}
                             </p>
                         </div>
                     </div>
                 </div>
             @endif

             <!-- Header -->
             <div class="text-center">
                 <h2 class="text-2xl lg:text-5xl md:text-4xl font-medium p-4 text-white ">Confirm your Gmail</h2>
                 <p class="text-gray-300 lg:text-xl text-base">
                     We have sent a code in an Email message to ex**@gmaol.co To confirm your account, please enter the
                     code .
                 </p>
             </div>

             <!-- code -->
             <div>
                 <label class="block text-xl font-medium mb-2 text-white">Code</label>
                 <input wire:model="form.code" type="text" placeholder="input code"
                     class="w-full px-4 py-3 bg-[#2d1f43] text-white placeholder-gray-400 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500" />

                 @error('form.code')
                     <p class="mt-2 text-center text-sm text-red-600 dark:text-red-400">
                         {{ $message }}
                     </p>
                 @enderror

                 <div>
                 </div>
             </div>

             <!-- Forgot password -->
             <div class="text-right px-2 sm:px-6 mb-6">
                 <a href="#" class="text-md text-white hover:underline">Don't have resend again?</a>
             </div>

             <!-- Submit button -->
             <div>
                 <button type="submit" wire:click="sendCode"
                     class="w-full bg-[#853fee] hover:bg-purple-700 transition-colors text-white font-medium py-3 rounded-full">
                     Verify
                 </button>
             </div>

             <!-- Divider -->
             <div class="flex items-center justify-center space-x-2">
                 <hr class="flex-1 border-gray-700" />
                 <span class="text-gray-200 text-sm">Or sign in with</span>
                 <hr class="flex-1 border-gray-700" />
             </div>

             <!-- Social login -->
             <div class="flex justify-center gap-4">
                 <button class="w-12 h-12 flex items-center justify-center bg-white rounded-md">
                     <img src="{{ asset('assets/icons/icons8-google.svg') }}" class="w-6 h-6" alt="Google" />
                 </button>
                 <button class="w-12 h-12 flex items-center justify-center bg-white rounded-md">
                     <img src="{{ asset('assets/icons/icons8-apple-logo.svg') }}" class="w-6 h-6" alt="Apple" />
                 </button>
                 <button class="w-12 h-12 flex items-center justify-center bg-white rounded-md">
                     <img src="{{ asset('assets/icons/icons8-facebook.svg') }}" class="w-6 h-6" alt="Facebook" />
                 </button>
             </div>

             <!-- Footer -->
             <div class="text-center text-gray-200 text-sm">
                 Don’t have an account?
                 <a href="{{ route('register') }}" class="text-purple-400 hover:underline">Sign up</a>
             </div>
         </form>
     </div>
 </div>
