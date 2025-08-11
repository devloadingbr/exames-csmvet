/**
 * Toast Notification Store
 * Unified notification system for all areas (admin, client, etc.)
 */

import type { ToastStore } from '../../types/alpine';

interface QueuedToast {
    message: string;
    type: string;
    autoHide: boolean;
}

const toastStore: ToastStore = {
    // State
    show: false,
    message: '',
    type: 'success', // success, error, warning, info
    queue: [] as QueuedToast[],
    autoHide: true,
    timeout: null,

    /**
     * Show a toast notification
     * @param {string} message - Message to display
     * @param {string} type - Type of notification (success, error, warning, info)
     * @param {boolean} autoHide - Whether to auto-hide the notification
     */
    showToast(message: string, type: 'success' | 'error' | 'warning' | 'info' = 'success', autoHide: boolean = true): void {
        // If a toast is already showing, queue this one
        if (this.show) {
            this.queue.push({ message, type, autoHide });
            return;
        }

        this.message = message;
        this.type = type;
        this.autoHide = autoHide;
        this.show = true;

        // Clear any existing timeout
        if (this.timeout) {
            clearTimeout(this.timeout);
        }

        // Auto-hide if enabled
        if (autoHide) {
            this.timeout = setTimeout(() => {
                this.hide();
            }, 4000) as any;
        }
    },

    /**
     * Hide the current toast and show next in queue
     */
    hide(): void {
        this.show = false;
        
        // Clear timeout
        if (this.timeout) {
            clearTimeout(this.timeout);
            this.timeout = null;
        }

        // Show next toast in queue after a short delay
        if (this.queue.length > 0) {
            setTimeout(() => {
                const next = this.queue.shift();
                this.showToast(next.message, next.type, next.autoHide);
            }, 300);
        }
    },

    /**
     * Quick methods for different types
     */
    success(message: string): void {
        this.showToast(message, 'success');
    },

    error(message: string): void {
        this.showToast(message, 'error');
    },

    warning(message: string): void {
        this.showToast(message, 'warning');
    },

    info(message: string): void {
        this.showToast(message, 'info');
    },

    /**
     * Clear all queued notifications
     */
    clearQueue(): void {
        this.queue = [];
    }
};

export default toastStore;