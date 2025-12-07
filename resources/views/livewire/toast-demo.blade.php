<div class="max-w-6xl mx-auto p-6 space-y-8">
    <!-- Header -->
    <div
        class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-8 text-center border border-gray-200 dark:border-gray-700">
        <h1 class="text-4xl font-bold text-gray-900 dark:text-white mb-3">
            🎉 Modern Toast Notifications
        </h1>
        <p class="text-gray-600 dark:text-gray-300 text-lg">
            Beautiful, lightweight toast notifications with iziToast
        </p>
    </div>

    <!-- Basic Types -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 border border-gray-200 dark:border-gray-700">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6 flex items-center gap-2">
            <span>🎨</span> Basic Toast Types
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <button wire:click="showSuccessToast"
                class="px-6 py-3 bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white rounded-lg font-medium transition-all duration-200 shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                ✓ Success
            </button>
            <button wire:click="showErrorToast"
                class="px-6 py-3 bg-gradient-to-r from-red-500 to-rose-600 hover:from-red-600 hover:to-rose-700 text-white rounded-lg font-medium transition-all duration-200 shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                ✕ Error
            </button>
            <button wire:click="showWarningToast"
                class="px-6 py-3 bg-gradient-to-r from-amber-500 to-orange-600 hover:from-amber-600 hover:to-orange-700 text-white rounded-lg font-medium transition-all duration-200 shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                ⚠ Warning
            </button>
            <button wire:click="showInfoToast"
                class="px-6 py-3 bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700 text-white rounded-lg font-medium transition-all duration-200 shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                ℹ Info
            </button>
        </div>
    </div>

    <!-- Positions -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 border border-gray-200 dark:border-gray-700">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6 flex items-center gap-2">
            <span>📍</span> Position Support
        </h2>
        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
            <button wire:click="showTopLeft"
                class="px-6 py-3 bg-purple-500 hover:bg-purple-600 text-white rounded-lg font-medium transition-all duration-200 shadow-md hover:shadow-lg">
                ↖ Top Left
            </button>
            <button wire:click="showTopCenter"
                class="px-6 py-3 bg-purple-500 hover:bg-purple-600 text-white rounded-lg font-medium transition-all duration-200 shadow-md hover:shadow-lg">
                ↑ Top Center
            </button>
            <button wire:click="showTopRight"
                class="px-6 py-3 bg-purple-500 hover:bg-purple-600 text-white rounded-lg font-medium transition-all duration-200 shadow-md hover:shadow-lg">
                ↗ Top Right
            </button>
            <button wire:click="showBottomLeft"
                class="px-6 py-3 bg-purple-500 hover:bg-purple-600 text-white rounded-lg font-medium transition-all duration-200 shadow-md hover:shadow-lg">
                ↙ Bottom Left
            </button>
            <button wire:click="showBottomCenter"
                class="px-6 py-3 bg-purple-500 hover:bg-purple-600 text-white rounded-lg font-medium transition-all duration-200 shadow-md hover:shadow-lg">
                ↓ Bottom Center
            </button>
            <button wire:click="showBottomRight"
                class="px-6 py-3 bg-purple-500 hover:bg-purple-600 text-white rounded-lg font-medium transition-all duration-200 shadow-md hover:shadow-lg">
                ↘ Bottom Right
            </button>
        </div>
    </div>

    <!-- Duration & Progress -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 border border-gray-200 dark:border-gray-700">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6 flex items-center gap-2">
            <span>⏱️</span> Duration & Progress Bar
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <button wire:click="showQuickToast"
                class="px-6 py-3 bg-indigo-500 hover:bg-indigo-600 text-white rounded-lg font-medium transition-all duration-200 shadow-md hover:shadow-lg">
                Quick (2s)
            </button>
            <button wire:click="showNormalToast"
                class="px-6 py-3 bg-indigo-500 hover:bg-indigo-600 text-white rounded-lg font-medium transition-all duration-200 shadow-md hover:shadow-lg">
                Normal (5s)
            </button>
            <button wire:click="showLongToast"
                class="px-6 py-3 bg-indigo-500 hover:bg-indigo-600 text-white rounded-lg font-medium transition-all duration-200 shadow-md hover:shadow-lg">
                Long (10s)
            </button>
            <button wire:click="showNoProgressBar"
                class="px-6 py-3 bg-indigo-500 hover:bg-indigo-600 text-white rounded-lg font-medium transition-all duration-200 shadow-md hover:shadow-lg">
                No Progress
            </button>
        </div>
    </div>

    <!-- Hover & Interaction -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 border border-gray-200 dark:border-gray-700">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6 flex items-center gap-2">
            <span>👆</span> Hover & Interaction
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <button wire:click="showPauseOnHover"
                class="px-6 py-3 bg-teal-500 hover:bg-teal-600 text-white rounded-lg font-medium transition-all duration-200 shadow-md hover:shadow-lg">
                Pause on Hover ✓
            </button>
            <button wire:click="showNoPauseOnHover"
                class="px-6 py-3 bg-teal-500 hover:bg-teal-600 text-white rounded-lg font-medium transition-all duration-200 shadow-md hover:shadow-lg">
                No Pause on Hover
            </button>
            <button wire:click="showNoCloseOnClick"
                class="px-6 py-3 bg-teal-500 hover:bg-teal-600 text-white rounded-lg font-medium transition-all duration-200 shadow-md hover:shadow-lg">
                No Click Close
            </button>
        </div>
    </div>

    <!-- Advanced Features -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 border border-gray-200 dark:border-gray-700">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6 flex items-center gap-2">
            <span>✨</span> Advanced Features
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <button wire:click="showRtlToast"
                class="px-6 py-3 bg-cyan-500 hover:bg-cyan-600 text-white rounded-lg font-medium transition-all duration-200 shadow-md hover:shadow-lg">
                RTL Support 🌐
            </button>
            <button wire:click="showMultipleToasts"
                class="px-6 py-3 bg-cyan-500 hover:bg-cyan-600 text-white rounded-lg font-medium transition-all duration-200 shadow-md hover:shadow-lg">
                Multiple Stack 📚
            </button>
            <button wire:click="showLongMessage"
                class="px-6 py-3 bg-cyan-500 hover:bg-cyan-600 text-white rounded-lg font-medium transition-all duration-200 shadow-md hover:shadow-lg">
                Long Message 📝
            </button>
        </div>
    </div>

    <!-- Real-World Scenarios -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 border border-gray-200 dark:border-gray-700">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6 flex items-center gap-2">
            <span>🚀</span> Real-World Scenarios
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <button wire:click="simulateSave"
                class="px-6 py-3 bg-emerald-500 hover:bg-emerald-600 text-white rounded-lg font-medium transition-all duration-200 shadow-md hover:shadow-lg">
                💾 Save Action
            </button>
            <button wire:click="simulateDelete"
                class="px-6 py-3 bg-rose-500 hover:bg-rose-600 text-white rounded-lg font-medium transition-all duration-200 shadow-md hover:shadow-lg">
                🗑️ Delete Action
            </button>
            <button wire:click="simulateUpdate"
                class="px-6 py-3 bg-sky-500 hover:bg-sky-600 text-white rounded-lg font-medium transition-all duration-200 shadow-md hover:shadow-lg">
                🔄 Update Action
            </button>
            <button wire:click="simulateValidationError"
                class="px-6 py-3 bg-orange-500 hover:bg-orange-600 text-white rounded-lg font-medium transition-all duration-200 shadow-md hover:shadow-lg">
                ❌ Validation Error
            </button>
        </div>
    </div>

    <!-- Features List -->
    <div class="bg-gradient-to-br from-blue-500 via-purple-500 to-pink-500 rounded-lg shadow-lg p-8 text-white">
        <h2 class="text-2xl font-bold mb-6">✨ All Features Included</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <div class="flex items-center gap-3 bg-white/10 rounded-lg p-3 backdrop-blur-sm">
                <span class="text-2xl">✓</span>
                <span>Modern gradient UI</span>
            </div>
            <div class="flex items-center gap-3 bg-white/10 rounded-lg p-3 backdrop-blur-sm">
                <span class="text-2xl">✓</span>
                <span>Light & Dark Mode</span>
            </div>
            <div class="flex items-center gap-3 bg-white/10 rounded-lg p-3 backdrop-blur-sm">
                <span class="text-2xl">✓</span>
                <span>Progress Bar</span>
            </div>
            <div class="flex items-center gap-3 bg-white/10 rounded-lg p-3 backdrop-blur-sm">
                <span class="text-2xl">✓</span>
                <span>Pause on Hover</span>
            </div>
            <div class="flex items-center gap-3 bg-white/10 rounded-lg p-3 backdrop-blur-sm">
                <span class="text-2xl">✓</span>
                <span>Newest First</span>
            </div>
            <div class="flex items-center gap-3 bg-white/10 rounded-lg p-3 backdrop-blur-sm">
                <span class="text-2xl">✓</span>
                <span>Click to Close</span>
            </div>
            <div class="flex items-center gap-3 bg-white/10 rounded-lg p-3 backdrop-blur-sm">
                <span class="text-2xl">✓</span>
                <span>RTL Support</span>
            </div>
            <div class="flex items-center gap-3 bg-white/10 rounded-lg p-3 backdrop-blur-sm">
                <span class="text-2xl">✓</span>
                <span>6 Positions</span>
            </div>
            <div class="flex items-center gap-3 bg-white/10 rounded-lg p-3 backdrop-blur-sm">
                <span class="text-2xl">✓</span>
                <span>Smooth Animations</span>
            </div>
            <div class="flex items-center gap-3 bg-white/10 rounded-lg p-3 backdrop-blur-sm">
                <span class="text-2xl">✓</span>
                <span>Responsive Design</span>
            </div>
            <div class="flex items-center gap-3 bg-white/10 rounded-lg p-3 backdrop-blur-sm">
                <span class="text-2xl">✓</span>
                <span>Icon Animations</span>
            </div>
            <div class="flex items-center gap-3 bg-white/10 rounded-lg p-3 backdrop-blur-sm">
                <span class="text-2xl">✓</span>
                <span>Accessibility</span>
            </div>
        </div>
    </div>

    <!-- Usage Guide -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 border border-gray-200 dark:border-gray-700">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
            <span>📖</span> Quick Usage Guide
        </h2>
        <div class="space-y-4">
            <div class="bg-gray-50 dark:bg-gray-900 rounded-lg p-4 border border-gray-200 dark:border-gray-700">
                <h3 class="font-semibold text-lg mb-2 text-gray-900 dark:text-white">In Livewire Components:</h3>
                <pre class="bg-gray-800 text-gray-100 p-4 rounded overflow-x-auto text-sm"><code class="text-gray-200">use App\Traits\Livewire\WithNotification;

class YourComponent extends Component
{
    use WithNotification;

    public function save()
    {
        // Simple usage
        $this->toastSuccess('Saved successfully!');
        
        // With custom options
        $this->toastInfo('Hello!', [
            'position' => 'top-center',
            'duration' => 3000,
            'pauseOnHover' => true,
            'rtl' => false
        ]);
        
        // Different types
        $this->toastError('Something went wrong!');
        $this->toastWarning('Be careful!');
    }
}</code></pre>
            </div>

            <div class="bg-gray-50 dark:bg-gray-900 rounded-lg p-4 border border-gray-200 dark:border-gray-700">
                <h3 class="font-semibold text-lg mb-2 text-gray-900 dark:text-white">JavaScript (Direct):</h3>
                <pre class="bg-gray-800 p-4 rounded overflow-x-auto text-sm"><code class="text-gray-200">// Quick methods
window.toast.success('Success!');
window.toast.error('Error!');
window.toast.warning('Warning!');
window.toast.info('Info!');

// Advanced usage
window.toast.show({
    message: 'Custom toast',
    type: 'success',
    duration: 5000,
    position: 'bottom-right',
    pauseOnHover: true,
    progressBar: true,
    rtl: false
});</code></pre>
            </div>
        </div>
    </div>
</div>
