import iziToast from 'izitoast';
import 'izitoast/dist/css/iziToast.min.css';

// Enhanced Toast Manager Class
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
            resetOnHover: false, // Don't reset - just pause
            pauseOnHover: true,  // Pause on hover
            transitionIn: 'bounceInLeft',
            transitionOut: 'fadeOutRight',
            transitionInMobile: 'bounceInLeft',
            transitionOutMobile: 'fadeOutRight',
            progressBar: true,
            progressBarEasing: 'linear',
            close: true,
            closeOnClick: true,  // Close on click by default
            closeOnEscape: true,
            displayMode: 0, // Stack mode - show multiple toasts
            layout: 1,
            drag: true,
            position: 'topRight',
            animateInside: true,
            theme: 'light',
            iconColor: 'white',
        });
    }

    getPositionValue(position) {
        const positions = {
            'top-right': 'topRight',
            'top-left': 'topLeft',
            'top-center': 'topCenter',
            'bottom-right': 'bottomRight',
            'bottom-left': 'bottomLeft',
            'bottom-center': 'bottomCenter',
            'center': 'center'
        };
        return positions[position] || 'topRight';
    }

    getTransitionIn(position) {
        const transitions = {
            'topRight': 'bounceInLeft',
            'topLeft': 'bounceInRight',
            'topCenter': 'fadeInDown',
            'bottomRight': 'bounceInLeft',
            'bottomLeft': 'bounceInRight',
            'bottomCenter': 'fadeInUp',
            'center': 'fadeIn'
        };
        return transitions[position] || 'bounceInLeft';
    }

    getTransitionOut(position) {
        const transitions = {
            'topRight': 'fadeOutRight',
            'topLeft': 'fadeOutLeft',
            'topCenter': 'fadeOutUp',
            'bottomRight': 'fadeOutRight',
            'bottomLeft': 'fadeOutLeft',
            'bottomCenter': 'fadeOutDown',
            'center': 'fadeOut'
        };
        return transitions[position] || 'fadeOutRight';
    }

    show(options) {
        const {
            message,
            type = 'info',
            title = '',
            duration = 5000,
            position = 'top-right',
            pauseOnHover = true,
            progressBar = true,
            closeOnClick = true,
            dismissible = true,
            rtl = false,
            buttons = [],
            balloon = false,
            image = '',
            imageWidth = 50,
            displayMode = 0,
            layout = 1,
            theme = this.isDarkMode ? 'dark' : 'light'
        } = options;

        const positionValue = this.getPositionValue(position);

        const config = {
            title: title,
            message: message,
            color: type === 'success' ? 'green' :
                type === 'error' ? 'red' :
                    type === 'warning' ? 'yellow' :
                        type === 'info' ? 'blue' : 'blue',
            theme: theme,
            icon: type === 'success' ? 'ico-success' :
                type === 'error' ? 'ico-error' :
                    type === 'warning' ? 'ico-warning' :
                        type === 'info' ? 'ico-info' : 'ico-info',
            iconColor: 'white',
            timeout: duration,
            position: positionValue,
            pauseOnHover: pauseOnHover,
            resetOnHover: false, // IMPORTANT: Don't reset on hover
            progressBar: progressBar,
            progressBarColor: 'rgba(255, 255, 255, 0.7)',
            close: dismissible,
            closeOnClick: closeOnClick,
            closeOnEscape: true,
            rtl: rtl,
            drag: true,
            displayMode: displayMode, // 2 = stack, 1 = replace
            layout: layout,
            balloon: balloon,
            animateInside: true,
            transitionIn: this.getTransitionIn(positionValue),
            transitionOut: this.getTransitionOut(positionValue),
            image: image,
            imageWidth: imageWidth,
            maxWidth: 500,
            zindex: 99999,
            onOpening: function (instance, toast) {
                // Ensure newest toasts appear at the top for stack mode
                // if (displayMode === 2) {
                //     const wrapper = toast.parentNode;
                //     if (wrapper && wrapper.firstChild !== toast) {
                //         wrapper.insertBefore(toast, wrapper.firstChild);
                //     }
                // }
                const wrapper = toast.parentNode;
                if (wrapper && wrapper.firstChild !== toast) {
                    wrapper.insertBefore(toast, wrapper.firstChild);
                }
            }
        };

        // Add buttons if provided
        if (buttons && buttons.length > 0) {
            config.buttons = buttons.map(btn => [
                `<button><b>${btn.text}</b></button>`,
                (instance, toast) => {
                    if (btn.onClick) btn.onClick();
                    if (btn.close !== false) {
                        instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                    }
                },
                btn.focus || false
            ]);
        }

        // Show the toast
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

    question(options = {}) {
        const {
            title = 'Question',
            message = 'Are you sure?',
            position = 'center',
            timeout = false,
            closeOnEscape = false,
            overlay = true,
            ...rest
        } = options;

        this.show({
            ...rest,
            title,
            message,
            type: 'info',
            position,
            duration: timeout === false ? 0 : timeout,
            closeOnEscape,
            balloon: false,
            layout: 2,
            displayMode: 0,
            closeOnClick: false,
            buttons: options.buttons || [
                ['<button><b>YES</b></button>', (instance, toast) => {
                    if (options.onConfirm) options.onConfirm();
                    instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                }, true],
                ['<button>NO</button>', (instance, toast) => {
                    if (options.onCancel) options.onCancel();
                    instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                }],
            ]
        });
    }

    dismiss() {
        iziToast.destroy();
    }

    hide(toast, options = {}) {
        const { transitionOut = 'fadeOut' } = options;
        iziToast.hide(options, toast);
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
            title: data.title || '',
            type: data.type || 'info',
            duration: data.duration || 5000,
            position: data.position || 'top-right',
            pauseOnHover: data.pauseOnHover !== undefined ? data.pauseOnHover : true,
            progressBar: data.progressBar !== undefined ? data.progressBar : true,
            closeOnClick: data.closeOnClick !== undefined ? data.closeOnClick : true,
            dismissible: data.dismissible !== undefined ? data.dismissible : true,
            rtl: data.rtl || false,
            balloon: data.balloon || false,
            buttons: data.buttons || [],
            image: data.image || '',
            imageWidth: data.imageWidth || 50,
            displayMode: data.displayMode !== undefined ? data.displayMode : 0, // Stack by default
            layout: data.layout !== undefined ? data.layout : 2,
            // theme: data.theme || (toastManager.isDarkMode ? 'dark' : 'light'),
            theme: 'light'
        });
    });
});

export default toastManager;