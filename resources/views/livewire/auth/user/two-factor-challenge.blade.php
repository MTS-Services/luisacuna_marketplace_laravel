<x-layouts.auth>
<div class="max-w-md mx-auto">
    <h2 class="text-2xl font-bold mb-6">Two-Factor Authentication</h2>
    
    <p class="text-gray-600 mb-6">
        Please enter your authentication code to continue.
    </p>

    @if($errors->any())
        <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
            @foreach($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('two-factor.login') }}">
        @csrf
        <div class="mb-4">
            <label for="code" class="block mb-2">Authentication Code</label>
            <input type="text" 
                   id="code" 
                   name="code" 
                   class="w-full px-4 py-2 border rounded"
                   maxlength="6"
                   placeholder="000000"
                   autofocus>
        </div>
        <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700">
            Verify
        </button>
    </form>

    <div class="mt-6 border-t pt-6">
        <p class="text-sm text-gray-600 mb-4">Use a recovery code</p>
        <form method="POST" action="{{ route('admin.two-factor.disable') }}">
            @csrf
            @method('DELETE')
            <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded">
                Disable Admin 2FA
            </button>
        </form>
    @else
        <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded">
            <p class="text-red-900 font-semibold">⚠️ Admin 2FA is not enabled</p>
        </div>

        <form method="POST" action="{{ route('admin.two-factor.enable') }}">
            @csrf
            <button type="submit" class="px-6 py-3 bg-purple-600 text-white rounded">
                Enable Admin 2FA
            </button>
        </form>
    @endif
</div>

<script>
function loadQRCode() {
    fetch('{{ route("admin.two-factor.qr-code") }}')
        .then(r => r.json())
        .then(data => {
            document.getElementById('qrCode').innerHTML = data.svg;
            document.getElementById('qrCode').classList.remove('hidden');
        });
}

function showRecoveryCodes() {
    fetch('{{ route("admin.two-factor.recovery-codes") }}')
        .then(r => r.json())
        .then(codes => {
            document.getElementById('recoveryCodes').innerHTML = codes.map(code => 
                `<div class="p-2 bg-white border rounded font-mono">${code}</div>`
            ).join('');
            document.getElementById('recoveryCodes').classList.remove('hidden');
        });
}
</script>
</x-layouts.auth>
