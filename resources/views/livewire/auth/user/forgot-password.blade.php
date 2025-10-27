
 <div class="container mx-auto">
     <div class="min-h-screen flex items-center justify-center bg-[#0D061A] text-white">

         <!-- Correct form submission -->
         <form  wire:submit="sendPasswordResetOtp"
             class="-mt-28 w-full h-[600px] max-w-lg bg-[#1a0b2e] rounded-2xl p-8 shadow-lg space-y-8">

             <!-- Header -->
             <div class="text-center">
                 <h2 class="text-4xl font-medium p-4 text-white">Forget Your Password?</h2>
                 <p class="text-gray-300 lg:text-xl text-sm">
                     Enter your email address, we will send a message with a code to reset your password.
                 </p>
             </div>

             <!-- Email -->
             <div>
                 <label class="block text-xl font-medium mb-2 text-white">Email</label>
                 <input type="email" placeholder="example@gmail.com" wire:model="email"
                     class="w-full px-4 py-3 bg-[#2d1f43] text-white placeholder-gray-400 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500" />
             </div>

             <!-- Error message -->
             @error('email')
                 <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
             @enderror

             <!-- Submit button -->
             <div>
                 <button type="submit"
                     class="w-full bg-[#853fee] hover:bg-purple-700 transition-colors text-white font-medium py-3 rounded-full">
                     Reset Password
                 </button>
             </div>

             
             <!-- Back to login page -->
             <div class="text-center w-full bg-[#fff] py-3 rounded-full">
                 <a href="{{ route('login') }}" class="text-purple-700 text-lg">
                     Back
                 </a>
             </div>
         </form>
     </div>
 </div>
