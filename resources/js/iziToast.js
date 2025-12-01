import iziToast from 'izitoast';
import 'izitoast/dist/css/iziToast.min.css';

// Modern Toast Manager Class
class ToastManager {
    constructor() {
        this.isDarkMode = this.detectDarkMode();
        this.setupDarkModeListener();
        this.configureDefaults();
    }

    detectDarkMode() {
        return document.documentElement.classList.contains('dark') ||
            window.matchMedia('(prefers-color-scheme: dark)').matches;
    }

    setupDarkModeListener() {
        const observer = new MutationObserver(() => {
            this.isDarkMode = this.detectDarkMode();
        });

        observer.observe(document.documentElement, {
            attributes: true,
            attributeFilter: ['class']
        });

        window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', (e) => {
            this.isDarkMode = e.matches;
        });
    }

    configureDefaults() {
        iziToast.settings({
            timeout: 5000,
            resetOnHover: false,
            pauseOnHover: true, // Stop progress on hover
            transitionIn: 'fadeInDown',
            transitionOut: 'fadeOut',
            transitionInMobile: 'fadeInUp',
            transitionOutMobile: 'fadeOutDown',
            progressBar: true,
            progressBarEasing: 'linear',
            close: true,
            closeOnClick: true,
            closeOnEscape: true,
            displayMode: 0, // 0 = normal stacking (newest first)
            layout: 1,
            maxWidth: 500,
            animateInside: true,
            drag: true,
            position: 'topRight',
        });
    }

    getToastClass(type) {
        const classes = {
            success: 'modern-toast toast-success',
            error: 'modern-toast toast-error',
            warning: 'modern-toast toast-warning',
            info: 'modern-toast toast-info'
        };
        return classes[type] || classes.info;
    }

    getIcon(type) {
        const icons = {
            success: '✓',
            error: '✕',
            warning: '⚠',
            info: 'ℹ'
        };
        return icons[type] || icons.info;
    }

    getPositionValue(position) {
        const positions = {
            'top-right': 'topRight',
            'top-left': 'topLeft',
            'top-center': 'topCenter',
            'bottom-right': 'bottomRight',
            'bottom-left': 'bottomLeft',
            'bottom-center': 'bottomCenter'
        };
        return positions[position] || 'topRight';
    }

    show(options) {
        const {
            message,
            type = 'info',
            duration = 5000,
            position = 'top-right',
            pauseOnHover = true,
            progressBar = true,
            closeOnClick = true,
            dismissible = true,
            rtl = false
        } = options;

        const config = {
            class: this.getToastClass(type),
            message: message,
            iconText: this.getIcon(type),
            timeout: duration,
            position: this.getPositionValue(position),
            pauseOnHover: pauseOnHover,
            resetOnHover: false,
            progressBar: progressBar,
            progressBarColor: 'rgba(255, 255, 255, 0.8)',
            close: dismissible,
            closeOnClick: closeOnClick,
            closeOnEscape: true,
            rtl: rtl,
            drag: true,
            displayMode: 0, // Newest first (normal stacking)
            transitionIn: position.startsWith('top') ? 'fadeInDown' : 'fadeInUp',
            transitionOut: 'fadeOut',
            onOpening: function(instance, toast) {
                // Ensure newest toasts appear at the top
                const wrapper = toast.parentNode;
                if (wrapper && wrapper.firstChild !== toast) {
                    wrapper.insertBefore(toast, wrapper.firstChild);
                }
            }
        };

        // Show the toast using the base show method
        iziToast.show(config);
    }

    success(message, options = {}) {
        this.show({ ...options, message, type: 'success' });
    }

    error(message, options = {}) {
        this.show({ ...options, message, type: 'error' });
    }

    warning(message, options = {}) {
        this.show({ ...options, message, type: 'warning' });
    }

    info(message, options = {}) {
        this.show({ ...options, message, type: 'info' });
    }

    dismiss() {
        iziToast.destroy();
    }
}

// Initialize Toast Manager
const toastManager = new ToastManager();
window.toast = toastManager;

// Livewire Integration
document.addEventListener('livewire:init', () => {
    Livewire.on('toast', (event) => {
        const data = Array.isArray(event) ? event[0] : event;

        toastManager.show({
            message: data.message,
            type: data.type || 'info',
            duration: data.duration || 5000,
            position: data.position || 'top-right',
            pauseOnHover: data.pauseOnHover !== undefined ? data.pauseOnHover : true,
            progressBar: data.progressBar !== undefined ? data.progressBar : true,
            closeOnClick: data.closeOnClick !== undefined ? data.closeOnClick : true,
            dismissible: data.dismissible !== undefined ? data.dismissible : true,
            rtl: data.rtl || false,
        });
    });
});

export default toastManager;