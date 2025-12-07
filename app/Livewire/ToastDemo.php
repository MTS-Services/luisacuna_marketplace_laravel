<?php

namespace App\Livewire;

use App\Traits\Livewire\WithNotification;
use Livewire\Component;

class ToastDemo extends Component
{
    use WithNotification;

    // ==========================================
    // Basic Toast Types
    // ==========================================
    
    public function showSuccessToast()
    {
        $this->success('✓ Operation completed successfully!');
    }

    public function showErrorToast()
    {
        $this->error('✕ Something went wrong! Please try again.');
    }

    public function showWarningToast()
    {
        $this->warning('⚠ Warning: This action cannot be undone!');
    }

    public function showInfoToast()
    {
        $this->info('ℹ Did you know? Hover over me to pause the timer!');
    }

    // ==========================================
    // Position Demonstrations
    // ==========================================
    
    public function showTopLeft()
    {
        $this->success('Toast from Top Left', ['position' => 'top-left']);
    }

    public function showTopCenter()
    {
        $this->info('Toast from Top Center', ['position' => 'top-center']);
    }

    public function showTopRight()
    {
        $this->success('Toast from Top Right', ['position' => 'top-right']);
    }

    public function showBottomLeft()
    {
        $this->warning('Toast from Bottom Left', ['position' => 'bottom-left']);
    }

    public function showBottomCenter()
    {
        $this->error('Toast from Bottom Center', ['position' => 'bottom-center']);
    }

    public function showBottomRight()
    {
        $this->success('Toast from Bottom Right', ['position' => 'bottom-right']);
    }

    // ==========================================
    // Duration & Progress Bar
    // ==========================================
    
    public function showQuickToast()
    {
        $this->info('⚡ Quick toast - Disappears in 2 seconds!', ['duration' => 2000]);
    }

    public function showNormalToast()
    {
        $this->info('⏱️ Normal toast - 5 seconds duration', ['duration' => 5000]);
    }

    public function showLongToast()
    {
        $this->warning('🕐 Long toast - Takes 10 seconds to disappear', ['duration' => 10000]);
    }

    public function showNoProgressBar()
    {
        $this->info('No progress bar on this toast', ['progressBar' => false, 'duration' => 5000]);
    }

    // ==========================================
    // Hover & Interaction
    // ==========================================
    
    public function showPauseOnHover()
    {
        $this->info('👆 Hover over me to pause the timer!', [
            'pauseOnHover' => true,
            'duration' => 5000
        ]);
    }

    public function showNoPauseOnHover()
    {
        $this->warning('⏩ Hovering won\'t pause this toast', [
            'pauseOnHover' => false,
            'duration' => 5000
        ]);
    }

    public function showNoCloseOnClick()
    {
        $this->info('🔒 Clicking won\'t close me - use the X button!', [
            'closeOnClick' => false,
            'duration' => 7000
        ]);
    }

    // ==========================================
    // Advanced Features
    // ==========================================
    
    public function showRtlToast()
    {
        $this->success('مرحبا! هذا إشعار باللغة العربية 🌐', ['rtl' => true]);
    }

    public function showMultipleToasts()
    {
        // Show multiple toasts - newest will appear first
        $this->success('1️⃣ First toast - Success!');
        
        $this->dispatch('toast', [
            'message' => '2️⃣ Second toast - Info',
            'type' => 'info',
            'duration' => 5000,
        ]);

        $this->dispatch('toast', [
            'message' => '3️⃣ Third toast - Warning',
            'type' => 'warning',
            'duration' => 5000,
        ]);

        $this->dispatch('toast', [
            'message' => '4️⃣ Fourth toast - Notice the newest appear at top!',
            'type' => 'success',
            'duration' => 6000,
        ]);
    }

    public function showLongMessage()
    {
        $this->info(
            '📝 This is a very long toast message to demonstrate how the toast handles extensive content. ' .
            'The toast will automatically adjust its height and properly wrap the text across multiple lines. ' .
            'This ensures excellent readability even with longer notifications that contain important information. ' .
            'The modern design makes sure everything looks clean and professional!'
        );
    }

    // ==========================================
    // Real-World Scenarios
    // ==========================================
    
    public function simulateSave()
    {
        // Simulate processing delay
        sleep(1);
        $this->success('💾 Your changes have been saved successfully!');
    }

    public function simulateDelete()
    {
        $this->error('🗑️ Item has been deleted permanently!', ['duration' => 6000]);
    }

    public function simulateUpdate()
    {
        $this->info('🔄 Profile updated! Changes may take a few minutes to reflect.', [
            'duration' => 6000
        ]);
    }

    public function simulateValidationError()
    {
        $this->error('❌ Validation failed: Please fill in all required fields before submitting.', [
            'duration' => 7000
        ]);
    }

    public function render()
    {
        return view('livewire.toast-demo');
    }
}