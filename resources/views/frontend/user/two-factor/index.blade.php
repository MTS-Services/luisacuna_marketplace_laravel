<x-frontend::app>
    <div class="max-w-4xl mx-auto">
        <h2 class="text-2xl font-bold mb-6">Two-Factor Authentication</h2>

        @if (session('status'))
            <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
                {{ session('status') }}
            </div>
        @endif

        @if ($twoFactorEnabled)
            <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded">
                <p class="text-green-900 font-semibold">✓ 2FA is Active</p>
            </div>

            @if (!auth()->user()->two_factor_confirmed_at)
                <div class="mb-6 p-6 bg-gray-50 rounded">
                    <h3 class="font-semibold mb-4">Scan QR Code</h3>
                    <button onclick="loadQRCode()" class="px-4 py-2 bg-blue-600 text-white rounded">
                        Show QR Code
                    </button>
                    <div id="qrCode" class="mt-4 hidden"></div>

                    <form method="POST" action="{{ route('two-factor.confirm') }}" class="mt-6">
                        @csrf
                        <input type="text" name="code" placeholder="000000" maxlength="6"
                            class="px-4 py-2 border rounded">
                        <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded">Confirm</button>
                    </form>
                </div>
            @endif

            @if (auth()->user()->two_factor_confirmed_at)
                <div class="mb-6">
                    <button onclick="showRecoveryCodes()" class="px-4 py-2 bg-gray-600 text-white rounded">
                        Show Recovery Codes
                    </button>
                    <div id="recoveryCodes" class="mt-4 hidden"></div>

                    <form method="POST" action="{{ route('two-factor.recovery-codes.store') }}" class="mt-4 inline">
                        @csrf
                        <button type="submit" class="px-4 py-2 bg-yellow-600 text-white rounded">
                            Regenerate Codes
                        </button>
                    </form>
                </div>
            @endif

            <form method="POST" action="{{ route('two-factor.disable') }}">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded">
                    Disable 2FA
                </button>
            </form>
        @else
            <div class="mb-6 p-4 bg-yellow-50 border border-yellow-200 rounded">
                <p class="text-yellow-900">2FA is not enabled</p>
            </div>

            <form method="POST" action="{{ route('two-factor.enable') }}">
                @csrf
                <button type="submit" class="px-6 py-3 bg-blue-600 text-white rounded">
                    Enable 2FA
                </button>
            </form>
        @endif
    </div>

    <script>
        function loadQRCode() {
            fetch('{{ route('two-factor.qr-code') }}')
                .then(r => r.json())
                .then(data => {
                    document.getElementById('qrCode').innerHTML = data.svg;
                    document.getElementById('qrCode').classList.remove('hidden');
                });
        }

        function showRecoveryCodes() {
            fetch('{{ route('two-factor.recovery-codes') }}')
                .then(r => r.json())
                .then(codes => {
                    document.getElementById('recoveryCodes').innerHTML = codes.map(code =>
                        `<div class="p-2 bg-white border rounded font-mono">${code}</div>`
                    ).join('');
                    document.getElementById('recoveryCodes').classList.remove('hidden');
                });
        }
    </script>
</x-frontend::app>
