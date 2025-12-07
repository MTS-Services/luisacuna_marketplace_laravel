<?php

namespace App\Traits\Livewire;

trait WithNotification
{
    /**
     * Dispatch a toast notification
     */
    public function toast(
        string $message,
        string $type = 'info',
        int $duration = 5000,
        string $position = 'top-right',
        bool $dismissible = true,
        bool $pauseOnHover = true,
        bool $progressBar = true,
        bool $closeOnClick = true,
        bool $rtl = false
    ) {
        $this->dispatch('toast', [
            'message' => $message,
            'type' => $type,
            'duration' => $duration,
            'position' => $position,
            'dismissible' => $dismissible,
            'pauseOnHover' => $pauseOnHover,
            'progressBar' => $progressBar,
            'closeOnClick' => $closeOnClick,
            'rtl' => $rtl,
        ]);
    }

    /**
     * Show success toast
     */
    public function success(string $message, array $options = [])
    {
        $this->toast(
            message: $message,
            type: 'success',
            duration: $options['duration'] ?? 5000,
            position: $options['position'] ?? 'top-right',
            dismissible: $options['dismissible'] ?? true,
            pauseOnHover: $options['pauseOnHover'] ?? true,
            progressBar: $options['progressBar'] ?? true,
            closeOnClick: $options['closeOnClick'] ?? true,
            rtl: $options['rtl'] ?? false,
        );
    }

    /**
     * Show error toast
     */
    public function error(string $message, array $options = [])
    {
        $this->toast(
            message: $message,
            type: 'error',
            duration: $options['duration'] ?? 6000,
            position: $options['position'] ?? 'top-right',
            dismissible: $options['dismissible'] ?? true,
            pauseOnHover: $options['pauseOnHover'] ?? true,
            progressBar: $options['progressBar'] ?? true,
            closeOnClick: $options['closeOnClick'] ?? true,
            rtl: $options['rtl'] ?? false,
        );
    }

    /**
     * Show warning toast
     */
    public function warning(string $message, array $options = [])
    {
        $this->toast(
            message: $message,
            type: 'warning',
            duration: $options['duration'] ?? 5000,
            position: $options['position'] ?? 'top-right',
            dismissible: $options['dismissible'] ?? true,
            pauseOnHover: $options['pauseOnHover'] ?? true,
            progressBar: $options['progressBar'] ?? true,
            closeOnClick: $options['closeOnClick'] ?? true,
            rtl: $options['rtl'] ?? false,
        );
    }

    /**
     * Show info toast
     */
    public function info(string $message, array $options = [])
    {
        $this->toast(
            message: $message,
            type: 'info',
            duration: $options['duration'] ?? 5000,
            position: $options['position'] ?? 'top-right',
            dismissible: $options['dismissible'] ?? true,
            pauseOnHover: $options['pauseOnHover'] ?? true,
            progressBar: $options['progressBar'] ?? true,
            closeOnClick: $options['closeOnClick'] ?? true,
            rtl: $options['rtl'] ?? false,
        );
    }

    // Legacy notification methods (if you still need them)
    public function sweetSuccess(string $message, string $title = 'Success'): void
    {
        $this->dispatch('notify', type: 'success', title: $title, message: $message);
    }

    public function sweetError(string $message, string $title = 'Error'): void
    {
        $this->dispatch('notify', type: 'error', title: $title, message: $message);
    }

    public function sweetWarning(string $message, string $title = 'Warning'): void
    {
        $this->dispatch('notify', type: 'warning', title: $title, message: $message);
    }

    public function sweetInfo(string $message, string $title = 'Info'): void
    {
        $this->dispatch('notify', type: 'info', title: $title, message: $message);
    }
}