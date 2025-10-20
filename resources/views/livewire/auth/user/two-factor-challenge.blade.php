<div>
    <div class="max-w-md mx-auto">
        <div class="bg-white rounded-lg shadow-lg p-8">
            <h2 class="text-2xl font-bold mb-2 text-gray-900">Two-Factor Authentication</h2>
            <p class="text-gray-600 mb-6">Please enter your authentication code to continue.</p>

            @if ($errors->any())
                <div class="mb-4 p-4 bg-red-100 border-l-4 border-red-500 text-red-700 rounded">
                    @foreach ($errors->all() as $error)
                        <p class="text-sm">{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <!-- OTP Code Form -->
            <form method="POST" action="{{ route('two-factor.login.store') }}">
                @csrf
                <div class="mb-6">
                    <label for="code" class="block text-sm font-medium text-gray-700 mb-2">
                        Authentication Code
                    </label>
                    <input 
                        type="text" 
                        id="code" 
                        name="code" 
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-center text-2xl tracking-widest"
                        maxlength="6" 
                        placeholder="000000" 
                        autofocus
                        required
                    >
                    <p class="text-xs text-gray-500 mt-2">From your authenticator app (Google Authenticator, Authy, etc.)</p>
                </div>

                <button 
                    type="submit" 
                    class="w-full bg-blue-600 text-white font-semibold py-3 rounded-lg hover:bg-blue-700 transition duration-200"
                >
                    Verify Code
                </button>
            </form>

            <!-- Recovery Code Option -->
            <div class="mt-6 pt-6 border-t border-gray-200">
                <button 
                    type="button" 
                    onclick="toggleRecoveryForm()"
                    class="w-full text-center text-sm text-blue-600 hover:text-blue-800 font-medium"
                >
                    Don't have your authenticator? Use a recovery code
                </button>

                <form method="POST" action="{{ route('two-factor.login.store') }}" id="recoveryForm" class="hidden mt-4">
                    @csrf
                    <div class="mb-4">
                        <label for="recovery_code" class="block text-sm font-medium text-gray-700 mb-2">
                            Recovery Code
                        </label>
                        <input 
                            type="text" 
                            id="recovery_code" 
                            name="recovery_code" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Enter recovery code"
                            maxlength="12"
                        >
                        <p class="text-xs text-gray-500 mt-2">Enter one of your recovery codes (stored separately)</p>
                    </div>
                    <button 
                        type="submit" 
                        class="w-full bg-gray-600 text-white font-semibold py-2 rounded-lg hover:bg-gray-700 transition duration-200"
                    >
                        Verify Recovery Code
                    </button>
                </form>
            </div>
        </div>

        <script>
            function toggleRecoveryForm() {
                const form = document.getElementById('recoveryForm');
                form.classList.toggle('hidden');
                if (!form.classList.contains('hidden')) {
                    document.getElementById('recovery_code').focus();
                }
            }

            // Auto-focus code input for better UX
            document.addEventListener('DOMContentLoaded', function() {
                const codeInput = document.getElementById('code');
                if (codeInput) {
                    codeInput.focus();
                }
            });
        </script>
    </div>
</div>