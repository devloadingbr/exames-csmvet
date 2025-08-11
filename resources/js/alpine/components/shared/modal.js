/**
 * Shared Modal Component
 * Reusable modal functionality
 */

import Alpine from 'alpinejs';

Alpine.data('sharedModal', (options = {}) => ({
    show: false,
    
    /**
     * Open the modal
     */
    open() {
        this.show = true;
        document.body.classList.add('overflow-hidden');
        
        // Focus trap - basic implementation
        this.$nextTick(() => {
            const focusableElements = this.$el.querySelectorAll(
                'button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])'
            );
            if (focusableElements.length > 0) {
                focusableElements[0].focus();
            }
        });
    },
    
    /**
     * Close the modal
     */
    close() {
        this.show = false;
        document.body.classList.remove('overflow-hidden');
    },
    
    /**
     * Handle escape key
     */
    handleEscape() {
        if (options.escapable !== false) {
            this.close();
        }
    },
    
    /**
     * Handle backdrop click
     */
    handleBackdrop() {
        if (options.backdropClose !== false) {
            this.close();
        }
    }
}));